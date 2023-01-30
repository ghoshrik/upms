<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SubHeader extends Component
{
    public $createButtonOn = false;
    public $titel = 'UPMS',$subTitel;
    protected $listeners = ['openForm' => 'CCButtonControl','changeTitel'=>'setTitel','changeSubTitel'=>'setSubTitel','showError'=>'setErrorAlert','CloseButton'=>'CCButtonControl'];
    public $errorMessage;

    public function CCButtonControl()
    {
        $this->createButtonOn = !$this->createButtonOn;
    }
    public function setTitel($titel)
    {
        $this->titel = $titel;
    }
    public function setSubTitel($subTitel)
    {
        $this->subTitel = $subTitel;
    }
    public function setErrorAlert($errorMessage)
    {
       $this->errorMessage = $errorMessage;
    }
    public function render()
    {
        return view('livewire.sub-header');
    }
}
