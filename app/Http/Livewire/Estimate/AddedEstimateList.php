<?php

namespace App\Http\Livewire\Estimate;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class AddedEstimateList extends Component
{
    public $addedEstimatesData = [],$autoCalc = false;
    public function autoCalc()
    {
        $this->autoCal = true;
    }
    public function render()
    {
        return view('livewire.estimate.added-estimate-list');
    }
}
