<?php

namespace App\Http\Livewire\Setting;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SettingLists extends Component
{

    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('auth.signin');
        }
    }

    public $formOpen = false,$errorMessage,$titel,$subTitel = "List";
    protected $listeners = ['openForm' => 'formOCControl','showError'=>'setErrorAlert'];

    public function formOCControl()
    {
        $this->formOpen = !$this->formOpen;
        $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
    }
    public function setErrorAlert($errorMessage)
    {
       $this->errorMessage = $errorMessage;
    }
    public function render()
    {
        // $this->emit('changeTitle', 'Settings');
        $this->titel = "Settings";
        $assets = ['chart', 'animation'];
        return view('livewire.setting.setting-lists',compact('assets'));
    }
}
