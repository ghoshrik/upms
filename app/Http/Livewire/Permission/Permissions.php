<?php

namespace App\Http\Livewire\Permission;

use Livewire\Component;

class Permissions extends Component
{

    protected $listeners = ['openEntryForm' => 'fromEntryControl'];
    public $openedFormType= false,$isFromOpen,$subTitel = "List",$selectedIdForEdit,$errorMessage,$titel,$updateDataTableTracker;

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
        $this->titel = "ALL Permissions";
        $assets = ['chart', 'animation'];
        return view('livewire.permission.permissions');
    }
}
