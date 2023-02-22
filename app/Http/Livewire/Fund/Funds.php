<?php

namespace App\Http\Livewire\Fund;

use Livewire\Component;

class Funds extends Component
{
    public $formOpen = false,$titel,$subTitel;
    protected $listeners = ['openForm' => 'formOCControl'];


    public function formOCControl()
    {
        $this->formOpen = !$this->formOpen;
        $this->emit('changeTitle', 'Funds Approved',($this->formOpen) ? 'Funds Approved' : 'List');
        $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
    }

    public function render()
    {
        $this->emit('changeTitel', 'Funds Approved');
        // $this->emit('changeTitel', 'Office');
        $assets = ['chart', 'animation'];
        return view('livewire.fund.funds',compact('assets'));
    }
}
