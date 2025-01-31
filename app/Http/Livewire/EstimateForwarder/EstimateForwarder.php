<?php

namespace App\Http\Livewire\EstimateForwarder;

use App\Models\EstimateUserAssignRecord;
use App\Models\SorMaster;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EstimateForwarder extends Component
{
    protected $listeners = ['openForm' => 'fromEntryControl','wordDownload'=>'exportAndDownload','showError'=>'setErrorAlert','refreshData' => 'fromEntryControl'];
    public $updateDataTableTracker, $selectedEstTab = 1, $counterData = [];
    public $openedFormType= false,$isFromOpen,$subTitel = "List",$selectedIdForEdit,$errorMessage,$titel;
    public function mount()
    {
        $this->updateDataTableTracker = rand(1,1000);
        $this->draftData();
    }
    public function draftData()
    {
        $this->selectedEstTab = '';
        $this->selectedEstTab = 1;
        $this->dataCounter();
    }
    public function verifiedData()
    {
        $this->selectedEstTab = '';
        $this->selectedEstTab = 2;
        $this->dataCounter();
    }
    public function dataCounter()
    {
        $this->counterData['totalPendingDataCount'] =EstimateUserAssignRecord::where(function($query){
            $query->where('status',8)
            ->orWhere('status',9);
        })
        ->where(function($query){
            $query->where('user_id',Auth::user()->id)
            ->orWhere('assign_user_id',Auth::user()->id);
        })
        ->count();
        $this->counterData['pendingDataCount'] = EstimateUserAssignRecord::where('status',9)
        ->where('assign_user_id',Auth::user()->id)
        ->where('is_done',0)
        ->count();
        $this->counterData['verifiedDataCount'] =  SorMaster::join('estimate_user_assign_records', 'estimate_user_assign_records.estimate_id', '=', 'sor_masters.estimate_id')
            ->where('estimate_user_assign_records.user_id', '=', Auth::user()->id)
            ->where('estimate_user_assign_records.estimate_user_type', '=', 9)
            ->where('sor_masters.is_verified', '=', 1)
            ->count();
        // $this->counterData['revertedDataCount'] = SorMaster::join('estimate_user_assign_records', 'estimate_user_assign_records.estimate_id', '=', 'sor_masters.estimate_id')
        //     ->where('estimate_user_assign_records.user_id', '=', Auth::user()->id)
        //     ->where('estimate_user_assign_records.estimate_user_type', '=', 1)
        //     ->where('status', '=', 3)
        //     ->count();
        // dd($this->counterData);
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
    public function setErrorAlert($errorMessage)
    {
       $this->errorMessage = $errorMessage;
    }
    // public function formOCControl($isModifyFrom = false, $eidtId = null)
    // {
    //     if ($isModifyFrom) {
    //         $this->modifyFormOpen = !$this->modifyFormOpen;
    //         $this->emit('changeSubTitel', ($this->modifyFormOpen) ? 'Modify' : 'List');
    //         if ($eidtId != null) {
    //             $this->emit('modifyEstimateRow', $eidtId);
    //         }
    //         return;
    //     }
    //     $this->modifyFormOpen = false;
    //     $this->formOpen = !$this->formOpen;
    //     $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
    //     $this->updateDataTableTracker = rand(1, 1000);
    // }
    public function render()
    {
        $this->updateDataTableTracker = rand(1,1000);
        $this->titel= 'Estimate Forwarder';
        $assets = ['chart', 'animation'];
        return view('livewire.estimate-forwarder.estimate-forwarder',compact('assets'));
    }
}
