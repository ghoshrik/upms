<?php

namespace App\Http\Livewire\Components\Modal\RateAnalysis;

use Livewire\Component;
use App\Models\RatesAnalysis;
use Illuminate\Support\Facades\Cache;

class RateAnalysisViewModal extends Component
{
    protected $listeners = ['openRateAnalysisModal' => 'openRateAnalysisViewModal'];
    public $viewModal = false, $rate_id, $rateDescription,$part_no, $viewEstimates = [];

    public function openRateAnalysisViewModal($rate_id)
    {
        //dd($this->part_no);
        $rate_id = is_array($rate_id) ? $rate_id[0] : $rate_id;
        $this->reset();
        $this->viewModal = !$this->viewModal;
        if ($rate_id) {
            $this->rate_id = $rate_id;
            $cacheKey = 'rate_details_' . $rate_id;
            $getCacheData = Cache::get($cacheKey);
            if ($getCacheData != '') {
                $this->viewEstimates = $getCacheData;
            } else {
                $this->viewEstimates = Cache::remember($cacheKey, now()->addMinutes(720), function () use ($rate_id) {
                    return RatesAnalysis::where('rate_id', $this->rate_id)->orderBy('id')->get();
                });
            }
            $this->rateDescription = $this->viewEstimates[count($this->viewEstimates) - 1]['description'];
        }
        // dd($this->viewEstimates);
    }
    public function render()
    {
        return view('livewire.components.modal.rate-analysis.rate-analysis-view-modal');
    }
}
