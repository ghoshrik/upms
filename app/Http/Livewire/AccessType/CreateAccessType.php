<?php

namespace App\Http\Livewire\AccessType;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAccessType extends Component
{
    public $dropDownData = [], $newAccessTypeData = [];
    public function mount()
    {
        $this->newAccessTypeData = [
            'access_name'=>'',
            'permissions'=>''
        ];
        $this->getdropDownData();
    }
    public function getDropdownData()
    {
        $this->dropDownData['permissions'] = Permission::all();
    }
    public function store()
    {
        try{
            $role = Role::create(['name' => $this->newAccessTypeData['access_name']]);
            $role->syncPermissions($this->newAccessTypeData['permissions']);
            unset($this->newAccessTypeData['permissions']);
            AccessType::create($this->newAccessTypeData);

            $this->notification()->success(
                $description =  trans('cruds.access-type.create_msg')
            );
            $this->reset();
            $this->emit('openEntryForm');
        }
        catch (\Throwable $th) {
            dd($th->getMessage());
        }

    }
    public function render()
    {
        return view('livewire.access-type.create-access-type');
    }
}
