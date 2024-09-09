<?php

namespace App\Http\Livewire\NonScheduleApprove;

use Livewire\Component;

class NonScheduleApprovers extends Component
{


    public $updateDataTableTracker;
    protected $listeners = ['openEntryForm' => 'fromEntryControl', 'showError' => 'setErrorAlert'];
    public $openedFormType = false, $isFromOpen, $subTitle = "List", $title, $errorMessage;
    public function setErrorAlert($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    public function fromEntryControl($data = '')
    {
        $this->openedFormType = is_array($data) ? $data['formType'] : $data;

        switch ($this->openedFormType) {
            case 'create':
                $this->subTitle = 'Create';
                break;
            case 'view':
                $this->subTitle = 'View';
                $this->isFromOpen = true;
                break;
            default:
                $this->subTitle = 'List';
                $this->isFromOpen = false;
                break;
        }

        if (isset($data['id'])) {
            $this->selectedIdForEdit = $data['id'];
        }

        $this->updateDataTableTracker = rand(1, 1000);
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1, 1000);
        $assets = ['chart', 'animation'];
        $this->title = "Non Schedule Items";
        return view('livewire.non-schedule-approve.non-schedule-approvers');
    }
}
