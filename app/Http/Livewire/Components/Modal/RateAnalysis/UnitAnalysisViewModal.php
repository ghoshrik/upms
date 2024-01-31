<?php

namespace App\Http\Livewire\Components\Modal\RateAnalysis;

use Livewire\Component;
use App\Models\UnitMaster;

class UnitAnalysisViewModal extends Component
{
    public $sendArrayDesc;
    public $unit_id;
    public $unitMaster = [];
    public function mount(){
        //dd($sendArrayDesc);
        $this->unitMaster = UnitMaster::all();
    }
    public function render(){
        return view('livewire.components.modal.rate-analysis.unit-analysis-view-modal');
    }
}
