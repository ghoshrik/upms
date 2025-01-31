<?php

namespace App\Http\Livewire\ProjectDocumentType;

use Livewire\Component;
use App\Models\DocumentType as DocumentTypeModel;
use WireUi\Traits\Actions;
class DocumentType extends Component
{
    use Actions;
    public $DocumentTypes,$editId,$name;
    public $formOpen = false;
    protected $listeners = ['openEntryForm' => 'fromEntryControl','showError'=>'setErrorAlert'];
    public $openedFormType= false,$isFromOpen,$subTitel = "List",$selectedIdForEdit,$errorMessage,$titel;

    public function deleteDocumentType($id)
    {
        $DocumentType = DocumentTypeModel::find($id);
        $DocumentType->delete();
        $this->notification()->success(
            $title = "Deleted successfully"
        );
        $this->reset();
        $this->emit('openEntryForm');
    }
    public function fromEntryControl($data='')
    {
        $this->openedFormType = is_array($data) ? $data['formType']:$data;
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
        if(isset($data['id'])){
           // $this->selectedIdForEdit = $data['id'];
            $this->emit('editDocumentType', $data['id']);
        }
    }
    public function setErrorAlert($errorMessage)
    {
       $this->errorMessage = $errorMessage;
    }

    public function render()
    {
        $this->DocumentTypes=DocumentTypeModel::all();
        $this->titel = 'Design Types';
        return view('livewire.project-document-type.document-type');
    }
}
