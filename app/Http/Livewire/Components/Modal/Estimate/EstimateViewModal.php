<?php

namespace App\Http\Livewire\Components\Modal\Estimate;

use App\Models\EstimatePrepare;
use Livewire\Component;

class EstimateViewModal extends Component
{
    protected $listeners = ['openModal' => 'openViewModal'];
    public $viewModal = false, $estimate_id, $viewEstimates = [];

    public function openViewModal($estimate_id)
    {
        $this->reset();
        $this->viewModal = !$this->viewModal;
        if($estimate_id)
        {
            $this->estimate_id = $estimate_id;
            $this->viewEstimates = EstimatePrepare::where('estimate_id',$this->estimate_id)->get();
        }
    }


    public function render()
    {
        return view('livewire.components.modal.estimate.estimate-view-modal');
    }
}
