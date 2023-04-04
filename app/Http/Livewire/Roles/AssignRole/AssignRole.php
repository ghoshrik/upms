<?php

namespace App\Http\Livewire\Roles\AssignRole;

use Livewire\Component;

class AssignRole extends Component
{
    public $formOpen=false,$editFormOpen=false,$updateDataTableTracker;
    public $titel = 'Assign Role';
    public $subTitel='List';
    protected $listeners = ['openEntryForm' => 'fromEntryControl'];
    public $openedFormType= false,$isFromOpen,$selectedIdForEdit,$errorMessage,$AccessManagerTable = [];

    public function fromEntryControl($data='')
    {
        // dd($data);
        $this->openedFormType = is_array($data) ? $data['formType']:$data;
        $this->isFromOpen = !$this->isFromOpen;
        switch ($this->openedFormType) {
            case 'create':
                $this->subTitel = 'Create';
                break;
            case 'edit':
                $this->subTitel = 'Edit';
                break;
            default:
                $this->subTitel = 'List';
                break;
        }
        if(isset($data['id'])){
            $this->selectedIdForEdit = $data['id'];
        }
    }
    public function render()
    {
        return view('livewire.roles.assign-role.assign-role');
    }
}
