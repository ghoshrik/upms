<?php

namespace App\Http\Livewire\Components\Modal\RateAnalysis;

use App\Models\RatesAnalysis;
use Livewire\Component;

class RateAnalysisViewModal extends Component
{
    protected $listeners = ['openRateAnalysisModal' => 'openRateAnalysisViewModal'];
    public $viewModal = false, $rate_id,$rateDescription, $viewEstimates = [];

    public function openRateAnalysisViewModal($rate_id)
    {
        $rate_id = is_array($rate_id)? $rate_id[0]:$rate_id;
        $this->reset();
        $this->viewModal = !$this->viewModal;
        if($rate_id)
        {
            $this->rate_id = $rate_id;
            $this->viewEstimates = RatesAnalysis::where('rate_id',$this->rate_id)->get();
            $this->rateDescription = $this->viewEstimates[count($this->viewEstimates)-1]['description'];
        }
        // dd($this->viewEstimates);
    }
    public function render()
    {
        return view('livewire.components.modal.rate-analysis.rate-analysis-view-modal');
    }
}
