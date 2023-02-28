<?php

namespace App\Http\Livewire\Components\Modal\Estimate;

use App\Models\EstimatePrepare;
use App\Models\EstimateUserAssignRecord;
use App\Models\SorMaster;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\Cache;

class EstimateRevertModal extends Component
{
    use Actions;
    protected $listeners = ['openRevertModal' => 'openRevertModal'];
    public $openRevertModal = false, $estimate_id, $viewEstimates = [],$userAssignRemarks, $updateDataTableTracker;
    public function openRevertModal($value)
    {
        $this->reset();
        $this->openRevertModal = !$this->openRevertModal;
        if ($value) {
            $this->estimate_id = $value;
            $this->viewEstimates = EstimatePrepare::where('estimate_id', $this->estimate_id)->get();
        }
    }
    public function revertEstimate($value)
    {
        $getUser = EstimateUserAssignRecord::select('estimate_user_type')->where('estimate_id', '=', $value)->where('estimate_user_id', '=', Auth::user()->id)->first();
        if ($getUser['estimate_user_type'] == 1) {
            if (SorMaster::where('estimate_id', $value)->update(['status' => 3])) {
                Cache::put($value.'|recomender', $this->userAssignRemarks);
                $this->notification()->success(
                    $title = 'Estimate Reverted'
                );
            }
        } elseif ($getUser['estimate_user_type'] == 4) {
            if (SorMaster::where('estimate_id', $value)->update(['status' => 9])) {
                Cache::put($value.'|forwader', $this->userAssignRemarks);
                $this->notification()->success(
                    $title = 'Estimate Reverted to Recomender'
                );
            }
        }else{
            $this->notification()->success(
                $title = 'Please Check & try again'
            );
        }
        $this->reset();
        $this->emit('refreshData',$this->updateDataTableTracker);
        // dd($getUser);
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1, 1000);
        return view('livewire.components.modal.estimate.estimate-revert-modal');
    }
}
