<?php

namespace App\Http\Livewire\EstimateForwarder;

use App\Models\SorMaster;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EstimateForwarder extends Component
{
    protected $listeners = ['openForm' => 'formOCControl','wordDownload'=>'exportAndDownload'];
    public $formOpen = false, $modifyFormOpen = false, $updateDataTableTracker, $selectedEstTab = 1, $counterData = [];
    public function mount()
    {
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
        $this->counterData['totalPendingDataCount'] =SorMaster::join('estimate_user_assign_records', 'estimate_user_assign_records.estimate_id', '=', 'sor_masters.estimate_id')
            ->where('estimate_user_assign_records.estimate_user_id', '=', Auth::user()->id)
            ->where('estimate_user_assign_records.estimate_user_type', '=', 4)
            ->count();
        $this->counterData['pendingDataCount'] = SorMaster::join('estimate_user_assign_records', 'estimate_user_assign_records.estimate_id', '=', 'sor_masters.estimate_id')
            ->where('estimate_user_assign_records.estimate_user_id', '=', Auth::user()->id)
            ->where('estimate_user_assign_records.estimate_user_type', '=', 4)
            ->where('sor_masters.is_verified', '=', 0)
            // ->where([['sor_masters.is_verified', '=', 0],['sor_masters.status','=',11]])
            ->count();
        $this->counterData['verifiedDataCount'] =  SorMaster::join('estimate_user_assign_records', 'estimate_user_assign_records.estimate_id', '=', 'sor_masters.estimate_id')
            ->where('estimate_user_assign_records.estimate_user_id', '=', Auth::user()->id)
            ->where('estimate_user_assign_records.estimate_user_type', '=', 4)
            ->where('sor_masters.is_verified', '=', 1)
            ->count();
        // $this->counterData['revertedDataCount'] = SorMaster::join('estimate_user_assign_records', 'estimate_user_assign_records.estimate_id', '=', 'sor_masters.estimate_id')
        //     ->where('estimate_user_assign_records.estimate_user_id', '=', Auth::user()->id)
        //     ->where('estimate_user_assign_records.estimate_user_type', '=', 1)
        //     ->where('status', '=', 3)
        //     ->count();
        // dd($this->counterData);
    }
    public function exportAndDownload($value)
    {
        exportWord($value);
    }
    public function formOCControl($isModifyFrom = false, $eidtId = null)
    {
        if ($isModifyFrom) {
            $this->modifyFormOpen = !$this->modifyFormOpen;
            $this->emit('changeSubTitel', ($this->modifyFormOpen) ? 'Modify' : 'List');
            if ($eidtId != null) {
                $this->emit('modifyEstimateRow', $eidtId);
            }
            return;
        }
        $this->modifyFormOpen = false;
        $this->formOpen = !$this->formOpen;
        $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
        $this->updateDataTableTracker = rand(1, 1000);
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1,1000);
        $this->emit('changeTitel', 'Estimate Forwarder');
        $assets = ['chart', 'animation'];
        return view('livewire.estimate-forwarder.estimate-forwarder',compact('assets'));
    }
}
