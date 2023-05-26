<?php

namespace App\Http\Livewire\Estimate\datatable;

use App\Models\EstimatePrepare;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
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
        return EstimatePrepare::query();
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
            ->addColumn('estimate_id')
            ->addColumn('dept_id')
            ->addColumn('category_id')
            ->addColumn('row_id')
            ->addColumn('row_index')

           /** Example of custom column using a closure **/
            ->addColumn('row_index_lower', function (EstimatePrepare $model) {
                return strtolower(e($model->row_index));
            })

            ->addColumn('sor_item_number')
            ->addColumn('estimate_no')
            ->addColumn('item_name')
            ->addColumn('other_name')
            ->addColumn('qty')
            ->addColumn('rate')
            ->addColumn('total_amount')
            ->addColumn('operation')
            ->addColumn('created_by')
            ->addColumn('comments')
            ->addColumn('created_at_formatted', fn (EstimatePrepare $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
            ->addColumn('updated_at_formatted', fn (EstimatePrepare $model) => Carbon::parse($model->updated_at)->format('d/m/Y H:i:s'));
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
            Column::make('ID', 'id')
                ->makeInputRange(),

            Column::make('ESTIMATE ID', 'estimate_id')
                ->makeInputRange(),

            Column::make('DEPT ID', 'dept_id')
                ->makeInputRange(),

            Column::make('CATEGORY ID', 'category_id')
                ->makeInputRange(),

            Column::make('ROW ID', 'row_id')
                ->makeInputRange(),

            Column::make('ROW INDEX', 'row_index')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('SOR ITEM NUMBER', 'sor_item_number')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('ESTIMATE NO', 'estimate_no')
                ->makeInputRange(),

            Column::make('ITEM NAME', 'item_name')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('OTHER NAME', 'other_name')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('QTY', 'qty')
                ->makeInputRange(),

            Column::make('RATE', 'rate')
                ->sortable()
                ->searchable(),

            Column::make('TOTAL AMOUNT', 'total_amount')
                ->sortable()
                ->searchable(),

            Column::make('OPERATION', 'operation')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('CREATED BY', 'created_by')
                ->makeInputRange(),

            Column::make('COMMENTS', 'comments')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('CREATED AT', 'created_at_formatted', 'created_at')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker(),

            Column::make('UPDATED AT', 'updated_at_formatted', 'updated_at')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker(),

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

    /*
    public function actions(): array
    {
       return [
           Button::make('edit', 'Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('estimate-prepare.edit', ['estimate-prepare' => 'id']),

           Button::make('destroy', 'Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('estimate-prepare.destroy', ['estimate-prepare' => 'id'])
               ->method('delete')
        ];
    }
    */

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
