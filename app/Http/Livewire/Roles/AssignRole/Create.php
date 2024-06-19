<?php

namespace App\Http\Livewire\Roles\AssignRole;

use App\Models\User;
use App\Models\Levels;
use App\Models\Office;
use App\Models\States;
use Livewire\Component;
use App\Models\UserType;
use WireUi\Traits\Actions;
use App\Models\Designation;
use App\Models\UsersHasRoles;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Create extends Component
{
    use Actions;
    public $dropDownData = [], $newAccessData = [], $access_type_name = [], $userlist = [], $openAssignModal;

    public function mount()
    {

        // dd($users);
        $this->newAccessData = [
            'role_type' => '',
            'users_id' => '',
            //     'roles_id' => [],
        ];
        // $this->getDropdownData('userTypes');
        if (Auth::user()->roles->first()->name == 'Super Admin') {
            $this->dropDownData['states'] = States::all();
            $this->newAccessData['state_code'] = '';
        }else{
            $this->newAccessData['level_id'] = '';
            $this->dropDownData['levels'] = [];
        }
        if(Auth::user()->roles->first()->has_level_no == ''){
            $this->dropDownData['userTypes'] = Role::where('role_parent',Auth::user()->roles->first()->id)->get();
            if($this->dropDownData['userTypes'][0]['has_level_no'] != ''){
                $this->newAccessData['level_no'] = $this->dropDownData['userTypes'][0]['has_level_no'];
                $this->getDropdownData('designations');
            }
        }
    }
    public function getDropdownData($lookingFor)
    {
        try {
            switch ($lookingFor) {
                case 'userTypes':
                    $this->dropDownData['userTypes'] = UserType::where('parent_id', Auth::user()->user_type)->get();
                    break;
                case 'designations':
                    $this->dropDownData['designations'] = Designation::where('level_no',$this->newAccessData['level_no'])->get();
                    break;
                case 'OFC':
                    $this->dropDownData['offices'] = Office::where('id', Auth::user()->office_id)->get();
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
    public function getUserList(){
        if($this->newAccessData['role_type'] != ''){
            $query = User::where('user_type',$this->newAccessData['role_type']);
        }
        if(isset($this->newAccessData['state_code']) && $this->newAccessData['state_code'] != ''){
            $query = $query->where('state_code',$this->newAccessData['state_code']);
        }
        if($query){
            $this->dropDownData['users'] = $query->get();
        }else{
            $this->dropDownData['users'] = [];
        }

    }
    public function getUsers()
    {
        $this->dropDownData['users'] = User::select('users.id', 'users.emp_name', 'users.ehrms_id', 'users.designation_id', 'users.office_id', 'users.mobile', 'users.email')->join('user_types', 'users.user_type', '=', 'user_types.id')
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
            $selectedRoles = $this->newAccessData['roles_id'];
            // foreach ($selectedUsers as $userId) {
            //     $userDetails = User::leftjoin('users_has_roles', 'users_has_roles.user_id', 'users.id')->where('users.id', $userId)->first();
            //     if ($userDetails->user_id != null) {
            //         $this->notification()->error(
            //             $title = 'Error !!!',
            //             $description = $userDetails->emp_name . ' already assign to role please update.'
            //         );
            //         return;
            //     }
            //     foreach ($selectedRoles as $roleId) {
            //         UsersHasRoles::create([
            //             'user_id' => $userId,
            //             'role_id' => $roleId
            //         ]);
            //         $userDetails->syncRoles($roleId);
            //     }
            // }
            $userDetails = User::leftjoin('users_has_roles', 'users_has_roles.user_id', 'users.id')->where('users.id', $userId)->first();
            if ($userDetails->user_id != null) {
                $this->notification()->error(
                    $title = 'Error !!!',
                    $description = $userDetails->emp_name . ' already assign to role please update.'
                );
                return;
            }
            foreach ($selectedRoles as $roleId) {
                UsersHasRoles::create([
                    'user_id' => $userId,
                    'role_id' => $roleId,
                ]);
                $userDetails->syncRoles($roleId);
            }
            Cache::forget('user_has_roles');
            $this->emit('openEntryForm');
            $this->reset();
        } catch (\Throwable $th) {
            $this->emit('showError', $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.roles.assign-role.create');
    }
}
