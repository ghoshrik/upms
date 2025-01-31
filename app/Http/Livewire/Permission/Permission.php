<?php

namespace App\Http\Livewire\Permission;

use Livewire\Component;
use WireUi\Traits\Actions;
class Permission extends Component
{
    
    use Actions;
    public $formOpen = false, $editFormOpen = false, $updateDataTableTracker;
    protected $listeners = ['openEntryForm' => 'fromEntryControl', 'showError' => 'setErrorAlert'];
    public $openedFormType = false, $isFromOpen, $subTitel = "List", $selectedIdForEdit, $errorMessage, $titel, $editId = null;


    public function fromEntryControl($data = '')
    {
        // dd($data);
        $this->openedFormType = is_array($data) ? $data['formType'] : $data;
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
        /*if (isset($data['id'])) {
            // $this->selectedIdForEdit = $data['id'];

            $this->editId = $data['id'];
            if ($this->editId) {
                $this->editFormOpen = !$this->editFormOpen;
                if ($this->editId != null) {
                    $this->emit('editSorRow', $this->editId);
                }
            }
        }*/
        $this->updateDataTableTracker = rand(1, 1000);
    }


    

    public function setErrorAlert($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }
    public function render()
    {
	$this->updateDataTableTracker = rand(1, 1000);
        $this->titel = "Permissions";
        $assets = ['chart', 'animation'];
        return view('livewire.permission.permission',compact('assets'));
    }
}
