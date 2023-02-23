<?php

namespace App\Http\Livewire\Fund;

use Livewire\Component;

class Funds extends Component
{
    public $formOpen = false,$titel,$subTitel,$updateDataTableTracker;
    protected $listeners = ['openForm' => 'formOCControl'];


    public function formOCControl()
    {
        $this->formOpen = !$this->formOpen;
        $this->emit('changeTitle', 'Funds Approved',($this->formOpen) ? 'Funds Approved' : 'List');
        $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
    }

    public function render()
    {
        $this->updateDataTableTracker = rand(1,1000);
        $this->emit('changeTitel', trans('cruds.funds.title'));
        // $this->emit('changeTitel', 'Office');
        $assets = ['chart', 'animation'];
        return view('livewire.fund.funds',compact('assets'));
    }
}
