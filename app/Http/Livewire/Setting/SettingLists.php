<?php

namespace App\Http\Livewire\Setting;

use Livewire\Component;

class SettingLists extends Component
{

    protected function rules()
    {

    }
    public $formOpen = false;
    protected $listeners = ['openForm' => 'formOCControl'];

    public function formOCControl()
    {
        $this->formOpen = !$this->formOpen;
        $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
    }

    public function render()
    {
        $this->emit('changeTitle', 'Settings');
        $assets = ['chart', 'animation'];
        return view('livewire.setting.setting-lists',compact('assets'));
    }
}
