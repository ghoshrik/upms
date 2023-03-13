<?php

namespace App\Http\Livewire\AssignOfficeAdmin;

use Livewire\Component;

class AssignOfficeAdmin extends Component
{
    public $updateDataTableTracker;
    protected $listeners = ['openEntryForm' => 'fromEntryControl'];
    public $openedFormType= false,$isFromOpen,$subTitel = "List",$selectedIdForEdit,$errorMessage,$titel;


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
        $this->updateDataTableTracker = rand(1,1000);
        $this->titel = 'Assign Office Admin';
        $assets = ['chart', 'animation'];
        return view('livewire.assign-office-admin.assign-office-admin',compact('assets'));
    }
}
