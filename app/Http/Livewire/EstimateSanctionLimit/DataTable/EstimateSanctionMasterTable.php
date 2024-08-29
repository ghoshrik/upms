<?php

namespace App\Http\Livewire\EstimateSanctionLimit\DataTable;

use App\Models\SanctionLimitMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Rules\Rule;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\Rules\RuleActions;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

final class EstimateSanctionMasterTable extends PowerGridComponent
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
     * @return Builder<\App\Models\SanctionLimitMaster>
     */
    public function datasource(): Builder
    {
        return SanctionLimitMaster::query()
            // ->select(
            //     'estimate_acceptance_limit_masters.id',
            //     'estimate_acceptance_limit_masters.department_id',
            //     'estimate_acceptance_limit_masters.level_id',
            //     'estimate_acceptance_limit_masters.min_amount',
            //     'estimate_acceptance_limit_masters.max_amount'
            // )
            // ->join('level_master', 'estimate_acceptance_limit_masters.level_id', '=', 'level_master.id')
            ->where('department_id', Auth::user()->department_id);
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
            // ->addColumn('getDepartmentName.department_name')
            // ->addColumn('getRolesName.name')
            ->addColumn('min_amount')
            ->addColumn('max_amount');
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
            Column::make('ID', 'id'),
            // ->makeInputRange(),

            // Column::make('DEPARTMENT ID', 'getDepartmentName.department_name')
            //     ->makeInputRange(),

            // Column::make('ROLE NAME', 'getRolesName.name')
            //     ->makeInputRange(),

            Column::make('MIN AMOUNT', 'min_amount')
                ->sortable()
                ->searchable(),

            Column::make('MAX AMOUNT', 'max_amount')
                ->sortable()
                ->searchable(),

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
     * PowerGrid SanctionLimitMaster Action Buttons.
     *
     * @return array<int, Button>
     */

    public function actions(): array
    {
        return [
            Button::add('add-roles')
//                ->caption('Add Roles')
//                ->class('btn btn-soft-primary btn-sm px-3 py-2.5 m-1 rounded')
//                ->emit('openAddRolesSection', ['id' => 'id']),
                ->bladeComponent('action-components.estimate-sanction.add-role-permission-btn',['id'=>'id'])
        ];
    }
    public function add($id)
    {
        $this->emit('openAddRolesSection', $id);
    }
    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
     */

    /**
     * PowerGrid SanctionLimitMaster Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
public function actionRules(): array
{
return [

//Hide button edit for ID 1
Rule::button('edit')
->when(fn($estimate-acceptance-limit-master) => $estimate-acceptance-limit-master->id === 1)
->hide(),
];
}
 */
}
