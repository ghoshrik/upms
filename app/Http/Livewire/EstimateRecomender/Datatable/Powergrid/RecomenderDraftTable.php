<?php

namespace App\Http\Livewire\EstimateRecomender\Datatable\Powergrid;

use App\Models\Esrecommender;
use App\Models\EstimatePrepare;
use App\Models\EstimateStatus;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\Rule;

final class RecomenderDraftTable extends PowerGridComponent
{
    use ActionButton;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): void
    {
        $this->showCheckBox()
            ->showPerPage()
            ->showSearchInput()
            ->showExportOption('download', ['excel', 'csv']);
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\EstimatePrepare>|null
    */
    public function datasource(): ?Builder
    {
        return EstimatePrepare::query()
        ->select(
            'estimate_prepares.id',
            'estimate_prepares.estimate_id',
            'estimate_prepares.operation',
            'estimate_prepares.total_amount',
            'estimate_prepares.created_by',
            'estimate_user_assign_records.estimate_id as user_assign_records_estimate_id',
            'estimate_user_assign_records.estimate_user_type',
            'estimate_user_assign_records.estimate_user_id',
            'estimate_user_assign_records.estimate_user_type',
            'estimate_user_assign_records.comments',
            'sor_masters.estimate_id as sor_masters_estimate_id',
            'sor_masters.sorMasterDesc',
            'sor_masters.status'
        )
        ->join('estimate_user_assign_records','estimate_user_assign_records.estimate_id','=','estimate_prepares.estimate_id')
        ->join('sor_masters','sor_masters.estimate_id','=','estimate_prepares.estimate_id')
        ->where('estimate_user_assign_records.estimate_user_id','=',Auth::user()->id)
        ->where('estimate_user_assign_records.estimate_user_type','=',1)
        ->where('sor_masters.is_verified','=',0)
        ->where('sor_masters.status','!=',9)
        ->where('sor_masters.status','!=',11)
        ->where('sor_masters.status','!=',3)
        ->where('operation', 'Total');
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
    */
    public function addColumns(): ?PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('estimate_id')
            ->addColumn('sorMasterDesc')
            ->addColumn('total_amount', fn ($model)=>  round($model->total_amount, 10, 2))
            ->addColumn('recomender_cost',function($model){
                $recomenderCost = Esrecommender::where('estimate_id',$model->estimate_id)->where('operation', 'Total')->first();
                $recomenderCost = ($recomenderCost)?$recomenderCost->total_amount:'';
                return $recomenderCost;
            })
            ->addColumn('status',function ($model){
                $statusName =EstimateStatus::where('id',$model->status)->select('status')->first();
                $statusName = $statusName->status;
                return '<span class="badge bg-soft-info fs-6"><x-lucide-eye class="w-4 h-4 text-gray-500" />'.$statusName.'</span>';
            })
            ->addColumn('comments');
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
            Column::add()
                ->title('ESTIMATE ID')
                ->field('estimate_id')
                ->sortable()
                ->searchable(),
            Column::add()
                ->title('DESCRIPTION')
                ->field('sorMasterDesc')
                ->searchable(),
            Column::add()
                ->title('ESTIMATOR COST')
                ->field('total_amount')
                ->makeInputRange(),
            Column::add()
                ->title('RECOMENDER COST')
                ->field('recomender_cost')
                ->makeInputRange(),
            Column::add()
                ->title('STATUS')
                ->field('status')
                ->searchable(),
            Column::add()
                ->title('COMMENTS')
                ->field('comments'),

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
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */


    public function actions(): array
    {
        return [
            Button::add('view')
                ->caption('View')
                ->class('btn btn-soft-primary btn-sm')
                ->emit('openModal', ['estimate_id']),
            Button::add('approve')
                ->caption('Approve')
                ->class('btn btn-soft-primary btn-sm')
                ->emit('openApproveModal', ['id'=>'estimate_id']),
            Button::add('revert')
                ->caption('Revert')
                ->class('btn btn-soft-primary btn-sm')
                ->emit('openRevertModal', ['id'=>'estimate_id']),
            Button::add('forward')
                ->bladeComponent('',[])
                ->caption('Forward')

                // ->class('btn btn-soft-primary btn-sm')
                // ->emit('openForm', ['id'=>'estimate_id'])
                ,
            Button::add('modify')
                ->caption('Modify')
                ->class('btn btn-soft-primary btn-sm')
                ->emit('openForm', ['formType'=>'modify', 'id'=>'estimate_id']),
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
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */


    // public function actionRules(): array
    // {
    //    return [
    //         Rule::button('forward')
    //             ->when(fn($model) => $model->status == 2 || $model->status == 4)
    //             ->hide(),
    //     ];

    // }


    /*
    |--------------------------------------------------------------------------
    | Edit Method
    |--------------------------------------------------------------------------
    | Enable the method below to use editOnClick() or toggleable() methods.
    | Data must be validated and treated (see "Update Data" in PowerGrid doc).
    |
    */

     /**
     * PowerGrid EstimatePrepare Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = EstimatePrepare::query()
                ->update([
                    $data['field'] => $data['value'],
                ]);
       } catch (QueryException $exception) {
           $updated = false;
       }
       return $updated;
    }

    public function updateMessages(string $status = 'error', string $field = '_default_message'): string
    {
        $updateMessages = [
            'success'   => [
                '_default_message' => __('Data has been updated successfully!'),
                //'custom_field'   => __('Custom Field updated successfully!'),
            ],
            'error' => [
                '_default_message' => __('Error updating the data.'),
                //'custom_field'   => __('Error updating custom field.'),
            ]
        ];

        $message = ($updateMessages[$status][$field] ?? $updateMessages[$status]['_default_message']);

        return (is_string($message)) ? $message : 'Error!';
    }
    */
}
