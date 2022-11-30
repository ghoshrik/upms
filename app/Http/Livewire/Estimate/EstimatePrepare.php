<?php

namespace App\Http\Livewire\Estimate;

use App\Models\SORCategory;
use App\View\Components\AppLayout;
use Illuminate\Http\Request;

use Livewire\Component;


class EstimatePrepare extends Component
{

    // protected $listeners = [
    //     'changeCategory'
    // ];

    public function render()
    {
        $assets = ['chart', 'animation'];
        return view('livewire.estimate.estimate-prepare',compact('assets'));
    }
}
