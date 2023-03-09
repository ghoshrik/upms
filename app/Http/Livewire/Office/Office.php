<?php

namespace App\Http\Livewire\Office;

use Livewire\Component;

class Office extends Component
{
    public $formOpen = false;
    protected $listeners = ['openForm' => 'fromEntryControl'];
    public $openedFormType= false,$isFromOpen,$subTitel = "List",$selectedIdForEdit,$errorMessage,$titel;

    public $addedOfficeUpdateTrack;

    public function mount()
    {
        $this->addedOfficeUpdateTrack = rand(1,1000);
    }

    public function fromEntryControl($data='')
    {
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
        $this->titel =  "Offices";
        $assets = ['chart', 'animation'];
        return view('livewire.office.office',compact('assets'));
    }
}
