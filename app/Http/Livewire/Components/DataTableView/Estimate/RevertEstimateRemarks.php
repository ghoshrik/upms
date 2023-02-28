<?php

namespace App\Http\Livewire\Components\DataTableView\Estimate;
use Illuminate\Support\Facades\Cache;

use Livewire\Component;

class RevertEstimateRemarks extends Component
{
    public function render()
    {
        return view('livewire.components.data-table-view.estimate.revert-estimate-remarks');
    }
}
