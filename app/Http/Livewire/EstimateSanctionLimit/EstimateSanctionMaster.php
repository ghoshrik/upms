<?php

namespace App\Http\Livewire\EstimateSanctionLimit;

use Livewire\Component;

class EstimateSanctionMaster extends Component
{
    public $formOpen = false;
    protected $listeners = ['openEntryForm' => 'fromEntryControl','showError'=>'setErrorAlert'];
    public $openedFormType= false,$isFromOpen,$subTitle = "List",$selectedIdForEdit,$errorMessage,$title;

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
                $this->subTitle = 'Create';
                break;
            case 'edit':
                $this->subTitle = 'Edit';
                break;
            default:
                $this->subTitle = 'List';
                break;
        }
        if(isset($data['id'])){
            $this->selectedIdForEdit = $data['id'];
        }
    }
    public function setErrorAlert($errorMessage)
    {
       $this->errorMessage = $errorMessage;
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1, 1000);
        $this->title = 'Estimate Sanction Limit Master';
        $assets = ['chart', 'animation'];
        return view('livewire.estimate-sanction-limit.estimate-sanction-master');
    }
}
