<?php

namespace App\Http\Livewire\Estimate\datatable\PowerGrid;

use Illuminate\Support\Carbon;
use App\Models\EstimatePrepare;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class EstimateDataTable extends PowerGridComponent
{
    use ActionButton;

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

    /**
    * PowerGrid datasource.
    *
    * @return Builder<\App\Models\EstimatePrepare>
    */
    public function datasource(): Builder
    {
        return EstimatePrepare::query()
        ->select(
            'estimate_masters.id',
            'estimate_masters.estimate_id',
            'estimate_prepares.total_amount',
            'estimate_statuses.status',
            DB::raw('ROW_NUMBER() OVER (ORDER BY estimate_masters.id) as serial_no'),
            )
        ->join('estimate_user_assign_records','estimate_user_assign_records.estimate_id','=','estimate_prepares.estimate_id')
            ->join('estimate_masters','estimate_masters.estimate_id','=','estimate_prepares.estimate_id')
            ->join('estimate_statuses','estimate_statuses.id','=','estimate_masters.status')
            ->where('estimate_user_assign_records.estimate_user_type','=',4)
            ->where(function ($query) {
                $query->where('estimate_masters.status', '=', 1)
                      ->orWhere('estimate_masters.status', '=', 5);
            })
            ->where('operation', 'Total')
            ->where('created_by',Auth::user()->id);;
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
        ->addColumn('id')
        ->addColumn('estimate_masters.estimate_id')
        ->addColumn('SOR.sorMasterDesc')
        ->addColumn('total_amount')
        ->addColumn('SOR.getEstimateStatus.status',function ($row){
            return '<span class="badge badge-pill bg-success">'.$row->status.'</span>';
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
        return [
            Column::make('Sl.No', 'serial_no'),

            Column::make('ESTIMATE NO', 'estimate_id')
                ->makeInputRange(),

            Column::make('DESCRIPTION', 'SOR.sorMasterDesc'),

            Column::make('TOTAL AMOUNT', 'total_amount')
                ->makeInputRange()
                ->sortable(),

            Column::make('Status', 'SOR.getEstimateStatus.status')
            ->sortable(),

        ]
;
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


    public function actions(): array
    {
       return [
        Button::add('View')
        ->bladeComponent('view', ['id' => 'estimate_id']),
    Button::add('Forward')
        ->bladeComponent('forward-button', ['id' => 'estimate_id']),
    Button::add('Edit')
    ->bladeComponent('edit-button', ['id' => 'estimate_id','action'=>'edit']),
        ];
    }


    public function edit($id)
    {
        $this->emit('openForm', ['formType'=>'edit', 'id'=>$id]);
    }
    public function view($estimate_id)
    {
        $this->emit('openModal', $estimate_id);
    }
    public function forward($estimate_id)
    {
        $this->emit('openForwardModal',['estimate_id'=>$estimate_id,'forward_from'=>'EP']);
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

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($estimate-prepare) => $estimate-prepare->id === 1)
                ->hide(),
        ];
    }
    */
}
