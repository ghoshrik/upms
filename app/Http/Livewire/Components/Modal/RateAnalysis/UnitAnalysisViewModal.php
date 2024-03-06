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
    public $unitMaster = [];
    public $rateAnalysisArray = [];
    public $dropdownData = [], $array_id, $updateKey, $arrayCount,$editEstimate_id;
    public function mount()
    {

        if (empty($this->editEstimate_id)) {
            $this->rateAnalysisArray = Session()->get('modalData');
         //dd("modal",$this->rateAnalysisArray);
        }else{
            $this->rateAnalysisArray = Session()->get('editModalData');
         //dd("editmodal",$this->rateAnalysisArray);
        }
        $this->unitMaster = UnitMaster::all();
        if (isset($this->rateAnalysisArray) && is_array($this->rateAnalysisArray)) {
        if (count($this->rateAnalysisArray) > 0) {
            foreach ($this->rateAnalysisArray as $key => $data) {
                // Check if the current key matches unit_id
                if ($key === $this->unit_id) {
                    // If it matches, skip to the next iteration
                    continue;
                }
                // Add the key to $dropdownData
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
