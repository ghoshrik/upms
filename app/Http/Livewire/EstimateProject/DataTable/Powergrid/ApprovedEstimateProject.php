<?php

namespace App\Http\Livewire\EstimateProject\DataTable\Powergrid;

use App\Models\SORMaster;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class ApprovedEstimateProject extends PowerGridComponent
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
    * @return Builder<\App\Models\SORMaster>
    */
    public function datasource(): Builder
    {
        return SORMaster::query();
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
            ->addColumn('sorMasterDesc')
            ->addColumn('status')
            ->addColumn('dept_id')
            ->addColumn('part_no')

           /** Example of custom column using a closure **/
            ->addColumn('part_no_lower', function (SORMaster $model) {
                return strtolower(e($model->part_no));
            })

            ->addColumn('associated_with')
            ->addColumn('approved_at_formatted', fn (SORMaster $model) => Carbon::parse($model->approved_at)->format('d/m/Y H:i:s'))
            ->addColumn('created_by')
            ->addColumn('is_verified')
            ->addColumn('created_at_formatted', fn (SORMaster $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
            ->addColumn('updated_at_formatted', fn (SORMaster $model) => Carbon::parse($model->updated_at)->format('d/m/Y H:i:s'));
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

            Column::make('SORMASTERDESC', 'sorMasterDesc')
                ->sortable()
                ->searchable(),

            Column::make('STATUS', 'status')
                ->makeInputRange(),

            Column::make('DEPT ID', 'dept_id')
                ->makeInputRange(),

            Column::make('PART NO', 'part_no')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('ASSOCIATED WITH', 'associated_with')
                ->makeInputRange(),

            Column::make('APPROVED AT', 'approved_at_formatted', 'approved_at')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker(),

            Column::make('CREATED BY', 'created_by')
                ->makeInputRange(),

            Column::make('IS VERIFIED', 'is_verified')
                ->makeInputRange(),

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
     * PowerGrid SORMaster Action Buttons.
     *
     * @return array<int, Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::make('edit', 'Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('s-o-r-master.edit', ['s-o-r-master' => 'id']),

           Button::make('destroy', 'Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('s-o-r-master.destroy', ['s-o-r-master' => 'id'])
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
     * PowerGrid SORMaster Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($s-o-r-master) => $s-o-r-master->id === 1)
                ->hide(),
        ];
    }
    */
}
