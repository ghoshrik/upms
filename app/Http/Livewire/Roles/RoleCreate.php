<?php

namespace App\Http\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use WireUi\Traits\Actions;

class RoleCreate extends Component
{
    use Actions;

    public $grouped_permissions = array();
    public $selectedPermissions = [];
    public $roleName;
    protected $rules = [
        'roleName' => 'required|min:3',
    ];
    public function mount()
    {
        $permissions = Permission::select('id', 'name')->get();
        $permissions = $permissions->toArray();
        foreach ($permissions as $permission) {
            $name_parts = explode(" ", $permission['name']);
            $group = end($name_parts);
            $this->grouped_permissions[$group][] = array(
                'id' => $permission['id'],
                'name' => str_replace($group, '', $permission['name'])
            );
        }

        foreach ($this->grouped_permissions as $key => $value) {
            $this->grouped_permissions[$key] = array_map(function ($permission) use ($key) {
                return array(
                    'id' => $permission['id'],
                    'name' => str_replace(" $key", '', $permission['name'])
                );
            }, $this->grouped_permissions[$key]);
        }
    }
    public function createRole()
    {
        $this->validate();
        $createdRole = Role::create(['name' => $this->roleName ]);
        if($createdRole){
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
