<?php

namespace App\Http\Livewire\Documents;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\StandredDocuments;
use Illuminate\Support\Facades\Auth;
use WireUi\Traits\Actions;

class CreateStandredDocuments extends Component
{

    public $field = [];
    public $progress = 0;


    use WithFileUploads, Actions;
    protected $rules = [
        'field.title' => 'required',
        'field.file_upload' => 'required|file|mimes:pdf|max:20480'
    ];
    protected $messages = [
        'field.title' => 'This is required file',
        'field.file_upload.required' => 'This is required file',
        // 'field.file_upload.file' => 'This is required file',
        // 'field.file_upload.mimes' => 'The file must be a PDF.',
        'field.file_upload.max' => 'The file size must not exceed 20 MB.'

    ];
    public function mount()
    {
        $this->field['title'] = '';
        $this->field['file_upload'] = '';
    }
    public function store()
    {
        // $this->validate();
        // dd($this->field);
        $temporaryFilePath = $this->field['file_upload']->getRealPath();
        $filePath = file_get_contents($temporaryFilePath);
        StandredDocuments::create([
            'title' => $this->field['title'],
            'department_id' => Auth::user()->department_id,
            'upload_file' => base64_encode($filePath),
            'upload_file_size' => $this->field['file_upload']->getSize(),
            'created_by' => Auth::user()->id
        ]);
        // Delete the temporary file
        if ($temporaryFilePath || file_exists($temporaryFilePath)) {
            unlink($temporaryFilePath);
        }

        $this->notification()->success(
            $title = "file upload success"
        );
        $this->reset();
        $this->emit('openEntryForm');
    }
    public function render()
    {
        return view('livewire.documents.create-standred-documents');
    }
}
