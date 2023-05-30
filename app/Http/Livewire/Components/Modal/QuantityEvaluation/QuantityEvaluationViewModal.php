<?php

namespace App\Http\Livewire\Components\Modal\QuantityEvaluation;

use App\Models\QultiyEvaluation;
use Livewire\Component;

class QuantityEvaluationViewModal extends Component
{
    protected $listeners = ['openQuantityEvaluationModal' => 'openQuantityEvaluationViewModal'];
    public $viewModal = false, $rate_id, $viewEstimates = [];

    public function openQuantityEvaluationViewModal($rate_id)
    {
        $rate_id = is_array($rate_id)? $rate_id[0]:$rate_id;
        $this->reset();
        $this->viewModal = !$this->viewModal;
        if($rate_id)
        {
            $this->rate_id = $rate_id;
            $this->viewEstimates = QultiyEvaluation::where('rate_id',$this->rate_id)->orderBy('row_id')->get();
        }
        // dd($this->viewEstimates);
    }
    public function render()
    {
        return view('livewire.components.modal.quantity-evaluation.quantity-evaluation-view-modal');
    }
}
