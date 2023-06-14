<?php

namespace App\Http\Livewire\QuantityEvaluation;

use Livewire\Component;

class QuantityEvaluation extends Component
{
    public $formOpen = false, $editFormOpen = false,$updateDataTableTracker,$selectedTab = 1,$counterData=[];
    protected $listeners = ['openForm' => 'fromEntryControl','refreshData' => 'render','showError'=>'setErrorAlert'];
    public $openedFormType= false,$isFromOpen,$subTitel = "List",$selectedIdForEdit,$errorMessage,$titel;
    public function mount()
    {
        // $this->draftData();
    }
    public function draftData()
    {
        $this->selectedTab = '';
        $this->selectedTab = 1;
        $this->dataCounter();
    }
    public function forwardedData()
    {
        $this->selectedTab = '';
        $this->selectedTab = 2;
        $this->dataCounter();
    }
    public function revertedData()
    {
        $this->selectedTab = '';
        $this->selectedTab = 3;
        $this->dataCounter();
    }
    // public function dataCounter()
    // {
    //     $this->counterData['totalDataCount'] = EstimateUserAssignRecord::where('status',1)
    //     ->where('user_id',Auth::user()->id)
    //     ->count();
    //     $this->counterData['draftDataCount'] = EstimateUserAssignRecord::where(function($query){
    //         $query->where('status',1)
    //         ->orWhere('status',10);
    //     })
    //     ->where('user_id',Auth::user()->id)
    //     ->where('is_done',0)
    //     ->count();
    //     $this->counterData['forwardedDataCount'] =  EstimateUserAssignRecord::query()
    //     ->selectRaw('count(status)')
    //     ->where('status', 2)
    //     ->where('user_id', Auth::user()->id)
    //     ->where('created_at', function ($query) {
    //         $query->selectRaw('MAX(created_at)')
    //             ->from('estimate_user_assign_records as t2')
    //             ->whereColumn('estimate_user_assign_records.estimate_id', 't2.estimate_id')
    //             ->where('t2.status', 2);
    //     })
    //     ->count();
    //     $this->counterData['revertedDataCount'] = EstimateUserAssignRecord::where('status',3)
    //     ->where('assign_user_id',Auth::user()->id)
    //     ->where('is_done',0)
    //     ->count();
    // }
    public function setErrorAlert($errorMessage)
    {
       $this->errorMessage = $errorMessage;
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
        $this->updateDataTableTracker = rand(1,1000);
    }
    public function formOCControl($isEditFrom = false, $eidtId = null)
    {
        if ($isEditFrom) {
            $this->editFormOpen = !$this->editFormOpen;
            $this->emit('changeSubTitel', ($this->editFormOpen) ? 'Edit' : 'List');
            if ($eidtId != null) {
                $this->emit('editEstimateRow',$eidtId);
            }
            return;
        }
        $this->editFormOpen = false;
        $this->formOpen = !$this->formOpen;
        $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');

    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1,1000);
        $this->titel = "Quantity Evaluation";
        $assets = ['chart', 'animation'];
        return view('livewire.quantity-evaluation.quantity-evaluation',compact('assets'));
    }
}
