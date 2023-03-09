<?php

namespace App\Http\Livewire\Components\Modal\Estimate;

use App\Models\Esrecommender;
use Livewire\Component;

class VerifiedEstimateViewModal extends Component
{
    protected $listeners = ['openVerifiedEstimateViewModal' => 'openVerifyViewModal'];
    public $viewVerifyModal = false, $estimate_id, $viewEstimates = [];
    public function openVerifyViewModal($estimate_id)
    {
        $estimate_id = is_array($estimate_id)? $estimate_id[0]:$estimate_id;
        $this->reset();
        $this->viewVerifyModal = !$this->viewVerifyModal;
        if($estimate_id)
        {
            $this->estimate_id = $estimate_id;
            $this->viewEstimates = Esrecommender::where('estimate_id',$this->estimate_id)->get();
        }
    }
    public function render()
    {
        return view('livewire.components.modal.estimate.verified-estimate-view-modal');
    }
}
