<?php

namespace App\Http\Livewire\UserManagement\Datatable\Powergrid;

use App\Models\User;
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

final class UsersDataTable extends PowerGridComponent
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
     * @return Builder<\App\Models\User>
     */
    public function datasource(): Builder
    {
        if (Auth::user()->department_id) {
            if (Auth::user()->office_id) {
                return User::query()
                    ->select(
                        'users.id',
                        'users.name',
                        'users.email',
                        'users.username',
                        'users.ehrms_id',
                        'users.emp_name',
                        'users.designation_id',
                        'users.department_id',
                        'users.user_type',
                        'users.office_id',
                        'user_types.id as userType_id',
                        'user_types.parent_id',
                    )
                    ->join('user_types', 'users.user_type', '=', 'user_types.id')
                    ->where('user_types.parent_id', '=', Auth::user()->user_type)
                    ->where('users.department_id', Auth::user()->department_id)
                    ->where('users.office_id', Auth::user()->office_id);
            } else {
                return User::query()
                    ->select(
                        'users.id',
                        'users.name',
                        'users.email',
                        'users.username',
                        'users.ehrms_id',
                        'users.emp_name',
                        'users.designation_id',
                        'users.department_id',
                        'users.user_type',
                        'users.office_id',
                        'user_types.id as userType_id',
                        'user_types.parent_id',
                    )
                    ->join('user_types', 'users.user_type', '=', 'user_types.id')
                    ->where('user_types.parent_id', '=', Auth::user()->user_type)
                    ->where('users.department_id', Auth::user()->department_id);
            }
        } else {
            return User::query()
                ->select(
                    'users.id',
                    'users.name',
                    'users.email',
                    'users.username',
                    'users.ehrms_id',
                    'users.emp_name',
                    'users.designation_id',
                    'users.department_id',
                    'users.user_type',
                    'users.office_id',
                    'user_types.id as userType_id',
                    'user_types.parent_id',
                )
                ->join('user_types', 'users.user_type', '=', 'user_types.id')
                ->where('user_types.parent_id', '=', Auth::user()->user_type);
        }
        // return User::query();
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
            ->addColumn('name')

        /** Example of custom column using a closure **/
            ->addColumn('name_lower', function (User $model) {
                return strtolower(e($model->name));
            })

            ->addColumn('username')
            ->addColumn('email')
            ->addColumn('mobile')
            ->addColumn('ehrms_id')
            ->addColumn('emp_name')
            ->addColumn('getDesignationName.designation_name')
            ->addColumn('getDepartmentName.department_name')
            ->addColumn('getOfficeName.office_name')
            ->addColumn('getUserType.type');
        // ->addColumn('created_at_formatted', fn (User $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
        // ->addColumn('updated_at_formatted', fn (User $model) => Carbon::parse($model->updated_at)->format('d/m/Y H:i:s'));
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
            // Column::make('ID', 'id')
            //     ->makeInputRange(),

            // Column::make('NAME', 'name')
            //     ->sortable()
            //     ->searchable()
            //     ->makeInputText(),

            Column::make('LOGIN ID', 'username')
                ->sortable()
                ->searchable(),
            // ->makeInputText(),

            Column::make('EMAIL', 'email')
                ->sortable()
                ->searchable(),
            // ->makeInputText(),

            Column::make('MOBILE', 'mobile')
                ->sortable()
                ->searchable(),
            // ->makeInputText(),

            Column::make('EHRMS ID', 'ehrms_id')
                ->sortable()
                ->searchable(),
            // ->makeInputText(),

            Column::make('EMP NAME', 'emp_name')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('DESIGNATION NAME', 'getDesignationName.designation_name')
                ->sortable()
                ->searchable(),

            Column::make('DEPARTMENT NAME', 'getDepartmentName.department_name')
                ->sortable()
                ->searchable(),

            Column::make('OFFICE NAME', 'getOfficeName.office_name')
                ->sortable()
                ->searchable(),

            Column::make('USER TYPE', 'getUserType.type')
                ->sortable()
                ->searchable(),

            // Column::make('CREATED AT', 'created_at_formatted', 'created_at')
            //     ->searchable()
            //     ->sortable()
            //     ->makeInputDatePicker(),

            // Column::make('UPDATED AT', 'updated_at_formatted', 'updated_at')
            //     ->searchable()
            //     ->sortable()
            //     ->makeInputDatePicker(),

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
     * PowerGrid User Action Buttons.
     *
     * @return array<int, Button>
     */

    /*
    public function actions(): array
    {
    return [
    Button::make('edit', 'Edit')
    ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
    ->route('user.edit', ['user' => 'id']),

    Button::make('destroy', 'Delete')
    ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
    ->route('user.destroy', ['user' => 'id'])
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
     * PowerGrid User Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
public function actionRules(): array
{
return [

//Hide button edit for ID 1
Rule::button('edit')
->when(fn($user) => $user->id === 1)
->hide(),
];
}
 */
}
