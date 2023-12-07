<?php

namespace App\Http\Livewire\DocumentSor;

use App\Models\SorDocument;
use Livewire\Component;
use WireUi\Traits\Actions;

class DocumentSors extends Component
{
    use Actions;
    public $formOpen = false, $updateDataTableTracker;
    protected $listeners = ['openEntryForm' => 'fromEntryControl', 'showError' => 'setErrorAlert'];
    public $openedFormType = false, $isFromOpen, $subTitel = "List", $selectedIdForEdit, $errorMessage, $titel;
    public $tabs = [];
    public function render()
    {
        $this->updateDataTableTracker = rand(1, 1000);
        $this->titel = "SOR Documents";
        return view('livewire.document-sor.document-sors');
    }

    public function fromEntryControl($data = '')
    {
        $this->openedFormType = is_array($data) ? $data['formType'] : $data;
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
        if (isset($data['id'])) {
            $this->selectedIdForEdit = $data['id'];
        }
        $this->updateDataTableTracker = rand(1, 1000);
    }
    public function mount()
    {
        $tabName = SorDocument::select('upload_at')->OrderBy('id', 'desc')->get();
        //dd($tabName);
        // if ($tabName['upload_at'] == (int)1) {
        //     $tablistName = "Useful Tables";
        // } else if ($tabName['upload_at'] == 2) {
        //     $tablistName = "Support Structure(Diagram)";
        // } else {
        //     $tablistName = "Formula";
        // }
        // $tabs[] = [
        //     'id'
        // ];
    }
    public function setErrorAlert($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }
}