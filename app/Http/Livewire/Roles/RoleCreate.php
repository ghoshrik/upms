<?php

namespace App\Http\Livewire\Roles;

use App\Models\Levels;
use App\Models\Role as RoleModal;
use Livewire\Component;
use WireUi\Traits\Actions;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleCreate extends Component
{
    use Actions;

    public $grouped_permissions = array();
    public $selectedPermissions = [];
    public $roleName, $dropDownData = [], $levelNo, $roleParent;
    protected $rules = [
        'roleName' => 'required|min:3',
    ];
    public function mount()
    {
        $permissions = Permission::select('id', 'name')->get();
        $this->dropDownData['levels'] = Levels::get();
        $this->dropDownData['roles'] = [];
        $permissions = $permissions->toArray();
        foreach ($permissions as $permission) {
            $name_parts = explode(" ", $permission['name']);
            $group = end($name_parts);
            $this->grouped_permissions[$group][] = array(
                'id' => $permission['id'],
                'name' => str_replace($group, '', $permission['name']),
            );
        }

        foreach ($this->grouped_permissions as $key => $value) {
            $this->grouped_permissions[$key] = array_map(function ($permission) use ($key) {
                return array(
                    'id' => $permission['id'],
                    'name' => str_replace(" $key", '', $permission['name']),
                );
            }, $this->grouped_permissions[$key]);
        }
    }
    public function checkHasAnyRole()
    {
        if ($this->levelNo != '') {
            $level = Levels::find($this->levelNo);
            if ($level) {
                $this->dropDownData['roles'] = $level->levelHasRoles;
                if (count($this->dropDownData['roles']) == 0) {
                    $this->notification()->error(
                        $title = 'Role Parent Check',
                        $description = 'No Parent Role on this Level or <br/> Please create Role of previous Level Role First.'
                    );
                    unset($this->dropDownData['roles']);
                    $this->roleParent = 0;
                }else{
                    $this->roleParent = '';
                }
            }
        }
    }
    public function checkExistsRole()
    {
        $roleName = Role::where('name', $this->roleName)->exists();
        // dd($roleName);
        if($roleName)
        {
            $this->notification()->error(
                $description = 'Role Name Already exists'
            );
            return;
        }
        // else
        // {
        //     $this->notification()->success(
        //         $description = 'Role Name Already exists'
        //     );
        // }

        $this->createRole();
    }

    public function createRole()
    {
        $this->validate();
        $createdRole = Role::create(['name' => $this->roleName, 'has_level_no' => $this->levelNo, 'role_parent' => $this->roleParent,'guard_name'=>'web']);
        // dd($this->selectedPermissions);
        if ($createdRole) {
            $createdRole->givePermissionTo($this->selectedPermissions);
            $this->notification()->success(
                $title = 'Role Created',
                $description = 'Role was successfully created'
            );
            $this->emit('openEntryForm');
            $this->reset();
        }
    }
    public function render()
    {
        return view('livewire.roles.role-create');
    }
}
