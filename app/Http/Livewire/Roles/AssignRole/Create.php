<?php

namespace App\Http\Livewire\Roles\AssignRole;

use App\Models\AccessType;
use App\Models\Designation;
use App\Models\Office;
use App\Models\User;
use App\Models\UsersHasRoles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use WireUi\Traits\Actions;

class Create extends Component
{
    use Actions;
    public $dropDownData = [], $newAccessData = [], $access_type_name = [], $userlist = [];

    public function mount()
    {
        $this->newAccessData = [
            'designation_id' => null,
            'users_id' => [],
            'roles_id' => [],
        ];
        $this->getDropdownData('designations');
        $this->getDropdownData('roles');
    }
    public function getDropdownData($lookingFor)
    {
        try {
            switch ($lookingFor) {
                case 'designations':
                    $this->dropDownData['designations'] = Designation::all();
                    break;
                case 'OFC':
                    $this->dropDownData['offices'] = Office::where('id', Auth::user()->office_id)->get();
                    break;
                case 'roles':
                    $this->dropDownData['roles'] = Role::join('roles_order','roles.id','=','roles_order.role_id')->where('roles_order.parent_id','>',3)->get();
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


    public function getUsers()
    {
        $this->dropDownData['users'] = User::select('users.id', 'users.emp_name')->join('user_types', 'users.user_type', '=', 'user_types.id')
            ->where([['parent_id', Auth::user()->user_type], ['department_id', Auth::user()->department_id], ['designation_id', $this->newAccessData['designation_id']], ['office_id', Auth::user()->office_id]])->get();
    }


    public function store()
    {
        try {
            $selectedUsers = $this->newAccessData['users_id'];
            $selectedRoles = $this->newAccessData['roles_id'];
            foreach ($selectedUsers as $userId) {
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
                        'role_id' => $roleId
                    ]);
                    $userDetails->syncRoles($roleId);
                }
            }
            Cache::forget('user_has_roles');
            $this->emit('openEntryForm');
            $this->reset();
        } catch (\Throwable $th) {
            dd($th);
        }
    }


    public function render()
    {
        return view('livewire.roles.assign-role.create');
    }
}
