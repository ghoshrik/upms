<?php

namespace App\Http\Livewire\MenuManagement;

use App\Models\Menu;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use WireUi\Traits\Actions;

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
            'permission' => '',
        ];
        $this->getDropdownData('menus');
        $this->getDropdownData('permission');
    }
    public function getDropdownData($lookingFor)
    {
        try {
            switch ($lookingFor) {
                case 'menus':
                    $this->dropDownData['menus'] = Menu::all();
                    break;
                case 'permission':
                    $this->formatingPermission();
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
        $currentKey = '';
        $permissions = Permission::all();
        foreach ($permissions as  $permission) {
            $permissionArray = explode(' ', $permission->name);
            if ($permissionArray[1] != $currentKey) {
                $currentKey = $permissionArray[1];
                $this->dropDownData['permissions'][] = $currentKey;
                $this->formatedPermission[$currentKey] = $permission->name;
            } else {
                $this->formatedPermission[$currentKey] = $this->formatedPermission[$currentKey] . ',' . $permission->name;
            }
        }
    }
    public function store()
    {
        $this->newMenuData['permission'] = $this->formatedPermission[$this->newMenuData['permission']] ;
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
