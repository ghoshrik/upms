<?php

namespace App\Http\Livewire\ProjectDocumentType;

use Livewire\Component;
use App\Models\DocumentType;
use WireUi\Traits\Actions;
class CreateDocumentType extends Component
{
    use Actions;
    public $name,$editDocumentTypeId;
    protected $listeners = ['editDocumentType'];
    protected $rules = [
        'name' => 'required|string|max:255',
    ];
    public function editDocumentType($id){
        $this->editDocumentTypeId = $id;
      //  dd($id);
        $this->name = DocumentType::where('id',$id)->pluck('name')->first();
    }
    public function store()
{
         $this->validate();
         if ($this->editDocumentTypeId) {
            $DocumentType = DocumentType::find($this->editDocumentTypeId);
            $DocumentType->update(['name' => $this->name]);
            $this->notification()->success(
                $title = "updated successfully"
            );
         } else {
        DocumentType::create([
            'name' => $this->name,
            'created_by' => auth()->user()->id,
        ]);
        $this->notification()->success(
            $title = "created successfully"
        );
        }
        $this->reset();
        $this->emit('openEntryForm');
}

public function resetForm()
{
    $this->name = '';
    $this->editDocumentTypeId = null;
}
    public function render()
    {
        return view('livewire.project-document-type.create-document-type');
    }
}
