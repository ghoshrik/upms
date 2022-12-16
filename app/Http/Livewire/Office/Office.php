<?php

namespace App\Http\Livewire\Office;

use Livewire\Component;

class Office extends Component
{
    public $formOpen = false;
    //table reload instant data created
    public $addedOfficeUpdateTrack;
    protected $listeners = ['openForm' => 'formOCControl'];
    public function formOCControl()
    {
        $this->addedOfficeUpdateTrack = rand(1, 1000);
        $this->formOpen = !$this->formOpen;
        $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
    }
    public function render()
    {
        $this->emit('changeTitel', 'Office');
        $assets = ['chart', 'animation'];
        return view('livewire.office.office',compact('assets'));
    }
}
