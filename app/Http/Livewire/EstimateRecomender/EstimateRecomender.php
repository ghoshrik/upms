<?php

namespace App\Http\Livewire\EstimateRecomender;

use App\Models\SorMaster;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class EstimateRecomender extends Component
{
    use Actions;
    public $formOpen = false, $modifyFormOpen = false, $updateDataTableTracker, $selectedEstTab = 1, $counterData = [];
    protected $listeners = ['openForm' => 'formOCControl','refreshData' => 'mount'];
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
    public function revertedData()
    {
        $this->selectedEstTab = '';
        $this->selectedEstTab = 3;
        $this->dataCounter();
        // $this->notification()->error(
        //     $title = 'Estimate Revert is under devlopment'
        // );
    }

    public function dataCounter()
    {
        $this->counterData['totalPendingDataCount'] =SorMaster::join('estimate_user_assign_records', 'estimate_user_assign_records.estimate_id', '=', 'sor_masters.estimate_id')
            ->where('estimate_user_assign_records.estimate_user_id', '=', Auth::user()->id)
            ->where('estimate_user_assign_records.estimate_user_type', '=', 1)
            ->where('sor_masters.is_verified', '=', 0)
            ->count();
        $this->counterData['pendingDataCount'] = SorMaster::join('estimate_user_assign_records', 'estimate_user_assign_records.estimate_id', '=', 'sor_masters.estimate_id')
            ->where('estimate_user_assign_records.estimate_user_id', '=', Auth::user()->id)
            ->where('estimate_user_assign_records.estimate_user_type', '=', 1)
            ->where('sor_masters.is_verified', '=', 0)
            ->where('sor_masters.status','!=',3)
            ->where('sor_masters.status','!=',11)
            ->where('sor_masters.status','!=',9)
            ->count();
        $this->counterData['forwardedDataCount'] =  SorMaster::join('estimate_user_assign_records', 'estimate_user_assign_records.estimate_id', '=', 'sor_masters.estimate_id')
            ->where('estimate_user_assign_records.estimate_user_id', '=', Auth::user()->id)
            ->where('estimate_user_assign_records.estimate_user_type', '=', 1)
            ->where('sor_masters.is_verified', '=', 0)
            ->where('sor_masters.status','=',8)
            ->count();
        $this->counterData['revertedDataCount'] = SorMaster::join('estimate_user_assign_records', 'estimate_user_assign_records.estimate_id', '=', 'sor_masters.estimate_id')
            ->where('estimate_user_assign_records.estimate_user_id', '=', Auth::user()->id)
            ->where('estimate_user_assign_records.estimate_user_type', '=', 1)
            ->where('sor_masters.is_verified', '=', 0)
            ->where('sor_masters.status','=',9)
            // ->where([['sor_masters.status','=',9],['sor_masters.is_verified','=',0]])
            ->count();
        // dd($this->counterData);
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
        $this->updateDataTableTracker = rand(1, 1000);
        $this->emit('changeTitel', 'Estimate Recomender');
        return view('livewire.estimate-recomender.estimate-recomender');
    }
}
