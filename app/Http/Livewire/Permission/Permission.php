<?php

namespace App\Http\Livewire\Permission;

use Livewire\Component;

class Permission extends Component
{
    
    public $isFromOpen = false; 
    protected $listeners = ['openEntryForm' => 'fromEntryControl'];
    public $titel = 'Permission';
    public $subTitel='List';
    public function fromEntryControl()
    {
        $this->isFromOpen = !$this->isFromOpen;
        $this->subTitel =  ($this->isFromOpen) ? 'Create' : 'List';
    }
    public function render()
    {
        return view('livewire.permission.permission');
    }
}
