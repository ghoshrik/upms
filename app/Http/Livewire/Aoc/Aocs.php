<?php

namespace App\Http\Livewire\Aoc;

use Livewire\Component;

class Aocs extends Component
{
    public $formOpen = false,$updateDataTableTracker;
    protected $listeners = ['openForm' => 'formOCControl'];
    public $titel;
    public $subTitel='List';
    public function formOCControl()
    {
        $this->formOpen = !$this->formOpen;
        $this->subTitel =  ($this->formOpen) ? 'Create' : 'List';
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1,1000);
        $this->titel = 'Awards of Contracts';
        $this->subTitel =($this->formOpen) ? 'Create' : 'List';
        $assets = ['chart', 'animation'];
        return view('livewire.aoc.aocs',compact('assets'));
    }
}
