<?php

namespace App\Http\Livewire\Components\Modal\ItemModal;

use Livewire\Component;

class ConfirmModal extends Component
{

    public $editRowId,$existingQty;
    public function mount()
    {

    }

    public function confirmAction($value){
        $this->emit('actionconfirm',$value);
    }

    public function render()
    {
        return view('livewire.components.modal.item-modal.confirm-modal');
    }
}
