<?php

namespace App\Http\Livewire\Aoc;

use Livewire\Component;

class Aocs extends Component
{

    public $formOpen = false,$titel,$subTitel,$updateDataTableTracker;
    protected $listeners = ['openForm' => 'formOCControl'];
    public function formOCControl()
    {
        $this->formOpen = !$this->formOpen;
        $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1,1000);
        $this->emit('changeTitel', 'Tender Information' );
        $assets = ['chart', 'animation'];
        return view('livewire.aoc.aocs',compact('assets'));
    }
}
