<?php

namespace App\Http\Livewire\ActionComponents\EstimateRecomender;

use Livewire\Component;

class DataTableButtonGroup extends Component
{
    protected $listeners = ['openButton' => 'dataTableButtons'];
    public function render()
    {
        return view('livewire.action-components.estimate-recomender.data-table-button-group');
    }
}
