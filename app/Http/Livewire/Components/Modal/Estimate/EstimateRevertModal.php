<?php

namespace App\Http\Livewire\Components\Modal\Estimate;

use App\Models\EstimatePrepare;
use App\Models\EstimateUserAssignRecord;
use App\Models\SorMaster;
use Livewire\Component;
use WireUi\Traits\Actions;

class EstimateRevertModal extends Component
{
    use Actions;
    protected $listeners = ['openRevertModal' => 'openRevertModal'];
    public $openRevertModal = false, $estimate_id, $viewEstimates = [], $updateDataTableTracker;
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
        $getUser = EstimateUserAssignRecord::where([['estimate_id',$value],['estimate_user_type',2]])->first();
        if (SorMaster::where('estimate_id', $value)->update(['status' => 3])) {
            $this->notification()->success(
                $title = 'Estimate Reverted'
            );
        }
        $this->reset();
        // dd($getUser);
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1, 1000);
        return view('livewire.components.modal.estimate.estimate-revert-modal');
    }
}
