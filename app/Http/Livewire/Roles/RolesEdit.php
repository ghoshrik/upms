<?php

namespace App\Http\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use WireUi\Traits\Actions;

class RolesEdit extends Component
{
    use Actions;
    public $grouped_permissions = array();
    public $selectedPermissions = [];
    public $roleName;
    public $selectedRole ;
    protected $listeners = ['editRole'];
    public function mount($id)
    {
        $this->getAllPermission();
        $this->getSelectedModelData($id);
    }
    public function getAllPermission()
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
    public function getSelectedModelData($id)
    {
        $this->selectedRole = Role::find($id);
        $this->roleName = $this->selectedRole->name;
        $this->selectedPermissions = $this->selectedRole->permissions->pluck('name');
    }
    public function updateRole()
    {
        // $this->validate();
        $this->selectedRole->name = $this->roleName;
        $createdRole = $this->selectedRole->update();
        if($createdRole){
            $this->selectedRole->syncPermissions($this->selectedPermissions);
            $this->notification()->success(
                $title = 'Role Updated',
                $description = 'Role was successfully Updated'
            );
            $this->emit('openEntryForm');
            $this->reset();
        }
    }
    public function render()
    {
        return view('livewire.roles.roles-edit');
    }
}
