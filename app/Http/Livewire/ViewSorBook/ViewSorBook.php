<?php

namespace App\Http\Livewire\ViewSorBook;

use Livewire\Component;
use WireUi\Traits\Actions;

class ViewSorBook extends Component
{

    public $formOpen = false,$updateDataTableTracker;
    protected $listeners = ['openEntryForm' => 'fromEntryControl','showError'=>'setErrorAlert'];
    public $openedFormType= false,$isFromOpen=false,$subTitel = "List",$selectedIdForEdit,$errorMessage,$titel;

    use Actions;
    public function fromEntryControl($data='')
    {
        $this->openedFormType = is_array($data) ? $data['formType']:$data;
        //$this->isFromOpen = !$this->isFromOpen;
        switch ($this->openedFormType) {
            case 'create':
                $this->subTitel = 'Create';
                break;
            case 'view':
                $this->subTitel = 'View';
		$this->isFromOpen = true;
                break;
            default:
                $this->subTitel = 'List';
		$this->isFromOpen = false;
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
        $this->titel ="View Dynamic SOR";
        $assets = ['chart', 'animation'];
        return view('livewire.view-sor-book.view-sor-book',compact('assets'));
    }
}
