<?php

namespace App\Http\Livewire\Roles\AssignRole;

use App\Models\Department;
use App\Models\DepartmentCategories;
use App\Models\Designation;
use App\Models\Levels;
use App\Models\Office;
use App\Models\States;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use WireUi\Traits\Actions;

class Create extends Component
{
    use Actions;
    public $dropDownData = [], $newAccessData = [], $access_type_name = [], $userlist = [], $openAssignModal, $selectedIdForEdit,$editUser,$editUserRole;

    public function mount()
    {
        if ($this->selectedIdForEdit != '') {
            //     dd($this->selectedIdForEdit);
            $this->editUser = User::find($this->selectedIdForEdit);
            $this->editUserRole= $this->editUser->roles->first();
        }

        // dd($userDet);
        $this->newAccessData = [
            'role_type' => [],
            'users_id' => ($this->selectedIdForEdit != '') ? $this->editUser->id : '',
            'office_id' => ($this->selectedIdForEdit != '') ? $this->editUser->office_id : '',
            'desg_id' => ($this->selectedIdForEdit != '') ? $this->editUser->designation_id : '',
            'department_id' => ($this->selectedIdForEdit != '') ? $this->editUser->department_id : '',
            'dept_category_id' => '',
            //     'roles_id' => [],
        ];
        // $this->getDropdownData('userTypes');
        if (Auth::user()->roles->first()->name == 'Super Admin') {
            $this->dropDownData['states'] = States::all();
            $this->newAccessData['state_code'] = '';
        } else {
            $this->newAccessData['level_id'] = '';
            $this->dropDownData['levels'] = [];
            $userRole = Auth::user()->roles1->first();
            $childRoles = $userRole->childRoles;
            foreach ($childRoles as $key => $data) {
                if ($key != 0) {
                    // Compare current item with the previous item
                    if ($childRoles[$key - 1]->has_level_no != $data->has_level_no) {
                        $this->dropDownData['levels'][] = Levels::where('id', $data->has_level_no)->first();
                    }
                } else {
                    // Add the first item unconditionally (optional, depending on your needs)
                    $this->dropDownData['levels'][] = Levels::where('id', $data->has_level_no)->first();
                }
            }
            $this->newAccessData['level_id'] = ($this->selectedIdForEdit != '') ? $this->editUserRole->has_level_no : '';
            // dd($this->dropDownData['levels']);
            if (count($this->dropDownData['levels']) != 0) {
                $this->getDropdownData('departments');
                if ($this->newAccessData['department_id'] != '') {
                    $this->getOfficeDesignation();
                }
                if ($this->newAccessData['desg_id'] != '' || $this->newAccessData['office_id']!='') {
                    $this->getUserList();
                    if($this->newAccessData['users_id'] != ''){
                        $this->getUserRoles();
                    }
                }

            }
        }
        if (Auth::user()->roles->first()->has_level_no == '') {
            $this->dropDownData['userTypes'] = Role::where('role_parent', Auth::user()->roles->first()->id)->get();
            if ($this->dropDownData['userTypes'][0]['has_level_no'] != '') {
                // $this->newAccessData['level_id'] = $this->dropDownData['userTypes'][0]['has_level_no'];
                // $this->getDropdownData('designations');
            }
        } else {
            $userRole = Auth::user()->roles->toArray();
            $this->dropDownData['userTypes'] = Role::where('role_parent', Auth::user()->roles->first()->id)->get();
        }
        // dd($this->dropDownData);
    }
    public function getDropdownData($lookingFor)
    {
        try {
            switch ($lookingFor) {
                case 'userTypes':
                    $this->dropDownData['userTypes'] = UserType::where('parent_id', Auth::user()->user_type)->get();
                    break;
                case 'designations':
                    $this->dropDownData['designations'] = Designation::where('level_no', $this->newAccessData['level_id'])->get();
                    break;
                case 'departments':
                    $this->dropDownData['departments'] = Department::get();
                    break;
                case 'departmentCategory':
                    $this->dropDownData['departmentCategory'] = DepartmentCategories::where('department_id', $this->newAccessData['department_id'])->get();
                    break;
                case 'OFC':
                    // $this->dropDownData['offices'] = Office::where('id', Auth::user()->office_id)->get();
                    $this->dropDownData['offices'] = Office::where('level_no', $this->newAccessData['level_id'])->where('department_id', $this->newAccessData['department_id'])->where('created_by', Auth::user()->id)->get();
                    // dd($this->dropDownData['offices']);
                    break;
                case 'roles':
                    $this->dropDownData['roles'] = Role::select('roles.id as id', 'roles.name as name')->join('roles_order', 'roles.id', '=', 'roles_order.role_id')->where('roles_order.parent_id', '>', 3)->get();
                    break;
                default:
                    // $this->allUsers = User::select('users.id','users.emp_name')->join('user_types', 'users.user_type', '=', 'user_types.id')
                    // ->where([['parent_id', Auth::user()->user_type], ['department_id', Auth::user()->department_id]])->get();
                    break;
            }
        } catch (\Throwable $th) {
            session()->flash('serverError', $th->getMessage());
        }
    }
    public function getOfficeDesignation()
    {
        if (count($this->dropDownData['levels']) != 0 && $this->newAccessData['level_id'] == '') {
            $this->newAccessData['department_id'] = ($this->selectedIdForEdit != '') ? $this->editUser->department_id : '';
            $this->newAccessData['office_id'] = ($this->selectedIdForEdit != '') ? $this->editUser->office_id : '';
            $this->newAccessData['desg_id'] = ($this->selectedIdForEdit != '') ? $this->editUser->designation_id : '';
            $this->newAccessData['users_id'] = ($this->selectedIdForEdit != '') ? $this->editUser->id : '';
            $this->newAccessData['role_type'] = [];
            $this->notification()->error(
                $title = 'Error',
                $description = 'Please Select Level.'
            );
        } else {
            $this->dropDownData['offices'] = [];
            $this->newAccessData['office_id'] = ($this->selectedIdForEdit != '') ? $this->editUser->office_id : '';
            $this->dropDownData['designations'] = [];
            $this->newAccessData['desg_id'] = ($this->selectedIdForEdit != '') ? $this->editUser->designation_id : '';
            $this->getDropdownData('OFC');
            $this->getDropdownData('designations');
            $this->getDropdownData('departmentCategory');
            // dd($this->dropDownData['offices']);
        }
    }

    public function getUserRoles()
    {
        // getRoleNames

        $user = User::find($this->newAccessData['users_id']);

        if (!$user) {
            $this->notification()->error(
                $title = 'Error',
                $description = 'User Not have Any Roles'
            );
        }

        $roles = $user->roles()->get();
        if (!empty($roles)) {
            $this->notification()->success(
                $title = 'success',
                $description = 'User Have Some Roles'
            );
            foreach ($roles as $role) {
                $this->newAccessData['role_type'][] = $role['id'];
            }
        }
        // dd($this->newAccessData['role_type']);
        // dd($this->newAccessData['users_id']);
    }

    public function getUserList()
    {
        // Start with a base query
        // dd($this->newAccessData);
        $query = User::query();

        // Apply filters based on the conditions
        if ($this->newAccessData['role_type'] != '') {
            $query = $query->where('user_type', $this->newAccessData['role_type']);
        }

        if (isset($this->newAccessData['state_code']) && $this->newAccessData['state_code'] != '') {
            $query = $query->where('state_code', $this->newAccessData['state_code']);
        }

        if ($this->newAccessData['office_id'] != '') {
            $query = $query->where('office_id', $this->newAccessData['office_id']);
            if ($this->newAccessData['desg_id'] != '') {
                $this->dropDownData['users'] = $query->where('designation_id', $this->newAccessData['desg_id'])->get();
            } else {
                $this->dropDownData['users'] = $query->get();
            }
        } else {
            $this->dropDownData['users'] = [];
        }
        // Fetch the result and debug the output
        // dd($query->get(),$this->newAccessData['office_id']);
    }
    public function checkUserHasRole()
    {
        $role = $this->newAccessData['role_type'];
        $userId = $this->newAccessData['users_id'];
        // dd($this->newAccessData);
        $query = User::where('id', $this->newAccessData['users_id']);
        // dd($this->newAccessData['users_id']);
        if ($query->exists()) {
            $this->notification()->error(
                $title = 'Error',
                $description = 'User already assigned. Change the role or User.'
            );
            $this->newAccessData['users_id'] = ($this->selectedIdForEdit != '') ? $this->editUser->id : '';
            $this->newAccessData['role_type'] = [];
        }
    }
    public function getUsers()
    {
        $this->dropDownData['users'] = User::select('users.id', 'users.emp_name', 'users.ehrms_id', 'users.designation_id', 'users.office_id', 'users.mobile', 'users.email')
            ->join('user_types', 'users.user_type', '=', 'user_types.id')
            ->where([['user_types.parent_id', Auth::user()->user_type], ['users.department_id', Auth::user()->department_id], ['users.office_id', Auth::user()->office_id], ['users.designation_id', $this->newAccessData['designation_id']]])->get();
    }

    public function assignRole($userId)
    {
        $this->newAccessData['users_id'] = $userId;
        $this->getDropdownData('roles');
        $this->openAssignModal = true;
    }

    public function store()
    {
        // dd($this->newAccessData);
        try {
            $userId = $this->newAccessData['users_id'];
            $selectedRoles = $this->newAccessData['role_type'];
            $office_id = $this->newAccessData['office_id'];

            // If the user is not assigned to any of the selected roles, proceed with the assignment
            // foreach ($selectedRoles as $roleId) {
            //     UsersHasRoles::create([
            //         'user_id' => $userId,
            //         'role_id' => $roleId,
            //         'office_id' => $office_id,
            //     ]);
            // }
            // DB::transaction();
            $userDetails = User::where('id', $userId)->first();
            if (!$userDetails) {
                throw new Exception("User not found");
            }

            User::where('id', $userId)->update(['is_active' => 1]);

            if ($userDetails->syncRoles($selectedRoles)) {
                DB::commit();

                $this->notification()->success(
                    $title = 'Success',
                    $description = $userDetails->emp_name . ' roles updated and User is Activated successfully.'
                );
            } else {
                throw new Exception("Failed to sync roles");
            }
            Cache::forget('user_has_roles');
            $this->emit('reset');
            $this->emit('openEntryForm');
            $this->reset();
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->notification()->error(
                $title = 'Error !!!',
                $description = $e->getMessage(),
            );
            $this->emit('showError', $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.roles.assign-role.create');
    }
}
