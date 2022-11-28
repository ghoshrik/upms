<?php

namespace App\Http\Livewire\Estimate;

use Livewire\Component;

class EstimatePrepare extends Component
{

    public function render()
    {
        // return view('livewire.estimate.estimate-prepare')->extends('Components.AppLayout');
        $assets = ['chart', 'animation'];
        return view('livewire.estimate.estimate-prepare',compact('assets'))->extends('partials.dashboard._body');
    }
}
