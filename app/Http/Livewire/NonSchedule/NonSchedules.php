<?php

namespace App\Http\Livewire\NonSchedule;

use Livewire\Component;

class NonSchedules extends Component
{
    public $formOpen = false;
    protected $listeners = ['openEntryForm' => 'fromEntryControl', 'refreshData' => 'mount','showError' => 'setErrorAlert'];
    public $openedFormType = false, $isFromOpen, $subTitle = "List", $selectedIdForEdit, $errorMessage, $title;

    public function fromEntryControl($data = '')
    {
        $this->openedFormType = is_array($data) ? $data['formType'] : $data;
        $this->isFromOpen = !$this->isFromOpen;
        switch ($this->openedFormType) {
            case 'create':
                $this->subTitle = 'Create';
                break;
            case 'edit':
                $this->subTitle = 'Edit';
                break;
            default:
                $this->subTitle = 'List';
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
        $this->title = "Non Schedules";
        $assets = ['chart', 'animation'];
        return view('livewire.non-schedule.non-schedules');
    }
}
