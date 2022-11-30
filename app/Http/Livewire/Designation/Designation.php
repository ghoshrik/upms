<?php

namespace App\Http\Livewire\Designation;

use Livewire\Component;

class Designation extends Component
{
    public function render()
    {
        $assets = ['chart', 'animation'];
        return view('livewire.designation.designation',compact('assets'));
    }
}
