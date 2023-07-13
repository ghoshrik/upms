<?php

namespace App\Http\Livewire\SorBook;

use App\Models\DynamicSorHeader;
use Livewire\Component;

class DynamicSor extends Component
{
    public $formOpen = false,$updateDataTableTracker;
    protected $listeners = ['openEntryForm' => 'fromEntryControl','showError'=>'setErrorAlert'];
    public $openedFormType= false,$isFromOpen,$subTitel = "List",$selectedIdForEdit,$errorMessage,$titel;

    public function fromEntryControl($data='')
    {
        $this->openedFormType = is_array($data) ? $data['formType']:$data;
        $this->isFromOpen = !$this->isFromOpen;
        switch ($this->openedFormType) {
            case 'create':
                $this->subTitel = 'Create';
                break;
            case 'view':
                $this->subTitel = 'View';
                break;
            default:
                $this->subTitel = 'List';
                break;
        }
        if(isset($data['id'])){
            $this->selectedIdForEdit= $data['id'];
        }
        $this->updateDataTableTracker = rand(1,1000);
    }
    public function setErrorAlert($errorMessage)
    {
       $this->errorMessage = $errorMessage;
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1,1000);
        $this->titel ="Dynamic SOR";
        return view('livewire.sor-book.dynamic-sor');
    }
}
