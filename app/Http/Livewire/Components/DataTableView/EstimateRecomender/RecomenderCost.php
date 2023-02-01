<?php

namespace App\Http\Livewire\Components\DataTableView\EstimateRecomender;

use App\Models\Esrecommender;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RecomenderCost extends Component
{
    public function render()
    {
        return view('livewire.components.data-table-view.estimate-recomender.recomender-cost');
    }
}
