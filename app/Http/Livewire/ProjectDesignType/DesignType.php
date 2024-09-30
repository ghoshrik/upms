<?php

namespace App\Http\Livewire\ProjectDesignType;

use Livewire\Component;
use App\Models\DesignType as DesignTypeModel;
use WireUi\Traits\Actions;
class DesignType extends Component
{
    use Actions;
    public $designTypes,$editId,$name;
    public $formOpen = false;
    protected $listeners = ['openEntryForm' => 'fromEntryControl','showError'=>'setErrorAlert'];
    public $openedFormType= false,$isFromOpen,$subTitel = "List",$selectedIdForEdit,$errorMessage,$titel;

    public function deleteDesignType($id)
    {
        $designType = DesignTypeModel::find($id);
        $designType->delete();
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
            $this->emit('editDesignType', $data['id']);
        }
    }
    public function setErrorAlert($errorMessage)
    {
       $this->errorMessage = $errorMessage;
    }

    public function render()
    {
        $this->designTypes=DesignTypeModel::all();
        $this->titel = 'Design Types';
        return view('livewire.project-design-type.design-type');
    }
}
