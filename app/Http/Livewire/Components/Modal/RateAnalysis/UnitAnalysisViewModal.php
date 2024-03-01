<?php

namespace App\Http\Livewire\Components\Modal\RateAnalysis;

use Livewire\Component;
use App\Models\UnitMaster;

class UnitAnalysisViewModal extends Component
{
    public $sendArrayDesc;
    public $unit_id;
    public $unitMaster = [];
    public $rateAnalysisArray = [];
    public $dropdownData = [], $array_id, $updateKey,$arrayCount;
    public function mount()
    {

        if (Session()->has('modalData')) {
            $this->rateAnalysisArray = Session()->get('modalData');
            //dd($this->rateAnalysisArray);
        }
        $this->unitMaster = UnitMaster::all();
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



    public function render()
    {

        return view('livewire.components.modal.rate-analysis.unit-analysis-view-modal');
    }
}
