<?php

namespace App\Http\Livewire\Components\Modal\Estimate;

use App\Models\EstimatePrepare;
use App\Models\EstimateUserAssignRecord;
use App\Models\SorMaster;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class EstimateRevertModal extends Component
{
    use Actions;
    protected $listeners = ['openRevertModal' => 'openRevertModal'];
    public $openRevertModal = false, $estimate_id, $viewEstimates = [], $userAssignRemarks, $updateDataTableTracker;
    public $revartRequestFrom;
    public function openRevertModal($value)
    {
        $this->reset();
        $estimate_id = is_array($value) ? $value['estimate_id'] : $value;
        $this->revartRequestFrom = $value['revart_from'];
        $this->openRevertModal = !$this->openRevertModal;
        if ($estimate_id) {
            $this->estimate_id = $estimate_id;
            $this->viewEstimates = EstimatePrepare::where('estimate_id', $this->estimate_id)->get();
        }
    }
    public function revertEstimate($value)
    {
        if ($this->revartRequestFrom == 'ER') {
            $getStatus = SorMaster::select('status')->where('estimate_id',$value)->first();
            // $getUserDetails = EstimateUserAssignRecord::select('user_id', 'estimate_user_type')->where([['estimate_id', '=', $value], ['assign_user_id', '=', Auth::user()->id], ['status', '=', $getStatus->status], ['is_done', 0]])->first();
            $getUserDetails = EstimateUserAssignRecord::select('user_id', 'estimate_user_type')->where([['estimate_id', '=', $value], ['assign_user_id', '=', 0], ['status', '=', 1]])->first();
            // dd($getUserDetails);
            $data = [
                'estimate_id' => $value,
                'user_id' => Auth::user()->id,
                'assign_user_id' => (int) $getUserDetails->user_id,
                'comments' => $this->userAssignRemarks,
            ];
            $data['status'] = 3;
            if ($assignDetails = EstimateUserAssignRecord::create($data)) {
                if ($assignDetails) {
                    $returnId = $assignDetails->id;
                    EstimateUserAssignRecord::where([['estimate_id', $value], ['id', '!=', $returnId], ['is_done', 0]])->groupBy('estimate_id')->update(['is_done' => 1]);
                    $this->notification()->success(
                        $title = 'Estimate Reverted'
                    );
                }
                SorMaster::where('estimate_id', $value)->update(['status' => 3]);
            }
        } elseif ($this->revartRequestFrom == 'EF') {
            $getUserDetails = EstimateUserAssignRecord::select('user_id', 'estimate_user_type')->where([['estimate_id', '=', $value], ['assign_user_id', '=', Auth::user()->id], ['status', '=', 9], ['is_done', 0]])->first();
            $data = [
                'estimate_id' => $value,
                'user_id' => Auth::user()->id,
                'assign_user_id' => (int) $getUserDetails->user_id,
                'comments' => $this->userAssignRemarks,
            ];
            $data['status'] = 7;
            if ($assignDetails = EstimateUserAssignRecord::create($data)) {
                if ($assignDetails) {
                    $returnId = $assignDetails->id;
                    EstimateUserAssignRecord::where([['estimate_id', $value], ['id', '!=', $returnId], ['is_done', 0]])->groupBy('estimate_id')->update(['is_done' => 1]);
                    $this->notification()->success(
                        $title = 'Estimate Reverted to Recomender'
                    );
                }
                SorMaster::where('estimate_id', $value)->update(['status' => 7]);
            }else {
                $this->notification()->success(
                    $title = 'Opps! somethig waint wrong.'
                );
            }
        } else {
            $this->notification()->success(
                $title = 'Please Check & try again'
            );
        }
        $this->reset();
        $this->emit('refreshData', $this->updateDataTableTracker);
        // dd($getUser);
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1, 1000);
        return view('livewire.components.modal.estimate.estimate-revert-modal');
    }
}
