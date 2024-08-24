<?php

namespace App\Http\Livewire\UserManagement\Datatable\Powergrid;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\Rule;
use WireUi\Traits\Actions;


final class ChangeUsersDataTable extends PowerGridComponent
{
    use ActionButton,Actions;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\User>|null
    */
    public function datasource(): ?Builder
    {
        $query = User::query()
            ->select(
                'users.id',
                'users.name',
                'users.email',
                // 'users.username',
                'users.ehrms_id',
                'users.emp_name',
                'users.mobile',
                'users.designation_id',
                'users.department_id',
                'users.user_type',
                'users.office_id',
                'users.group_id',
                // 'user_types.id as userType_id',
                // 'user_types.parent_id',
                'users.is_active',
                'model_has_roles.role_id',
                'model_has_roles.model_id',
                'roles.id as roleId',
                'roles.name',
                'designations.id as designationId',
                'designations.designation_name',
                DB::raw('ROW_NUMBER() OVER (ORDER BY users.id) as serial_no')
            )
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->join('designations', 'users.designation_id', '=', 'designations.id');
        if (Auth::user()->hasRole('State Admin')) {
            return $query->where('model_has_roles.role_id', $this->userData);
        } elseif (Auth::user()->hasRole('Department Admin')) {
            return $query->where('model_has_roles.role_id', $this->userData)
                ->where('users.department_id', Auth::user()->department_id)
                ->where([['users.group_id','!=',null],['users.group_id','!=',0]]);
        } elseif(Auth::user()->hasRole('Group Admin')){
            return $query->where('model_has_roles.role_id', $this->userData)
                ->where('users.department_id',Auth::user()->department_id)
                ->where('users.group_id',Auth::user()->group_id);
        } elseif(Auth::user()->hasRole('Office Admin')){
            return $query->where('model_has_roles.role_id', $this->userData)
                ->where('users.department_id',Auth::user()->department_id)
                ->where('users.group_id',Auth::user()->group_id)
                ;
        } else {
            return $query;
        }
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
    public function map(): array
    {
        return $this->dataSource()->map(function ($user) {
            return [
                'serial_no' => $user->id,
                'Name' => $user->name,
                // 'LOGIN ID' => $user->username,
                'EMAIL' => $user->email,
                'MOBILE' => $user->mobile,
                'EHRMS ID' => $user->ehrms_id,
                'EMP NAME' => $user->emp_name,
                'DESIGNATION NAME' => $user->designation_name,
                'DEPARTMENT NAME' => $user->getDepartmentName->department_name,
                'OFFICE NAME' => $user->getOfficeName->office_name,
                'ROLE' => $name,
                'STATUS' => $user->is_active ? 'active' : 'Inactive', // Remove HTML tags
            ];
        })->toArray();
    }
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
            ->addColumn('name')
            ->addColumn('email')
            ->addColumn('mobile')
            ->addColumn('ehrms_id')
            ->addColumn('emp_name')
            ->addColumn('designation_name')
            ->addColumn('getDepartmentName.department_name')
            ->addColumn('getOfficeName.office_name')
            ->addColumn('group.group_name')
            ->addColumn('is_active',function (User $user){
                if ($user->is_active == 0) {
                    return '<label wire:click="toggleSelectedActive(' . $user->id . ')" class="cursor-pointer badge badge-pill bg-danger">Inactive</label>';
                } else {
                    return '<label wire:click="toggleSelectedInactive(' . $user->id . ')" class="cursor-pointer badge badge-pill bg-success">Active</label>';
                }
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
            Column::add()
                ->title('NAME')
                ->field('name')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('EMAIL')
                ->field('email')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('MOBILE')
                ->field('mobile')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('EHRMS ID')
                ->field('ehrms_id')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('EMP NAME')
                ->field('emp_name')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('DESIGNATION')
                ->field('designation_name')
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('DEPARTMENT')
                ->field('getDepartmentName.department_name')
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('OFFICE')
                ->field('getOfficeName.office_name')
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('GROUP')
                ->field('group.group_name')
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('IS ACTIVE')
                ->field('is_active')
                ->makeInputRange(),



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
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::add('edit')
               ->caption('Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('user.edit', ['user' => 'id']),

           Button::add('destroy')
               ->caption('Delete')
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
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
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

    /*
    |--------------------------------------------------------------------------
    | Edit Method
    |--------------------------------------------------------------------------
    | Enable the method below to use editOnClick() or toggleable() methods.
    | Data must be validated and treated (see "Update Data" in PowerGrid doc).
    |
    */

     /**
     * PowerGrid User Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = User::query()->findOrFail($data['id'])
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
