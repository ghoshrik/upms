<?php

namespace App\Http\Livewire\Office;

use Livewire\Component;

class Office extends Component
{
    public $formOpen = false;
    // protected $listeners = ['openForm' => 'formOCControl'];
    public $titel = 'Offices';
    public $subTitel='List';

    public $addedOfficeUpdateTrack;
    protected $listeners = ['openForm' => 'formOCControl'];
    public function formOCControl()
    {
        $this->addedOfficeUpdateTrack = rand(1, 1000);
        $this->formOpen = !$this->formOpen;
        // $this->titel = ($this->formOpen) ? 'Office':'Office';
        // $this->subTitel =  ($this->formOpen) ? 'Create' : 'List';
        // $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
    }
    public function render()
    {
        $this->emit('changeTitel', 'Office');
        $this->titel =  "Offices";
        $assets = ['chart', 'animation'];
        return view('livewire.office.office',compact('assets'));
    }
}
