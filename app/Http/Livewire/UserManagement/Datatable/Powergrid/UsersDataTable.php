<?php

namespace App\Http\Livewire\UserManagement\Datatable\Powergrid;

use App\Models\Designation;
use App\Models\User;
use App\Models\UserType;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Rules\Rule;
use PowerComponents\LivewirePowerGrid\Traits\Filter;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\Rules\RuleActions;
use PowerComponents\LivewirePowerGrid\Helpers\Collection;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

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


    public $userData;
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
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function bulkActionEvent()
    {
        $ModelList = [
            trans('cruds.user-management.fields.employee_name') => '20%',
            trans('cruds.user-management.fields.email_id') => '24%',
            trans('cruds.user-management.fields.username') => '15%',
            trans('cruds.user-management.fields.ehrms_id') => '12%',
            trans('cruds.user-management.fields.mobile') => '8%',
            trans('cruds.user-management.fields.designation') => '19%',
            trans('cruds.user-management.fields.department') => '13%',
            //if(Auth::user()->user_type == 4)
            trans('cruds.user-management.fields.office_name') => '16%',
            trans('cruds.user-management.fields.status') => '5%',
        ];
        $getChild_id = UserType::where('parent_id', Auth::user()->user_type)->select('id')->first();
        dd(Auth::user()->user_type);
        if (count($this->checkboxValues) == 0) {
            if (Auth::user()->user_type == 2) {

                $users = User::where('user_type', $getChild_id->id)
                    // ->where('department_id', Auth::user()->department_id)
                    ->where('is_active', 1)->get();
                $i = 1;
                // dd($users);
                foreach ($users as $key => $user) {
                    $desg = Designation::select('designation_name')->where('id', $user->designation_id)->get();
                    foreach ($desg as $designation) {
                        $designationName = $designation->designation_name;
                    }
                    $dataView[] = [
                        '1' => $i,
                        '2' => $user->emp_name,
                        '3' => $user->email,
                        '4' => $user->username,
                        '5' => $user->ehrms_id,
                        '6' => $user->mobile,
                        '7' => $designationName,
                        '8' => $user->getDepartmentName->department_name,
                        '9' => 'N/A',
                        'active' => $user->is_active,
                    ];
                    $i++;
                }
                // dd($dataView);
                return generatePDF($ModelList, $dataView, trans('cruds.user-management.title_singulars'));
            } elseif (Auth::user()->user_type == 3) {
                $users = User::where('user_type', $getChild_id->id)
                    ->where('department_id', Auth::user()->department_id)
                    ->where('is_active', 1)
                    ->get();
                $i = 1;
                foreach ($users as $key => $user) {
                    $desg = Designation::select('designation_name')->where('id', $user->designation_id)->get();
                    foreach ($desg as $designation) {
                        $designationName = $designation->designation_name;
                    }
                    $dataView[] = [
                        '1' => $i,
                        '2' => $user->emp_name,
                        '3' => $user->email,
                        '4' => $user->username,
                        '5' => $user->ehrms_id,
                        '6' => $user->mobile,
                        '7' => $designationName,
                        '8' => $user->getDepartmentName->department_name,
                        '9' => $user->getOfficeName->office_name,
                        'active' => $user->is_active,
                    ];
                    $i++;
                }
                return generatePDF($ModelList, $dataView, trans('cruds.user-management.title_singulars'));
            } else {
                $users = User::where('user_type', $getChild_id->id)
                    ->where('department_id', Auth::user()->department_id)
                    ->where('office_id', Auth::user()->office_id)
                    ->where('is_active', 1)
                    ->get();
                $i = 1;

                // if (count($users) > 0) {
                foreach ($users as $key => $user) {
                    $desg = Designation::select('designation_name')->where('id', $user->designation_id)->get();
                    foreach ($desg as $designation) {
                        $designationName = $designation->designation_name;
                    }
                    $dataView[] = [
                        '1' => $i,
                        '2' => $user->emp_name,
                        '3' => $user->email,
                        '4' => $user->username,
                        '5' => $user->ehrms_id,
                        '6' => $user->mobile,
                        '7' => $designationName,
                        '8' => $user->getDepartmentName->department_name,
                        '9' => $user->getOfficeName->office_name,
                        'active' => $user->is_active,
                    ];
                    $i++;
                }
                // } else {
                //     $this->notification()->error(
                //         $title = 'User Not Activated',
                //     );
                // }
                return generatePDF($ModelList, $dataView, trans('cruds.user-management.title_singulars'));
            }
        } else {
            $ids = implode(',', $this->checkboxValues);
            $users = User::whereIn('id', explode(",", $ids))
                ->where('user_type', $getChild_id->id)
                // ->where('department_id', Auth::user()->department_id)
                ->where('is_active', 1)->get();
            $i = 1;
            // dd($users);
            if (count($users) > 0) {
                foreach ($users as $key => $user) {
                    $getDesignationName =  Designation::select('designation_name')->where('id', $user->designation_id)->get();
                    foreach ($getDesignationName as $designation) {
                        $designationName = $designation->designation_name;
                    }
                    $dataView[] = [
                        '1' => $i,
                        '2' => $user->emp_name,
                        '3' => $user->email,
                        '4' => $user->username,
                        '5' => $user->ehrms_id,
                        '6' => $user->mobile,
                        '7' => $designationName,
                        '8' => $user->getDepartmentName->department_name,
                        '9' => $user->office_id ? $user->getOfficeName->office_name : 'N/A',
                        'active' => $user->is_active,
                    ];
                    $i++;
                }
            } else {
                $this->notification()->error(
                    $title = 'User Not Activated',
                );
            }
            return generatePDF($ModelList, $dataView, trans('cruds.user-management.title_singulars'));
            $this->resetExcept('checkboxValues', 'dataView');
        }
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
    public function datasource(): ?Builder
    {
        /*
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
        */

        if (Auth::user()->department_id) {
            /*if (Auth::user()->office_id) {
                */
                return User::query()
                    /*->join('user_types', function ($user_types) {
                        $user_types->on('users.user_type', '=', 'user_types.id');
                    })->join('designations', 'users.designation_id', '=', 'designations.id')*/
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
                    ->join('user_types', 'users.user_type', '=', 'user_types.id')
                    ->join('designations', 'users.designation_id', '=', 'designations.id')
                    ->where('user_types.parent_id', '=', $this->userData);
                    /*->where('users.department_id', Auth::user()->department_id)
                    ->where('users.office_id', Auth::user()->office_id);
            /*} else {
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

                    ->where('user_types.parent_id', '=', $this->userData)
                    ->where('users.department_id', Auth::user()->department_id);
            }*/
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
                ->where('user_types.parent_id', $this->userData)
                ->join('user_types', 'users.user_type', '=', 'user_types.id')
                ->join('designations', 'users.designation_id', '=', 'designations.id');
        }
    }

    public function map(): array
    {
        return $this->dataSource()->map(function ($user) {
            return [
                'serial_no' => $user->id,
                'Name' => $user->name,
                'LOGIN ID' => $user->username,
                'EMAIL' => $user->email,
                'MOBILE' => $user->mobile,
                'EHRMS ID' => $user->ehrms_id,
                'EMP NAME' => $user->emp_name,
                'DESIGNATION NAME' => $user->designation_name,
                'DEPARTMENT NAME' => $user->getDepartmentName->department_name,
                'OFFICE NAME' => $user->getOfficeName->office_name,
                'USER TYPE' => $user->getUserType->type,
                'STATUS' => $user->is_active ? 'active' : 'Inactive', // Remove HTML tags
            ];
        })->toArray();
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


    /*public function filters(): array
    {
        return [
            Filter::boolean('is_active')
                ->label('yes', 'no')
        ];
    }*/
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
            Column::make('SL. No.', 'serial_no'),
            // ->makeInputRange(),

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
                ->sortable()
                // ->closure(function ($value) {
                //     return $value ? 'active' : 'Inactive';
                // }),
                ->makeBooleanFilter(dataField: 'is_active', trueLabel: 'active', falseLabel: 'Inactive'),

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
