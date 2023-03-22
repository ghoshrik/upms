<?php

namespace App\Http\Livewire\Permission;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use WireUi\Traits\Actions;

class PermissionCreate extends Component
{
    use Actions;

    public $permissionName;
    protected $rules = [
        'permissionName' => 'required|min:6',
    ];

    public function submit()
    {
        $this->validate();
        $createdPermission = Permission::create(['name' => $this->permissionName]);
        if ($createdPermission) {
            $this->notification()->success(
                $title = 'Permission Created',
                $description = 'Permission was successfully created'
            );
            $this->emit('openEntryForm');
            $this->reset();
            
        }

    }
    public function render()
    {
        return view('livewire.permission.permission-create');
    }
}
