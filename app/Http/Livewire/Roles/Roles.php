<?php

namespace App\Http\Livewire\Roles;

use Livewire\Component;

class Roles extends Component
{
    public $isFromOpen = false; 
    public $openedFormType = ''; 
    public $selectedIdForEdit = 0;
    protected $listeners = ['openEntryForm' => 'fromEntryControl'];
    public $titel = 'Role';
    public $subTitel='List';
    public function fromEntryControl($data='')
    {
        // dd($data);
        $this->openedFormType = is_array($data) ? $data['formType']:$data;
        $this->isFromOpen = !$this->isFromOpen;
        switch ($this->openedFormType) {
            case 'create':
                $this->subTitel = 'Create';
                break;
            case 'edit':
                $this->subTitel = 'Edit';
                break;
            default:
                $this->subTitel = 'List';
                break;
        }
        if(isset($data['id'])){
            $this->selectedIdForEdit = $data['id'];
        }
    }
    public function render()
    {
        return view('livewire.roles.roles');
    }
}
