<?php

namespace App\Http\Livewire\EstimateRecomender;

use Livewire\Component;
use App\Models\SorMaster;
use WireUi\Traits\Actions;
use App\Models\Esrecommender;
use App\Models\EstimatePrepare;
use Illuminate\Support\Facades\Auth;
use App\Models\EstimateUserAssignRecord;
use ChrisKonnertz\StringCalc\StringCalc;

class ModifyEstimate extends Component
{
    use Actions;
    public $estimate_id;
    public $currentEstimate = [];
    protected $listeners = ['modifyEstimateRow' => 'modifyEstimate', 'updatedValue' => 'updateEstimateData'];
    public function modifyEstimate($estimateId = 0)
    {
        $this->estimate_id = $estimateId;
        $checkForModify = SorMaster::where([['estimate_id', $this->estimate_id]])->first();
            if ($checkForModify['status'] == 7) {
                $this->currentEstimate = Esrecommender::where('estimate_id', $this->estimate_id)->get()->toArray();
            }
            if ($checkForModify['status'] == 2) {
                $this->currentEstimate = EstimatePrepare::where('estimate_id', $this->estimate_id)->get()->toArray();
            }
        // $this->currentEstimate = EstimatePrepare::where('estimate_id', $this->estimate_id)->get();
    }
    public function updateEstimateData($updateValue, $id)
    {
        $this->currentEstimate[$id - 1] = $updateValue;
        $this->updatedEstimateRecalculate();
    }
    public function updatedEstimateRecalculate()
    {
        $result = 0;
        $stringCalc = new StringCalc();
        foreach ($this->currentEstimate as $key => $value) {
            if ($value['row_index'] != '') {
                try {
                    if ($value['row_index']) {
                        foreach (str_split($value['row_index']) as $key => $info) {
                            if (ctype_alpha($info)) {
                                $alphabet = strtoupper($info);
                                $alp_id = ord($alphabet) - 64;
                                if ($this->currentEstimate[$alp_id - 1]['total_amount'] != '') {
                                    $value['row_index'] = str_replace($info, $this->currentEstimate[$alp_id - 1]['total_amount'], $value['row_index'], $key);
                                }
                            } elseif (htmlspecialchars($info) == "%") {
                                $value['row_index'] = str_replace($info, "/100*", $value['row_index'], $key);
                            }
                        }
                    }
                    $result = $stringCalc->calculate($value['row_index']);
                    $this->currentEstimate[$value['row_id'] - 1]['total_amount'] = $result;
                    Session()->forget('editEstimateData');
                    Session()->put('editEstimateData', $this->currentEstimate);
                } catch (\Exception$exception) {
                    $this->dispatchBrowserEvent('alert', [
                        'type' => 'error',
                        'message' => $exception->getMessage(),
                    ]);
                }
            }
        }
    }
    public function editEstimate($value)
    {
        $this->emit('openEditModal', $value, $this->currentEstimate);
    }
    public function viewModal($estimate_id)
    {
        $this->emit('openModal', $estimate_id);
    }
    public function close()
    {
        // return redirect('/estimate-recommender');
        $this->emit('openForm');
        // $this->emit('refreshData');
    }
    public function store($value)
    {
        try {
            $verifyEstimate = count(SorMaster::select('estimate_id','status')->where([['estimate_id',$value],['status',4]])->get());
            if ($verifyEstimate == 0) {
                Esrecommender::where('estimate_id',$value)->delete();
                foreach ($this->currentEstimate as $key => $estimate) {
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
                        'verified_by' => Auth::user()->id,
                        'commends' => $estimate['comments'],
                    ];
                    // dd($insert);
                    Esrecommender::create($insert);
                }
                if (SorMaster::where('estimate_id', $value)->update(['status' => 4])) {
                    $data = [
                        'estimate_id' => $value,
                        'user_id' => Auth::user()->id,
                    ];
                    $data['status'] = 4;
                    $assignDetails = EstimateUserAssignRecord::create($data);
                    if ($assignDetails) {
                        $returnId = $assignDetails->id;
                        EstimateUserAssignRecord::where([['estimate_id', $value], ['id', '!=', $returnId], ['is_done', 0]])->groupBy('estimate_id')->update(['is_done' => 1]);
                        $this->notification()->success(
                            $title = 'Estimate Modified Successfully!!'
                        );
                    }
                }
                $this->reset();
            } elseif ($verifyEstimate != 0) {
                $this->notification()->error(
                    $title = 'This Estimate Already Modified!!'
                );
                $this->reset();
            } else {
                $this->notification()->error(
                    $title = 'Please Re-check for Modify!!'
                );
                $this->reset();
            }
            $this->emit('openForm');
        } catch (\Throwable$th) {
            $this->emit('showError', $th->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.estimate-recomender.modify-estimate');
    }
}
