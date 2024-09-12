<?php

namespace App\Http\Livewire\Components\Modal\User;

use App\Models\Role;
use App\Models\User;
use App\Models\Group;
use Livewire\Component;
use App\Models\UsersHasRoles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AssignRole extends Component
{
    public $openRoleModalForm = false,$editUserRole, $fetchDropdownData = [], $userRoles, $role_id = '';
    
    protected $rules = [
        'userRoles' => 'required',
    ];
    protected $messages = [
        'userRoles.required' => 'This Field is Required'
    ];
    public function mount(){
        $this->openRoleModalForm = !$this->openRoleModalForm;
        $this->editUserRole = User::where('id',$this->editUserRole)->first();
        // $this->userRoles = $user->getUserRole->pluck('role_id');
        $this->userRoles = Role::join('users_has_roles','roles.id','=','users_has_roles.role_id')
                                ->where('users_has_roles.user_id', $this->editUserRole->id)
                                ->get();
        $assignedRoles = $this->editUserRole->getUserRole->pluck('role_id');
        $this->fetchDropdownData['roles'] = Role::whereIn('name', ['Department Admin', 'Group Admin', 'SOR Preparer'])
                                            ->whereNotIn('id', $assignedRoles)
                                            ->orderBy('name')
                                            ->select('id', 'name')->get();
    }
    public function getRoleWiseData()
    {
        $getRole = Role::where('id',$this->role_id)->first();
        if($getRole->name == 'Group Admin'){
            $this->fetchDropdownData['groups'] = Group::where('department_id',Auth::user()->department_id)->get();
        }else{
            unset($this->fetchDropdownData['groups']);
        }
    }
    public function updateUserRole()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            if (count($this->userRoles) > 0) {
                // Delete existing roles for the user
                UsersHasRoles::where('user_id', $this->editUserRole->id)->delete();
                // Create new roles for the user
                foreach ($this->userRoles as $role) {
                    UsersHasRoles::create([
                        'user_id' => $this->editUserRole->id,
                        'role_id' => $role,
                    ]);
                }
            } else {
                $this->openRoleModalForm = true;
            }
            // Commit the transaction
            DB::commit();
            $this->openRoleModalForm = !$this->openRoleModalForm;
        } catch (\Exception $e) {
            // Rollback the transaction if there was an error
            DB::rollBack();
        }
    }
    public function render()
    {
        return view('livewire.components.modal.user.assign-role');
    }
}
