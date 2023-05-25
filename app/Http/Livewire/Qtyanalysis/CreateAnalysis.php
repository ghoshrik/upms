<?php

namespace App\Http\Livewire\Qtyanalysis;

use Livewire\Component;
use App\Models\SORCategory;

class CreateAnalysis extends Component
{

    public $getCategory, $type;
    public function render()
    {
        $this->getCategory = SORCategory::select('item_name', 'id')->get();
        return view('livewire.qtyanalysis.create-analysis');
    }
}
