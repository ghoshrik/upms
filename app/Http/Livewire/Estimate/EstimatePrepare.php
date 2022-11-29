<?php

namespace App\Http\Livewire\Estimate;

use App\View\Components\AppLayout;
use Illuminate\Http\Request;

use Livewire\Component;


class EstimatePrepare extends Component
{
    public $open = 'false';
    public function test()
    {
        $this->open='true';
    }
    public function render()
    {
        // return view('livewire.estimate.estimate-prepare')->extends('Components.AppLayout');
        $assets = ['chart', 'animation'];
        return view('livewire.estimate.estimate-prepare',compact('assets'));
    }
}
