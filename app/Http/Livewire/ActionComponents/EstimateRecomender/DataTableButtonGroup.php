<?php

namespace App\Http\Livewire\ActionComponents\EstimateRecomender;

use Livewire\Component;

class DataTableButtonGroup extends Component
{
    // todo::remove this listner if not use
    protected $listeners = ['openButton' => 'dataTableButtons'];
    public function render()
    {
        return view('livewire.action-components.estimate-recomender.data-table-button-group');
    }
}
