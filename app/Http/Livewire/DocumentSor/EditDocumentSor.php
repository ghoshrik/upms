<?php

namespace App\Http\Livewire\DocumentSor;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\SorDocument;
use App\Models\SorCategoryType;
use Illuminate\Support\Facades\Auth;

class EditDocumentSor extends Component
{
    use Actions;
    public $selectedIdForEdit, $sorDocu = [], $description, $field = [];
    protected $listeners = ["editAction"];

    public function mount()
    {
        $this->field = [
            'dept_category' => SorCategoryType::select('sor_category_types.id', 'sor_category_types.dept_category_name')
                ->join('departments', 'departments.id', '=', 'sor_category_types.department_id')
                ->where('sor_category_types.department_id', '=', Auth::user()->department_id)
                ->where(function ($query) {
                    $query->where('sor_category_types.id', '=', Auth::user()->dept_category_id)
                        ->orWhereNull('sor_category_types.id');
                })
                ->groupBy('sor_category_types.id')
                ->get(),
            'volume_no' => SorDocument::volumeNo($this->selectedIdForEdit),
            'upload_at' => SorDocument::UploadType($this->selectedIdForEdit),
            'file_upload' => '',
            'desc' => SorDocument::Description($this->selectedIdForEdit),
            'isUploading' => false
        ];
        $this->sorDocu['fieldData'] = SorDocument::SelectAllRecords($this->selectedIdForEdit);
        $this->sorDocu['fieldData']['desc'] = base64_decode($this->sorDocu['fieldData']['desc']);
        // dd($this->field['dept_category']);
    }


    public function render()
    {
        //$this->sorDocu['fieldData'] = SorDocument::select('desc', 'id')->where('id', $this->selectedIdForEdit)->first();
        // $this->sorDocu['id'] = $this->sorDocu['fieldData'];


        // dd($this->sorDocu['fieldData']['desc']);
        return view('livewire.document-sor.edit-document-sor');
    }
    public function updateData()
    {
        SorDocument::where('id', $this->selectedIdForEdit)
            ->update(['desc' => base64_encode($this->sorDocu['fieldData']['desc']), 'dept_category_id' => $this->sorDocu['fieldData']['dept_category_id'], 'volume_no' => $this->sorDocu['fieldData']['volume_no'], 'upload_at' => $this->sorDocu['fieldData']['upload_at']]);
        $this->notification()->success(
            $title = "Changes successfully updated"
        );
        $this->reset();
        $this->emit('openEntryForm');
    }
}
