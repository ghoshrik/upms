<?php

namespace App\Http\Livewire\UserManagement;

use Livewire\Component;

class UserManagement extends Component
{
    public $formOpen = false, $updateDataTableTracker;

    protected $listeners = ['openEntryForm' => 'fromEntryControl', 'showError' => 'setErrorAlert'];
    public $openedFormType = false, $isFromOpen, $subTitel = "List", $selectedIdForEdit, $errorMessage, $titel;

    public function fromEntryControl($data = '')
    {
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
        if (isset($data['id'])) {
            $this->selectedIdForEdit = $data['id'];
        }
    }
    public function setErrorAlert($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }
    public function render()
    {
        $this->titel = trans('cruds.user-management.title');
        $assets = ['chart', 'animation'];
        return view('livewire.user-management.user-management', compact('assets'));
    }
}
