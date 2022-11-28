<?php

namespace App\Http\Livewire\Designation;

use Livewire\Component;

class Designation extends Component
{
    public function render()
    {
        // return view('livewire.designation.designation')->extends('partials.dashboard._body')->section('body');
        return view('livewire.designation.designation')->extends('layouts.dashboard.dashboard')->section('body');
        // ->extends('layout.side-menu')->section('subcontent');
    }
}
