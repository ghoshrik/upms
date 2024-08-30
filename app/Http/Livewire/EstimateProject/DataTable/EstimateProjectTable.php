<?php

namespace App\Http\Livewire\EstimateProject\DataTable;

use App\Models\EstimateFlow;
use App\Models\SorMaster;
use Illuminate\Support\Carbon;
use App\Models\EstimatePrepare;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};
use WireUi\Traits\Actions;

final class EstimateProjectTable extends PowerGridComponent
{
    use ActionButton,Actions;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    public function datasource(): Builder
    {
        $data = EstimatePrepare::query()
            ->select(
                'sor_masters.id',
                'sor_masters.estimate_id',
                'estimate_prepares.total_amount',
                'estimate_statuses.status',
                'permissions.name',
                'estimate_flows.sequence_no',
                DB::raw('ROW_NUMBER() OVER (ORDER BY sor_masters.id) as serial_no')
            )
            ->join('sor_masters', 'sor_masters.estimate_id', '=', 'estimate_prepares.estimate_id')
            ->join('estimate_flows', 'sor_masters.estimate_id', '=', 'estimate_flows.estimate_id')
            ->join('estimate_statuses','estimate_statuses.id','=','sor_masters.status')
            ->join('permissions','permissions.id','=','estimate_flows.permission_id')
            ->whereNotNull('estimate_flows.associated_at')
            ->where('estimate_flows.user_id', Auth::user()->id)
            ->where('estimate_prepares.operation','=','Total')
            ->where('sor_masters.associated_with',Auth::user()->id)
            ->groupBy(
                'sor_masters.estimate_id',
                        'sor_masters.id',
                        'estimate_prepares.total_amount',
                        'permissions.name',
                        'estimate_statuses.status',
                        'estimate_flows.sequence_no');

//            dd($data->toSql());

        return $data;
//        return SorMaster::query()
//                ->select(
//                    'sor_masters.id',
//                    'sor_masters.estimate_id',
//                    'sor_masters.sorMasterDesc',
//                    'sor_masters.status',
//                    DB::raw('ROW_NUMBER() OVER (ORDER BY sor_masters.id) as serial_no')
//                )
//            ->join('estimate_prepares',function($join)
//            {
//                $join->on('sor_masters.estimate_id','=','estimate_prepares.estimate_id')
//                    ->where('estimate_prepares.operation','=','Total');
//            })
//            ->Join('estimate_statuses','sor_masters.status','=','estimate_statuses.id')
//            ->Join('estimate_flows','estimate_flows.estimate_id','=','sor_masters.estimate_id')
//            ->where('sor_masters.created_by',Auth::user()->id)
//            ->groupBy('sor_masters.id','sor_masters.estimate_id','sor_masters.sorMasterDesc','sor_masters.status','estimate_flows.sequence_no')
//            ->orderBy('estimate_flows.sequence_no');

//        return $this->fetchFlows();



    }


    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('serial_no')
            ->addColumn('sor_masters.estimate_id')

            ->addColumn('SOR.sorMasterDesc')
            ->addColumn('total_amount')
            // ->addColumn('total_amount', function ($row) {
            //     return round($row->total_amount, 2);
            // })
            ->addColumn('name')
            ->addColumn('status', function ($row) {
                return '<span class="badge badge-pill bg-success">' . $row->status . '</span>';
            });
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        $permissions = collect([
            'create estimate' => 'Maker',
            'verify estimate' => 'Checker',
            'approve estimate' => 'Approver',
        ]);
        return [
            Column::make('Sl.No', 'serial_no'),

            Column::make('ESTIMATE NO', 'estimate_id')
                // ->makeInputRange()
                ->searchable(),

            Column::make('DESCRIPTION', 'SOR.sorMasterDesc')
                ->headerAttribute('style', 'white-space: normal; word-wrap: break-word; word-break: break-word; overflow-wrap: break-word;')
                ->bodyAttribute('style', 'white-space: normal; word-wrap: break-word; word-break: break-word; overflow-wrap: break-word;'),

            Column::make('Total','total_amount'),
            // Column::make('TOTAL AMOUNT', 'total_amount')
            //     ->makeInputRange()
            //     ->sortable(),

            Column::make('Status', 'status')
                ->sortable(),
            Column::make('Stage','name'),
            // Column::make("Actions", "estimate_id"),

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid EstimatePrepare Action Buttons.
     *
     * @return array<int, Button>
     */
    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(),
            [
                'openApproveModal',
                'RejectEstimate'
            ]
        );
    }
    public $canPermission;

    public function actions(): array
    {
        return [
            Button::add('View')
                ->bladeComponent('view', ['id' => 'estimate_id']),

            Button::add('forward')
             ->bladeComponent('forwd-button', ['id' => 'estimate_id']),
//                ->can($this->canPermission['forward']),

            Button::add('approve')
                ->bladeComponent('approve-button',['id'=>'estimate_id','action'=>'approveEstimate']),

            Button::add('Edit')
                ->bladeComponent('edit-button', ['id' => 'estimate_id', 'action' => 'edit']),
//                ->when(fn($row)=>in_array($row->sequence_no,[1,2])),
//                ->can($this->canPermission['forward']),
            Button::add('Revert')
                ->bladeComponent('revert-component',['id'=>'estimate_id','action'=>'reverted'])
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid EstimatePrepare Action Rules.
     *
     * @return array<int, RuleActions>
     */


        public function actionRules(): array
        {
       return [
           Rule::button('forward')
                ->when(fn($estimate)=>$this->canForward($estimate->estimate_id))
                ->bladeComponent('forwd-button', ['id' => 'estimate_id']),
           Rule::button('approve')
                ->when(fn($estimate)=>$this->canApprove($estimate->estimate_id))
                ->bladeComponent('approve-button',['action'=>'approveEstimate','id'=>'estimate_id']),

           Rule::button('Edit')
               ->when(fn($row) => $this->canEdit($row))
                ->hide(),
           Rule::button('Revert')
               ->when(fn($row)=>$row->sequence_no===1)
                ->hide()
        ];
    }

    private function canForward($estimateId)
    {
        $estimateFlows = EstimateFlow::where('estimate_id', $estimateId)
            ->orderBy('sequence_no')
            ->get();

        $currentSequenceNo = $estimateFlows->max('sequence_no');

        return $currentSequenceNo;
    }
    private function canApprove($estimateId)
    {
        $estimateFlows = EstimateFlow::where('estimate_id', $estimateId)
            ->orderBy('sequence_no')
            ->get();

        $currentSequenceNo = $estimateFlows->max('sequence_no');
        return $currentSequenceNo;
    }
    private function canEdit($estimate)
    {
        return !in_array($estimate->sequence_no,[1,2]);
    }
    public function view($estimate_id)
    {
        $this->emit('openModal', $estimate_id);
    }
    public function forward($estimate_id)
    {
        $this->emit('openForwardModal', ['estimate_id' => $estimate_id]);
    }
    public function edit($id)
    {
        $this->emit('openForm', ['formType' => 'edit', 'id' => $id]);
    }

    public function openApproveModal($estimate_id)
    {
//            dd($estimate_id);
        $this->dialog()->confirm([
            'title' => 'Are you Sure want to Approved Estimate ?',
            'icon' => 'warning',
            'accept' => [
                'label' => 'Yes,Approved',
                'method' => 'ApprovedEstimate',
                'params' => $estimate_id,
            ],
            'reject' => [
                'label' => 'No, Reject',
                // 'method' => 'cancel',
            ]
        ]);
    }
    public function ApprovedEstimate($estimate_id)
    {
        SorMaster::where('estimate_id',$estimate_id)
            ->where('associated_with',Auth::user()->id)
            ->update(['approved_at'=>Carbon::now(),'status'=>6,'is_verified'=>1]);
        EstimateFlow::where('estimate_id',$estimate_id)
            ->where('user_id',Auth::user()->id)
            ->whereNull('dispatch_at')
            ->update(['dispatch_at'=>Carbon::now()]);
    }
    public function fetchFlows()
    {
        $estimates = SorMaster::query()
                                ->select(
                                        'sor_masters.estimate_id',
                                        'sor_masters.sorMasterDesc',
                                        'sor_masters.status'
                                       )
                                ->leftjoin('estimate_prepares','sor_masters.estimate_id','=','estimate_prepares.estimate_id')
                                ->leftJoin('estimate_statuses','sor_masters.status','=','estimate_statuses.id')
                                ->where('sor_masters.created_by',Auth::user()->id);

        $flowsData =[];
        foreach ($estimates as $estimate) {
            $flows = EstimateFlow::where('estimate_id', $estimate->estimate_id)
                ->orderBy('sequence_no')
                ->get();

            // Add additional sequence control logic
            foreach ($flows as $index => $flow) {
                $flow->sorMasterDesc = $estimate->sorMasterDesc;
                $flow->total_amount = $estimate->total_amount;
                $flow->status = $estimate->status;
                $flow->previous_sequence = $flows[$index - 1]->sequence_no ?? null;
                $flow->next_sequence = $flows[$index + 1]->sequence_no ?? null;
                $flow->max_sequence_no = $flows->max('sequence_no');
                $flowsData[] = $flow;
            }
        }

        return collect($flowsData);
    }

}
