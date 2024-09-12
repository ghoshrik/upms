<?php

namespace App\Http\Livewire\Components\Modal\User;

use App\Models\Role;
use App\Models\User;
use App\Models\Group;
use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\UsersHasRoles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AssignRole extends Component
{
    use Actions;
    public $openRoleModalForm = false, $editUserRole, $fetchDropdownData = [], $userRoles, $role_id = '',$group_id ='',$office_id = '', $update_key;

    protected $rules = [
        'userRoles' => 'required',
    ];
    protected $messages = [
        'userRoles.required' => 'This Field is Required',
    ];
    public function mount()
    {
        $this->openRoleModalForm = !$this->openRoleModalForm;
        $this->update_key = rand(1,1000);
        $this->editUserRole = User::where('id', $this->editUserRole)->first();
        // $this->userRoles = $user->getUserRole->pluck('role_id');
        $this->userRoles = Role::join('users_has_roles', 'roles.id', '=', 'users_has_roles.role_id')
            ->where('users_has_roles.user_id', $this->editUserRole->id)
            ->get();
        $assignedRoles = $this->editUserRole->getUserRole->pluck('role_id');
        if(Auth::user()->hasRole('Department Admin')){
            $this->fetchDropdownData['roles'] = Role::whereIn('name', ['Department Admin', 'Group Admin', 'SOR Preparer'])
            // ->whereNotIn('id', $assignedRoles)
            ->orderBy('name')
            ->select('id', 'name')->get();
        }elseif(Auth::user()->hasRole('Group Admin')){
            $this->fetchDropdownData['roles'] = Role::whereIn('name', ['Group Admin', 'Office Admin'])
            // ->whereNotIn('id', $assignedRoles)
            ->orderBy('name')
            ->select('id', 'name')->get();
        }elseif(Auth::user()->hasRole('Office Admin')){
            $this->fetchDropdownData['roles'] = Role::where('for_sanction', true)
            // ->whereNotIn('id', $assignedRoles)
            ->orderBy('name')
            ->select('id', 'name')->get();
        }else{

        }
    }
    public function getRoleWiseData()
    {
        $this->reset('group_id','office_id');
        $getRole = Role::where('id', $this->role_id)->first();
        if (isset($getRole->name) && $getRole->name == 'Group Admin') {
            $this->fetchDropdownData['groups'] = Group::where('department_id', $this->editUserRole->department_id)->get();
            if($this->editUserRole->group_id != '' && $this->editUserRole->group_id != 0){
                $this->group_id = $this->editUserRole->group_id;
            }
            // $checkUserHasGroup =
        }elseif(isset($getRole->name) && $getRole->name == 'Office Admin'){
            $group = Group::where('id', $this->editUserRole->group_id)->first();
            $this->fetchDropdownData['offices'] = $group->offices;
            $this->office_id = $this->editUserRole->resources->first()->resource_id ?? '';
        } else {
            unset($this->fetchDropdownData['groups']);
            unset($this->fetchDropdownData['offices']);
        }
        // dd($this->fetchDropdownData);
    }
    public function confDeleteDialogRole($value){
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'icon' => 'error',
            'accept' => [
                'label' => 'Yes, Delete it',
                'method' => 'deleteUserRole',
                'params' => $value,
            ],
            'reject' => [
                'label' => 'No, cancel',
                // 'method' => 'cancel',
            ],
        ]);
    }
    public function deleteUserRole($value){
        // Delete Selected role for the user
        try {
            UsersHasRoles::where([['role_id',$value],['user_id', $this->editUserRole->id]])->delete();
            $getRole = Role::where('id', $value)->first();
            if ($getRole->name == 'Group Admin') {
                User::where('id',$this->editUserRole->id)->update(['group_id' => 0,'dept_category_id' => 0]);
                // dd(User::where('id',$this->editUserRole->id)->get());
            }
            $this->refreshUserRoles();
        } catch (\Throwable $th) {
            $this->emit('showError', $th->getMessage());
        }
    }
    public function refreshUserRoles(){
        $this->editUserRole = User::where('id',$this->editUserRole->id)->first();
        $this->userRoles = Role::join('users_has_roles', 'roles.id', '=', 'users_has_roles.role_id')
            ->where('users_has_roles.user_id', $this->editUserRole->id)
            ->get();
        $assignedRoles = $this->editUserRole->getUserRole->pluck('role_id');
        $this->fetchDropdownData['roles'] = Role::whereIn('name', ['Department Admin', 'Group Admin', 'SOR Preparer'])
            // ->whereNotIn('id', $assignedRoles)
            ->orderBy('name')
            ->select('id', 'name')->get();
        $this->update_key = rand(1,1000);
    }
    public function addUserRole()
    {
        // dd($this->editUserRole,$this->role_id);
        // $this->validate();
        DB::beginTransaction();
        try {
            if ($this->role_id != '') {
                // Delete existing roles for the user
                // UsersHasRoles::where('user_id', $this->editUserRole->id)->delete();
                // Create new roles for the user
                // foreach ($this->userRoles as $role) {
                    $roleExists = UsersHasRoles::where([['user_id', $this->editUserRole->id], ['role_id', $this->role_id]])->get();
                    if (count($roleExists) == 0) {
                        UsersHasRoles::create([
                            'user_id' => $this->editUserRole->id,
                            'role_id' => $this->role_id,
                        ]);
                    }
                    if($this->group_id != ''){
                        User::where('id',$this->editUserRole->id)->update(['group_id' => $this->group_id,'dept_category_id' => Group::where('id',$this->group_id)->first()->dept_category_id]);
                        unset($this->fetchDropdownData['groups']);
                    }
                    else if($this->office_id != ''){
                        if($this->office_id != '' && $this->office_id != 0){
                            $this->editUserRole->resources()->create([
                                'resource_id' => $this->office_id,
                                'resource_type' => 'App\Models\Office',
                            ]);
                            User::where('id',$this->editUserRole->id)->update(['office_id' => $this->office_id]);
                        }
                    }
                // }
            }
            // Commit the transaction
            DB::commit();
            $this->reset('role_id','group_id');
            $this->refreshUserRoles();
        } catch (\Exception $e) {
            // Rollback the transaction if there was an error
            DB::rollBack();
            $this->emit('showError', $e->getMessage());
        }
    }
    public function closeAddRoleDrawer(){
        $this->reset();
        $this->emit('closeAddRoleDrawer');
    }
    public function render()
    {
        return view('livewire.components.modal.user.assign-role');
    }
}
