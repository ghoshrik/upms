<?php

namespace App\Http\Livewire\AssignToAnotherOffice;

use Livewire\Component;

class AssignToAnotherOffice extends Component
{
    public $openedFormType= false,$isFromOpen,$subTitel = "List",$titel='Assign To Another Office',$selectedIdForEdit,$errorMessage;
    public $selectedTab = 2,$counterData=[];
    public $updateDataTableTracker=0;
    protected $listeners = ['openForm' => 'fromEntryControl','refreshData' => 'mount','showError'=>'setErrorAlert'];
    public function mount()
    {
        $this->counterData['totalDataCount']=0;
        $this->counterData['draftDataCount']=0;
        $this->counterData['forwardedDataCount']=0;
        $this->counterData['revertedDataCount']=0;
    }
    public function requestData()
    {
        $this->selectedTab = '';
        $this->selectedTab = 2;
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
            // $this->selectedIdForEdit = $data['id'];
            $this->emit('editEstimateRow',$data['id']);
        }
        // $this->updateDataTableTracker = rand(1,1000);
    }
    public function render()
    {
        return view('livewire.assign-to-another-office.assign-to-another-office');
    }
}
