<?php

namespace App\Http\Livewire\Components\Modal\Estimate;

use App\Models\Esrecommender;
use App\Models\EstimatePrepare;
use App\Models\EstimateUserAssignRecord;
use App\Models\SorMaster;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class EstimateApproveModal extends Component
{
    use Actions;
    protected $listeners = ['openApproveModal' => 'openApproveModal'];
    public $openApproveModal = false, $estimate_id, $viewEstimates, $updateDataTableTracker;

    public function openApproveModal($estimate_id)
    {
        $this->reset();
        $estimate_id = is_array($estimate_id) ? $estimate_id[0] : $estimate_id;
        $this->openApproveModal = !$this->openApproveModal;
        if ($estimate_id) {
            $this->estimate_id = $estimate_id;
            $this->viewEstimates = EstimatePrepare::join('estimate_masters', 'estimate_prepares.estimate_id', '=', 'estimate_masters.estimate_id')
                ->select('estimate_masters.sorMasterDesc','estimate_prepares.total_amount','estimate_prepares.estimate_id')
                ->where('estimate_masters.estimate_id', $this->estimate_id)
                ->where('estimate_masters.dept_id', Auth::user()->department_id)
                ->where('estimate_prepares.operation', 'Total')
                ->first();
            $estimateDTls = $this->viewEstimates;
            // dd($this->viewEstimates);
            $checkForModify = SorMaster::where([['estimate_id', $this->estimate_id]])->first();
            // if ($checkForModify['status'] == 4) {
            //     $this->viewEstimates = Esrecommender::where('estimate_id', $this->estimate_id)->get();
            // }
            // if ($checkForModify['status'] == 2) {
            //     $this->viewEstimates = EstimatePrepare::where('estimate_id', $this->estimate_id)->get();
            // }
        }
    }
    public function approveEstimate($value)
    {
        try {
            // $checkForApprove = Esrecommender::where('estimate_id', $value)->first();

            $estimate = SorMaster::where('estimate_id', $value)->where('is_verified',0)->first();
            // dd($estimate);
            if($estimate->estimate_id === $value)
            {
                SorMaster::where('estimate_id',$value)->update(['is_verified'=>1,'status'=>7]);
                $data = [
                    'estimate_id' => $value,
                    'user_id' => Auth::user()->id, // approver id
                ];
                $data['status'] = 7;
                $assignDetails = EstimateUserAssignRecord::create($data);
                if ($assignDetails) {
                    $returnId = $assignDetails->id;
                    // dd($returnId);
                    EstimateUserAssignRecord::where([['estimate_id', $value], ['id', '!=', $returnId], ['is_done', 0]])->groupBy('estimate_id')->update(['is_done' => 1]);
                    $this->notification()->success(
                        $title = 'Approved Estimate Successfully !!'
                    );
                }
                // $this->notification()->success(
                //     $title = 'Estimate Approved Successfully!!'
                // );
            }
            else
            {
                $this->notification()->success(
                    $title = 'Estimate Have No Exists'
                );
            }



            /*$checkForApprove = SorMaster::where([['estimate_id', $value], ['status', 4]])->first();
            if ($checkForApprove != null) {
                if (SorMaster::where('estimate_id', $value)->update(['status' => 6])) {
                    $data = [
                        'estimate_id' => $value,
                        'user_id' => Auth::user()->id,
                    ];
                    $data['status'] = 6;
                    $assignDetails = EstimateUserAssignRecord::create($data);
                    if ($assignDetails) {
                        $returnId = $assignDetails->id;
                        EstimateUserAssignRecord::where([['estimate_id', $value], ['id', '!=', $returnId], ['is_done', 0]])->groupBy('estimate_id')->update(['is_done' => 1]);
                        $this->notification()->success(
                            $title = 'Approved Estimate Successfully !!'
                        );
                    }
                }
            } else {
                $approveEstimate = EstimatePrepare::where('estimate_id', $value)->get();
                if ($approveEstimate != null) {
                    Esrecommender::where('estimate_id', $value)->delete();
                    foreach ($approveEstimate as $key => $estimate) {
                        $insert = [
                            'estimate_id' => $value,
                            'dept_id' => $estimate['dept_id'],
                            'category_id' => $estimate['category_id'],
                            'row_id' => $estimate['row_id'],
                            'row_index' => $estimate['row_index'],
                            'sor_item_number' => $estimate['sor_item_number'],
                            'estimate_no' => $estimate['estimate_no'],
                            'item_name' => $estimate['item_name'],
                            'other_name' => $estimate['other_name'],
                            'qty' => $estimate['qty'],
                            'rate' => $estimate['rate'],
                            'total_amount' => $estimate['total_amount'],
                            'operation' => $estimate['operation'],
                            'percentage_rate' => $estimate['perRate'],
                            'verified_by' => Auth::user()->id,
                            'commends' => $estimate['AddRemarks'],
                            'rate_id' => $estimate['rate_id']
                        ];
                        Esrecommender::create($insert);
                    }
                    if (SorMaster::where('estimate_id', $value)->update(['status' => 6])) {
                        $data = [
                            'estimate_id' => $value,
                            'user_id' => Auth::user()->id,
                        ];
                        $data['status'] = 6;
                        $assignDetails = EstimateUserAssignRecord::create($data);
                        if ($assignDetails) {
                            $returnId = $assignDetails->id;
                            EstimateUserAssignRecord::where([['estimate_id', $value], ['id', '!=', $returnId], ['is_done', 0]])->groupBy('estimate_id')->update(['is_done' => 1]);
                            $this->notification()->success(
                                $title = 'Estimate Approved Successfully!!'
                            );
                        }
                    }
                }
            }*/


            $this->reset();
            $this->updateDataTableTracker = rand(1, 1000);
            $this->emit('refreshData', $this->updateDataTableTracker);
        } catch (\Throwable$th) {
            $this->emit('showError', $th->getMessage());
        }
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1, 1000);
        return view('livewire.components.modal.estimate.estimate-approve-modal');
    }
}
