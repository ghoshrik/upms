<?php

namespace App\Http\Livewire\MenuManagement;

use App\Models\Menu;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use WireUi\Traits\Actions;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class CreateMenu extends Component
{
    use Actions;

    public $dropDownData = [], $formatedPermission = [], $newMenuData = [];


    public function mount()
    {
        $this->newMenuData = [
            'title' => '',
            'parent_id' => '',
            'icon' => '',
            'link' => '',
            'link_type' => '',
            'piority'=>0,
            'permission_or_role'=>'',
            'permissions_roles' => '',
        ];
        $this->getDropdownData('menus');
        // $this->getDropdownData('permission');
    }
    public function getDropdownData($lookingFor)
    {
        $lookingFor=is_array($lookingFor) ? $lookingFor['_x_bindings']['value']:$lookingFor;
        try {
            switch (Str::lower($lookingFor)) {
                case 'menus':
                    $this->dropDownData['menus'] = Menu::all();
                    break;
                case 'permission':
                    $this->formatingPermission();
                    break;
                case 'role':
                    $this->dropDownData['permissionsRoles'] = Role::all();
                    break;
                default:
                    $this->dropDownData['menus'] = Menu::all();
                    break;
            }
        } catch (\Throwable $th) {
            session()->flash('serverError', $th->getMessage());
        }
    }
    public function formatingPermission()
    {
        $permissions = Permission::all();
        $groupedPermissions = $permissions->groupBy(function ($permission) {
            // extract the role from the permission name without the action prefix
            return str_replace(['create ', 'update '], '', $permission['name']);
        });

        $formatedPermissions = $groupedPermissions->reduce(function ($result, $permissions, $role) {
            // concatenate the permission names for each role
            $permissionsArray = $permissions->pluck('name')->toArray();
            $roleWords = explode(' ', $role);
            $roleName = end($roleWords);
            if (isset($result[$roleName])) {
                $result[$roleName] .= ',' . implode(',', $permissionsArray);
            } else {
                $result[$roleName] = implode(',', $permissionsArray);
            }
            return $result;
        }, []);
        $this->dropDownData['permissionsRoles']=$formatedPermissions;
    }
    public function store()
    {
        $this->newMenuData['parent_id'] = 0;
        $permissionsRoles = $this->dropDownData['permissionsRoles'];
        $selectedIndex = $this->newMenuData['permissions_roles'];
        $selectedPermissionRole = $permissionsRoles[$selectedIndex];
        $this->newMenuData['permissions_roles'] = (is_array($selectedPermissionRole))?$selectedPermissionRole['name']:$selectedPermissionRole;
        // dd($this->newMenuData);
        if (Menu::create($this->newMenuData)) {
            $this->notification()->success(
                $title = 'Success',
                $description =  'New Menu created successfully!'
            );
            $this->reset();
            $this->emit('openEntryForm');
            return;
        }
        $this->notification()->error(
            $title = 'Error !!!',
            $description = 'Something went wrong.'
        );
    }
    public function render()
    {
        return view('livewire.menu-management.create-menu');
    }
}
