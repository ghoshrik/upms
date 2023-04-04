<?php

namespace App\Http\Livewire\MenuManagement;

use App\Models\Menu;
use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use WireUi\Traits\Actions;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class EditMenu extends Component
{
    use Actions;

    public $dropDownData = [], $formatedPermission = [], $newMenuData = [], $selectedMenu;


    public function mount($id)
    {
        // dd(User::role('Estimate Preparer (EP)')->get());
        $this->selectedMenu = Menu::find($id);
        $this->newMenuData = [
            'title' => $this->selectedMenu->title,
            'parent_id' => $this->selectedMenu->parent_id,
            'icon' => $this->selectedMenu->icon,
            'link' => $this->selectedMenu->link,
            'link_type' => $this->selectedMenu->link_type,
            'piority' => $this->selectedMenu->piority,
            'permission_or_role' => $this->selectedMenu->permission_or_role,
            'permissions_roles' => '',
            // 'permissions_roles' => $this->selectedMenu->permissions_roles,
        ];
        $this->getDropdownData('menus');
        $this->getDropdownData($this->selectedMenu->permission_or_role);
    }
    public function getDropdownData($lookingFor)
    {
        $lookingFor = is_array($lookingFor) ? $lookingFor['_x_bindings']['value'] : $lookingFor;
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
        $this->dropDownData['permissionsRoles'] = $formatedPermissions;
    }
    public function store()
    {
        $permissionsRoles = $this->dropDownData['permissionsRoles'];
        $selectedIndex = $this->newMenuData['permissions_roles'];
        $selectedPermissionRole = $permissionsRoles[$selectedIndex];
        $this->newMenuData['permissions_roles'] = (is_array($selectedPermissionRole)) ? $selectedPermissionRole['name'] : $selectedPermissionRole;

        $this->selectedMenu->title = $this->newMenuData['title'];
        $this->selectedMenu->parent_id = $this->newMenuData['parent_id'];
        $this->selectedMenu->icon = $this->newMenuData['icon'];
        $this->selectedMenu->link = $this->newMenuData['link'];
        $this->selectedMenu->link_type = $this->newMenuData['link_type'];
        $this->selectedMenu->piority = $this->newMenuData['piority'];
        $this->selectedMenu->permission_or_role = $this->newMenuData['permission_or_role'];
        $this->selectedMenu->permissions_roles = $this->newMenuData['permissions_roles'];
        // dd(is_array($selectedPermissionRole),$permissionsRoles,$selectedIndex,$selectedPermissionRole,$this->selectedMenu);
        if ($this->selectedMenu->update()) {
            $this->notification()->success(
                $title = 'Success',
                $description =  'Menu Updated successfully!'
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
        return view('livewire.menu-management.edit-menu');
    }
}
