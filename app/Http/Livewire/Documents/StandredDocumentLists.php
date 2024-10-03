<?php

namespace App\Http\Livewire\Documents;

use Livewire\Component;
use App\Models\StandredDocuments;

class StandredDocumentLists extends Component
{

    protected $listeners = ['openEntryForm' => 'fromEntryControl', 'showError' => 'setErrorAlert'];

    public $openedFormType = false, $isFromOpen, $subTitle = "List", $selectedIdForEdit, $errorMessage, $title, $groupLists = [];
    public $updateDataTableTracker;
    public $documents;

    public function fromEntryControl($data = '')
    {
        $this->openedFormType = is_array($data) ? $data['formType'] : $data;
        $this->isFromOpen = !$this->isFromOpen;

        switch ($this->openedFormType) {
            case 'create':
                $this->subTitle = 'Create';
                $this->selectedIdForEdit = null;
                break;
            case 'edit':
                $this->subTitle = 'Edit';
                if (isset($data['id'])) {
                    $this->selectedIdForEdit = $data['id'];
                }
                break;
            default:
                $this->subTitle = 'List';
                break;
        }
    }
    public function setErrorAlert($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }
    public function mount()
    {
        $this->documents = StandredDocuments::orderBy('id', 'asc')->get();
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1, 1000);
        $this->title = 'Standared Documents';
        $assets = ['chart', 'animation'];
        return view('livewire.documents.standred-document-lists');
    }
}
