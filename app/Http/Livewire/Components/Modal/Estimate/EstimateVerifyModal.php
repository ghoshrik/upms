<?php

namespace App\Http\Livewire\Components\Modal\Estimate;

use App\Models\Esrecommender;
use App\Models\EstimatePrepare;
use App\Models\SorMaster;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class EstimateVerifyModal extends Component
{
    use Actions;
    protected $listeners = ['openVerifyModal' => 'openVerifyModal'];
    public $openVerifyModal = false, $estimate_id, $viewEstimates = [], $updateDataTableTracker;

    public function openVerifyModal($estimate_id)
    {
        $this->reset();
        $this->openVerifyModal = !$this->openVerifyModal;
        if ($estimate_id) {
            $this->estimate_id = $estimate_id;
            $this->viewEstimates = EstimatePrepare::where('estimate_id', $this->estimate_id)->get();
        }
    }
    public function verifyEstimate($value)
    {
        $this->emit('openForwardModal',$value);
        // try {
        //     $checkForVerify = Esrecommender::where('estimate_id', $value)->first();
        //     if ($checkForVerify != NULL) {
        //         // dd('modified');
        //         if (SorMaster::where('estimate_id', $value)->update(['is_verified' => 1,'status' => 8])) {
        //             $this->notification()->success(
        //                 $title = 'Verified Estimate !!'
        //             );
        //         }
        //     } else {
        //         $verifyEstimate = EstimatePrepare::where('estimate_id', $value)->get();
        //         // dd('modify & verify');
        //         if ($verifyEstimate != NULL) {
        //             foreach ($verifyEstimate as $key => $estimate) {
        //                 $insert = [
        //                     'estimate_id' => $value,
        //                     'dept_id' => $estimate['dept_id'],
        //                     'category_id' => $estimate['category_id'],
        //                     'row_id' => $estimate['row_id'],
        //                     'row_index' => $estimate['row_index'],
        //                     'sor_item_number' => $estimate['sor_item_number'],
        //                     'estimate_no' => $estimate['estimate_no'],
        //                     'item_name' => $estimate['item_name'],
        //                     'other_name' => $estimate['other_name'],
        //                     'qty' => $estimate['qty'],
        //                     'rate' => $estimate['rate'],
        //                     'total_amount' => $estimate['total_amount'],
        //                     'operation' => $estimate['operation'],
        //                     'percentage_rate' => $estimate['perRate'],
        //                     'verified_by' => Auth::user()->id,
        //                     'commends' => $estimate['AddRemarks'],
        //                 ];
        //                 dd($insert);
        //                 Esrecommender::create($insert);
        //             }
        //             if (SorMaster::where('estimate_id', $value)->update(['is_verified' => 1],['status' => 8])) {
        //                 $this->notification()->success(
        //                     $title = 'Estimate Verified Successfully!!'
        //                 );
        //             }
        //         }
        //     }
        //     $this->updateDataTableTracker = rand(1, 1000);
        //     $this->emit('refreshData',$this->updateDataTableTracker);
        // } catch (\Throwable $th) {
        //     $this->emit('showError', $th->getMessage());
        // }
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1, 1000);
        return view('livewire.components.modal.estimate.estimate-verify-modal');
    }
}
