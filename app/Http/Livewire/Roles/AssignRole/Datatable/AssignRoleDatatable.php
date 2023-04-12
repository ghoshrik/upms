<?php

namespace App\Http\Livewire\Roles\AssignRole\Datatable;

use App\Models\UsersHasRoles;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;

use PowerComponents\LivewirePowerGrid\Exportable;

use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\Rules\Rule;
use PowerComponents\LivewirePowerGrid\Rules\RuleActions;use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

final class AssignRoleDatatable extends PowerGridComponent
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
     * @return Builder<\App\Models\UsersHasRoles>
     */
    public function datasource(): Builder
    {
        return UsersHasRoles::query()
            ->select(
                "users_has_roles.user_id",
                "users_has_roles.role_id",
                "users.id",
                "users.emp_name",
                "users.department_id",
                "users.office_id",
                "roles.id as roles_id",
                "roles.name",
                "departments.id as departments_id",
                "departments.department_name",
                "offices.id as offices_id",
                "offices.office_name"

            )
            ->join("users", "users_has_roles.user_id", '=', "users.id")
            ->join("roles", "users_has_roles.role_id", '=', "roles.id")
            ->join("departments","users.department_id",'=',"departments.id")
            ->join("offices","users.office_id",'=',"offices.id")
            ->where('offices.id',Auth::user()->office_id)
            ->where('users.user_type',6);
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
            ->addColumn('role_id')
            ->addColumn('emp_name')
            ->addColumn('name_lower', fn(UsersHasRoles $model) => strtolower(e($model->name)))
            ->addColumn('department_name')
            ->addColumn('office_name')
        ;
        // ->addColumn('created_at')
        // ->addColumn('created_at_formatted', fn (UsersHasRoles $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
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
            Column::make('Role Name', 'name')
                ->searchable()
                ->makeInputText('name')
                ->sortable(),

            Column::make('Name', 'emp_name')
                ->searchable()
                ->makeInputText('name')
                ->sortable(),
            Column::make('DEPARTMENT NAME', 'department_name')
                ->sortable()
                ->searchable(),

            Column::make('OFFICE NAME', 'office_name')
                ->sortable()
                ->searchable(),

            // Column::make('Created at', 'created_at')
            //     ->hidden(),

            // Column::make('Created at', 'created_at_formatted', 'created_at')
            //     ->makeInputDatePicker()
            //     ->searchable()
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
     * PowerGrid UsersHasRoles Action Buttons.
     *
     * @return array<int, Button>
     */

    /*
    public function actions(): array
    {
    return [
    Button::make('edit', 'Edit')
    ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
    ->route('users-has-roles.edit', ['users-has-roles' => 'id']),

    Button::make('destroy', 'Delete')
    ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
    ->route('users-has-roles.destroy', ['users-has-roles' => 'id'])
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
     * PowerGrid UsersHasRoles Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
public function actionRules(): array
{
return [

//Hide button edit for ID 1
Rule::button('edit')
->when(fn($users-has-roles) => $users-has-roles->id === 1)
->hide(),
];
}
 */
}
