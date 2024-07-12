<?php

namespace App\Http\Livewire\Components\Modal\RateAnalysis;

use App\Models\UnitMaster;
use Livewire\Component;
use WireUi\Traits\Actions;

class UnitAnalysisViewModal extends Component
{
    use Actions;
    public $sendArrayDesc;
    public $unit_id;
    public $part_no;
    public $featureType;
    public $editRate_id;
    public $unitMaster = [];
    public $rateAnalysisArray = [];
    public $dropdownData = [], $array_id, $updateKey, $arrayCount, $editEstimate_id, $identifier,$sendRowNo;
    public function mount()
    {

        $updateRateAnalysisId = (!empty($this->editRate_id)) ? $this->editRate_id : ((!empty($this->editEstimate_id)) ? $this->editEstimate_id : null);
        //dd( $updateRateAnalysisId);
        if (isset($this->identifier)) {
            if (!empty($updateRateAnalysisId)) {
                $modalName = "editModalDataV2";
            } else {
                $modalName = "modalDataV2";
            }
        } else {
            $modalName = ($this->featureType == "RateAnalysis" && $updateRateAnalysisId === null) ? "RateAnalysisModal" :
                (($this->featureType == "RateAnalysis" && $updateRateAnalysisId !== null) ? "RateAnalysisEditModal" :
                    (($this->featureType === null && $updateRateAnalysisId === null) ? "modalData" :
                        (($this->featureType === null && $updateRateAnalysisId !== null) ? "editModalData" : "modalData")));
        }
//dd($modalName);
   
        $sessionData = Session()->get($modalName);
       // dd($sessionData);
        $this->rateAnalysisArray = $sessionData;

        $this->unitMaster = UnitMaster::all();
        if (isset($this->rateAnalysisArray) && is_array($this->rateAnalysisArray)) {
            if (count($this->rateAnalysisArray) > 0) {
                foreach ($this->rateAnalysisArray as $key => $data) {
                    if ($key === $this->unit_id) {
                        continue;
                    }
                    $this->dropdownData[] = $key;
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.components.modal.rate-analysis.unit-analysis-view-modal');
    }
}
