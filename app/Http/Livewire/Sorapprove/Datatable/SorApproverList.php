<?php

namespace App\Http\Livewire\SorApprove\Datatable;

use App\Models\SOR;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class SorApproverList extends PowerGridComponent
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
     * @return Builder<\App\Models\SOR>
     */

    public function datasource(): Builder
    {
        return SOR::query()
            ->where('department_id', '=', Auth::user()->department_id);
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
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
            ->addColumn('Item_details')
            ->addColumn('getDeptCategoryName.dept_category_name')
            ->addColumn('description')
            ->addColumn('getUnitsName.unit_name')
            ->addColumn('cost')
            ->addColumn('version');
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
            Column::make(trans('cruds.sor-approver.fields.id_helper'), 'id'),

            Column::make(trans('cruds.sor-approver.fields.item_number'), 'Item_details')
                ->sortable()
                ->searchable(),

            Column::make('DEPT CATEGORY ID', 'getDeptCategoryName.dept_category_name')
                ->makeInputRange(),

            Column::make(trans('cruds.sor-approver.fields.desc'), 'description')
                ->sortable()
                ->searchable(),

            Column::make(trans('cruds.sor-approver.fields.unit'), 'getUnitsName.unit_name')
                ->makeInputRange(),

            Column::make(trans('cruds.sor-approver.fields.cost'), 'cost')
                ->makeInputRange(),

            Column::make(trans('cruds.sor-approver.fields.status'), 'version')
                ->sortable()
                ->searchable(),

            Column::make(trans('cruds.sor-approver.fields.file'), '')
                ->sortable(),

            Column::make(trans('cruds.sor-approver.fields.action'), '')
                ->searchable()
                ->sortable(),
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
     * PowerGrid SOR Action Buttons.
     *
     * @return array<int, Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::make('edit', 'Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('s-o-r.edit', ['s-o-r' => 'id']),

           Button::make('destroy', 'Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('s-o-r.destroy', ['s-o-r' => 'id'])
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
     * PowerGrid SOR Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($s-o-r) => $s-o-r->id === 1)
                ->hide(),
        ];
    }
    */
}
