<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SubHeader extends Component
{
    public $createButtonOn = false;
    protected $listeners = ['openForm' => 'CCButtonControl'];

    public function CCButtonControl()
    {
        $this->createButtonOn = !$this->createButtonOn;
    }
    public function render()
    {
        return view('livewire.sub-header');
    }
}
