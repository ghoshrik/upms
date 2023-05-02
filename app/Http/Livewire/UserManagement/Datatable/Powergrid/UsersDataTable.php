<?php

namespace App\Http\Livewire\UserManagement\Datatable\Powergrid;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\Rules\Rule;
use PowerComponents\LivewirePowerGrid\Rules\RuleActions;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use WireUi\Traits\Actions;

final class UsersDataTable extends PowerGridComponent
{
    use ActionButton, Actions;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
     */
    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(),
            [
                'rowActionEvent',
                'bulkActionEvent',
            ]
        );
    }
    public function header(): array
    {
        return [
            Button::add('bulk-demo')
                ->caption('PDF')
                ->class('cursor-pointer btn btn-soft-primary btn-sm')
                ->emit('bulkActionEvent', [])
        ];
    }
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            // Exportable::make('export')
            //     ->csvSeparator('|')
            //     ->csvDelimiter("'")
            //     ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV)
            //     ->striped('A6ACCD'),
            // ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS),
            Header::make()->showToggleColumns()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function bulkActionEvent()
    {
        $ModelList = [
            'Employee Name' => '18%',
            'Email' => '23%',
            'LoginId' => '17%',
            'eHRMS' => '12%',
            'Mobile No.' => '11%',
            'Designation Name' => '15%',
            'Department' => '13%',
            'status' => '7%',
        ];
        $getChild_id = UserType::where('parent_id', Auth::user()->user_type)->select('id')->first();
        if (count($this->checkboxValues) == 0) {
            if (Auth::user()->user_type == 3) {
                $users = User::where([['user_type', $getChild_id['id']], ['department_id', Auth::user()->department_id], ['is_active', 1]])->get();
                $i = 1;
                foreach ($users as $key => $user) {
                    $dataView[] = [
                        'id' => $i,
                        'title' => $user->emp_name,
                        'email' => $user->email,
                        'username' => $user->username,
                        'ehrms' => $user->ehrms_id,
                        'mobile' => $user->mobile,
                        'designation' => $user->getDesignationName->designation_name,
                        'department' => $user->getDepartmentName->department_name,
                        'active' => $user->is_active,
                    ];
                    $i++;
                }
                return generatePDF($ModelList, $dataView, trans('cruds.user-management.title_singulars'));
            } elseif (Auth::user()->user_type == 4) {
                $users = User::where([['user_type', $getChild_id['id']], ['department_id', Auth::user()->department_id], ['office_id', Auth::user()->office_id], ['is_active', 1]])->get();
                $i = 1;
                foreach ($users as $key => $user) {
                    $dataView[] = [
                        'id' => $i,
                        'title' => $user->emp_name,
                        'email' => $user->email,
                        'username' => $user->username,
                        'ehrms' => $user->ehrms_id,
                        'mobile' => $user->mobile,
                        'designation' => $user->getDesignationName->designation_name,
                        'department' => $user->getDepartmentName->department_name,
                        'active' => $user->is_active,
                    ];
                    $i++;
                }
                return generatePDF($ModelList, $dataView, trans('cruds.user-management.title_singulars'));
            }
        } else {
            $ids = implode(',', $this->checkboxValues);
            $users = User::whereIn('id', explode(",", $ids))->where([['user_type', $getChild_id['id']], ['department_id', Auth::user()->department_id], ['is_active', 1]])->get();
            $i = 1;
            foreach ($users as $key => $user) {
                $dataView[] = [
                    'id' => $i,
                    'title' => $user->emp_name,
                    'email' => $user->email,
                    'username' => $user->username,
                    'ehrms' => $user->ehrms_id,
                    'mobile' => $user->mobile,
                    'designation' => $user->getDesignationName->designation_name,
                    'department' => $user->getDepartmentName->department_name,
                    'active' => $user->is_active,
                ];
                $i++;
            }
            return generatePDF($ModelList, $dataView, trans('cruds.user-management.title_singulars'));
        }
        $this->resetExcept('checkboxValues', 'dataView');
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
                    ->join('user_types', function ($user_types) {
                        $user_types->on('users.user_type', '=', 'user_types.id');
                    })->join('designations', 'users.designation_id', '=', 'designations.id')
                    ->select(
                        'users.id',
                        'users.name',
                        'users.email',
                        'users.username',
                        'users.ehrms_id',
                        'users.emp_name',
                        'users.mobile',
                        'users.designation_id',
                        'users.department_id',
                        'users.user_type',
                        'users.office_id',
                        'user_types.id as userType_id',
                        'user_types.parent_id',
                        'users.is_active',
                        'designations.id as designationId',
                        'designations.designation_name',
                        DB::raw('ROW_NUMBER() OVER (ORDER BY users.id) as serial_no')
                    )
                    // ->join('user_types', 'users.user_type', '=', 'user_types.id')
                    ->where('user_types.parent_id', '=', Auth::user()->user_type)
                    ->where('users.department_id', Auth::user()->department_id)
                    ->where('users.office_id', Auth::user()->office_id);
            } else {
                // dd(User::query()->with('designation')->first());
                return User::query()
                    ->join('user_types', function ($user_types) {
                        $user_types->on('users.user_type', '=', 'user_types.id');
                    })->join('designations', 'users.designation_id', '=', 'designations.id')
                    ->select(
                        'users.id',
                        'users.name',
                        'users.email',
                        'users.username',
                        'users.ehrms_id',
                        'users.emp_name',
                        'users.mobile',
                        'users.designation_id',
                        'users.department_id',
                        'users.user_type',
                        'users.office_id',
                        'user_types.id as userType_id',
                        'user_types.parent_id',
                        'users.is_active',
                        'designations.id as designationId',
                        'designations.designation_name',
                        DB::raw('ROW_NUMBER() OVER (ORDER BY users.id) as serial_no')
                    )

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
                    'users.mobile',
                    'users.designation_id',
                    'users.department_id',
                    'users.user_type',
                    'users.office_id',
                    'user_types.id as userType_id',
                    'user_types.parent_id',
                    'users.is_active',
                    'designations.id as designationId',
                    'designations.designation_name',
                    DB::raw('ROW_NUMBER() OVER (ORDER BY users.id) as serial_no')
                )
                ->where('users.user_type', 3)
                ->join('user_types', 'users.user_type', '=', 'user_types.id')
                ->join('designations', 'users.designation_id', '=', 'designations.id');
            // ->where('users.user_type', '=', Auth::user()->user_type);
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
            ->addColumn('serial_no')
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
            ->addColumn('designation_name')
            ->addColumn('getDepartmentName.department_name')
            ->addColumn('getOfficeName.office_name')

            ->addColumn('getUserType.type')
            ->addColumn('is_active', function (User $user) {

                if ($user->is_active == 0) {
                    return '<label wire:click="toggleSelectedActive(' . $user->id . ')" class="badge badge-pill bg-danger cursor-pointer">Inactive</label>';
                } else {
                    return '<label wire:click="toggleSelectedInactive(' . $user->id . ')" class="badge badge-pill bg-success cursor-pointer">Active</label>';
                }
            });
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

    // public function dialogBox($value, $icon, $method, $currStatus)
    // {
    //     $this->dialog()->confirm([
    //         'title' => 'Are you Sure?',
    //         'icon' => 'success',
    //         'accept' => [
    //             'label' => 'Yes, Approved',
    //             'method' => 'approvedUser',
    //             'params' => $value,
    //         ],
    //         'reject' => [
    //             'label' => 'No, cancel',
    //             // 'method' => 'cancel',
    //         ],
    //     ]);
    // }

    public function toggleSelectedInactive($value)
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure want to Inactive user ?',
            'icon' => 'warning',
            'accept' => [
                'label' => 'Yes,Inactive',
                'method' => 'InactiveUser',
                'params' => $value,
            ],
            'reject' => [
                'label' => 'No, cancel',
                // 'method' => 'cancel',
            ],
        ]);
    }

    public function InactiveUser($value)
    {
        User::where('id', $value)->update(['is_active' => 0]);
    }

    public function toggleSelectedActive($value)
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure want to Active user ?',
            'icon' => 'success',
            'accept' => [
                'label' => 'Yes,Active',
                'method' => 'activeUser',
                'params' => $value,
            ],
            'reject' => [
                'label' => 'No, cancel',
                // 'method' => 'cancel',
            ],
        ]);
    }

    public function activeUser($value)
    {
        User::where('id', $value)->update(['is_active' => 1]);
    }

    public function columns(): array
    {
        return [
            Column::make('SL. No.', 'serial_no')
                ->makeInputRange(),

            // Column::make('NAME', 'name')
            //     ->sortable()
            //     ->searchable()
            //     ->makeInputText(),

            Column::make('LOGIN ID', 'username')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('EMAIL', 'email')
                ->sortable()
                ->searchable()
                ->makeInputText(),

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

            Column::make('DESIGNATION NAME', 'designation_name')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('DEPARTMENT NAME', 'getDepartmentName.department_name')
                ->sortable()
                ->searchable(),

            Column::make('OFFICE NAME', 'getOfficeName.office_name')
                ->sortable()
                ->searchable(),
            // ->when(fn ($dish) => $dish->in_stock == false)
            // ->hide(),

            Column::make('USER TYPE', 'getUserType.type')
                ->sortable()
                ->searchable(),

            Column::make('STATUS', 'is_active')
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
// Rule::button('edit')
// ->when(fn($user) => $user->id === 1)
// ->hide(),

Rule::rows()
->when(fn ($dish) => $dish->in_stock == false)
->hide()

];
}
 */
}
