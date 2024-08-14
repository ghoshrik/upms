<?php

namespace App\Http\Livewire\Groups;

use App\Models\Group as ModelGroup;
use Livewire\Component;
use WireUi\Traits\Actions;

class Group extends Component
{
    use Actions;
    protected $listeners = ['openEntryForm' => 'fromEntryControl', 'showError' => 'setErrorAlert'];
    public $openedFormType = false, $isFromOpen, $subTitle = "List", $selectedIdForEdit, $errorMessage, $title, $groupLists=[];
    public $updateDataTableTracker;


    public function mount(){

    }

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
        $this->updateDataTableTracker = rand(1, 1000);
        $this->title = 'Department Groups';
        $this->groupLists = ModelGroup::all();
        $assets = ['chart', 'animation'];
        return view('livewire.groups.group',['groupLists' => $this->groupLists]);
    }
}
