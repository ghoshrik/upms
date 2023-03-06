<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SubHeader extends Component
{
    public $showCloseButton = false;
    public $titel = 'UPMS',$subTitel;
    protected $listeners = [
        'openForm' => 'CCButtonControl',
        'showError'=>'setErrorAlert',
        'CloseButton'=>'CCButtonControl',
        'changeTitleSubTitle'=>'setTitleSubTitle'];
    public $errorMessage;

    // public function CCButtonControl()
    // {
    //     $this->createButtonOn = !$this->createButtonOn;
    // }
    public function openCloseEntryForm()
    {
        $this->emit('openEntryForm');
        $this->showCloseButton = !$this->showCloseButton;
    }
    // public function setTitel($titel)
    // {
    //     $this->titel = $titel;
    // }
    public function setTitleSubTitle($titleSubTitle)
    {
        $titleSubTitle = explode('|',$titleSubTitle);
        $this->titel = $titleSubTitle[0];
        $this->subTitel = $titleSubTitle[1];
    }
    // public function setSubTitel($subTitel)
    // {
    //     $this->subTitel = $subTitel;
    // }
    public function setErrorAlert($errorMessage)
    {
       $this->errorMessage = $errorMessage;
    }
    public function render()
    {
        return view('livewire.sub-header');
    }
}
