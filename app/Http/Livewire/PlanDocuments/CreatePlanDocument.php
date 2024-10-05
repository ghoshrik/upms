<?php

namespace App\Http\Livewire\PlanDocuments;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\DocumentType;
use App\Models\PlanDocument;
use Livewire\WithFileUploads;
use App\Models\MultiDocUpload;

class CreatePlanDocument extends Component
{
    use Actions, WithFileUploads;
    protected $listeners = ['addPlanDocument'];
    public $project, $projectPlan, $editplanDocId,$document_type_id;
    public $title;
    public $inputs = [], $progress = 0;
    public $fetchDropdownData = [], $openPlanDocumentModal = false;
    // protected $rules = [
    //     'inputs.*.title' => 'required|string',
    //     'inputs.*.document_type_id' => 'required|exists:document_types,id',
    //     'inputs.*.plan_document' => 'required|file|mimes:pdf',
    // ];

    // protected $messages = [
    //     'inputs.*.title.required' => 'This field is required',
    //     'inputs.*.document_type_id.required' => 'This field is required',
    //     'inputs.*.plan_document.required' => 'File upload is required',
    //     'inputs.*.plan_document.file' => 'Required!The uploaded file must be a valid file',
    //     'inputs.*.plan_document.mimes' => 'Only PDF files are allowed',
    // ];

    public function addPlanDocument($id = null)
    {
        $this->resetExcept(['project', 'projectPlan']);
        $this->resetValidation();
        $this->openPlanDocumentModal = true;
        $this->fetchDropdownData['document_types'] = DocumentType::all();
        if (!empty($id)) {
            $this->editplanDocId = $id;
            $plandocument = PlanDocument::find($id);
           // dd($plandocument);
            if ($plandocument) {
                $this->inputs[] = [
                    'title' => $plandocument->title,
                    'document_type_id' => $plandocument->document_type_id,
                    'department_id' => $plandocument->department_id,
                    'plan_document' => $plandocument->plan_document,
                ];
            } else {
                $this->notification()->error('Error', 'Plan document not found!');
            }
        } else {
            $this->inputs[] = [
                'title' => '',
                'document_type_id' => '',
                'publish_at' => '',
                'department_id' => '',
                'plan_document' => '',
            ];
        }
    }

    public function addMore()
    {
        $this->inputs[] = [
            'title' => '',
            'document_type_id' => '',
            'publish_at' => '',
            'department_id' => '',
            'plan_document' => '',
        ];
    }
    public function deleteRow($key)
    {
        unset($this->inputs[$key]);
    }
    public function closeCreatePlanDocModel()
    {
        $this->resetExcept(['project', 'projectPlan']);
    }
    // public function store()
    // {
    //     foreach ($this->inputs as $key => $input) {
    //         $input['temp_path'] = $input['plan_document']->getRealPath();
    //         $input['filePath'] = file_get_contents($input['temp_path']);
    //         $input['fileSize'] = $input['plan_document']->getSize();
    //         $input['filExt'] = $input['plan_document']->getClientOriginalExtension();
    //         $input['mimeType'] = $input['plan_document']->getMimeType();
    //         $input['base64_file'] = base64_encode($input['filePath']);
    //         $this->inputs[$key] = $input;
    //         $insert = [
    //             'title' => $input['title'],
    //             'plan_id' => $this->projectPlan->id,
    //             'document_type_id' => $input['document_type_id'],
    //             'project_creation_id' => $this->project->id,
    //             'department_id' => $this->project->department_id,
    //             'plan_document' => $input['base64_file']
    //         ];
    //         PlanDocument::create($insert);
    //         if ($input['temp_path'] || file_exists($input['temp_path'])) {
    //             unlink($input['temp_path']);
    //         }
    //     }
    //     $this->openPlanDocumentModal = false;
    //     $this->resetExcept(['project', 'projectPlan']);
    //     $this->emit('refreshPlanDocument');
    // }

//     public function store()
// {
//     $this->validate([
//         'inputs.*.title' => 'required|string',
//         'inputs.*.document_type_id' => 'required|exists:document_types,id',
//         'inputs.*.plan_document' => 'required|file|mimes:pdf',
//     ], [
//         'inputs.*.title.required' => 'This field is required',
//         'inputs.*.document_type_id.required' => 'This field is required',
//         'inputs.*.plan_document.required' => 'File upload is required',
//         'inputs.*.plan_document.file' => 'Required! The uploaded file must be a valid file',
//         'inputs.*.plan_document.mimes' => 'Only PDF files are allowed',
//     ]);
//     foreach ($this->inputs as $key => $input) {
//         // Check if the 'plan_document' is an instance of UploadedFile (i.e., a new file is uploaded)
//         if (isset($input['plan_document']) && $input['plan_document'] instanceof \Illuminate\Http\UploadedFile) {
//             $input['temp_path'] = $input['plan_document']->getRealPath();
//             $input['filePath'] = file_get_contents($input['temp_path']);
//             $input['fileSize'] = $input['plan_document']->getSize();
//             $input['fileExt'] = $input['plan_document']->getClientOriginalExtension();
//             $input['mimeType'] = $input['plan_document']->getMimeType();
//             $input['base64_file'] = base64_encode($input['filePath']);
//         }

//         // Check if we are updating an existing document
//         if (isset($this->editplanDocId) && !empty($this->editplanDocId)) {
//             // Find the existing PlanDocument by editplanDocId
//             $plandocument = PlanDocument::find($this->editplanDocId);

//             if ($plandocument) {
//                 // Update only the fields provided
//                 $plandocument->update([
//                     'title' => $input['title'],
//                     'document_type_id' => $input['document_type_id'],
//                     'plan_id' => $this->projectPlan->id,
//                     'project_creation_id' => $this->project->id,
//                     'department_id' => $this->project->department_id,
//                     // Only update the file if a new one was uploaded, otherwise retain the old file
//                     'plan_document' => isset($input['base64_file']) ? $input['base64_file'] : $plandocument->plan_document,
//                 ]);
//             }

//             // Remove the temporary file after processing (if new file was uploaded)
//             if (isset($input['temp_path']) && file_exists($input['temp_path'])) {
//                 unlink($input['temp_path']);
//             }

//             $this->notification()->success('Document updated successfully!');
//         } else {

//             $insert = [
//                 'title' => $input['title'],
//                 'plan_id' => $this->projectPlan->id,
//                 'document_type_id' => $input['document_type_id'],
//                 'project_creation_id' => $this->project->id,
//                 'department_id' => $this->project->department_id,
//                 'plan_document' => $input['base64_file'] ?? null, // Only set if a file was uploaded
//             ];

//             PlanDocument::create($insert);

//             // Remove the temporary file after processing (if new file was uploaded)
//             if (isset($input['temp_path']) && file_exists($input['temp_path'])) {
//                 unlink($input['temp_path']);
//             }

//             $this->notification()->success('Document added successfully!');
//         }
//     }

//     // Close the modal and reset the form
//     $this->openPlanDocumentModal = false;
//     $this->resetExcept(['project', 'projectPlan']);
//     $this->emit('refreshPlanDocument');
//     }

public function store()
{

    $rules = [
        'inputs.*.title' => 'required|string',
        'inputs.*.document_type_id' => 'required|exists:document_types,id',
    ];
    if (empty($this->editplanDocId)) {
         $rules['inputs.*.plan_document'] = 'required|file|mimes:pdf';
    }else {
        // In update mode, the file is not required and will only be validated if provided
        $rules['inputs.*.plan_document'] = 'nullable|file|mimes:pdf'; // Only check MIME type if provided
    }

    $messages = [
        'inputs.*.title.required' => 'This field is required!',
        'inputs.*.document_type_id.required' => 'This field is required!',
        'inputs.*.plan_document.required' => 'File upload is required!',
        'inputs.*.plan_document.file' => 'The uploaded file must be a valid file!',
        'inputs.*.plan_document.mimes' => 'Only PDF files are allowed!',
    ];

    $this->validate($rules, $messages);

    // Process each input as before
    foreach ($this->inputs as $key => $input) {
        // Handle file upload as before (no changes needed here)
        if (isset($input['plan_document']) && $input['plan_document'] instanceof \Illuminate\Http\UploadedFile) {
            $input['temp_path'] = $input['plan_document']->getRealPath();
            $input['filePath'] = file_get_contents($input['temp_path']);
            $input['fileSize'] = $input['plan_document']->getSize();
            $input['fileExt'] = $input['plan_document']->getClientOriginalExtension();
            $input['mimeType'] = $input['plan_document']->getMimeType();
            $input['base64_file'] = base64_encode($input['filePath']);
        }

        // Update mode: If editing, update the existing document
        if (isset($this->editplanDocId) && !empty($this->editplanDocId)) {
            $plandocument = PlanDocument::find($this->editplanDocId);

            if ($plandocument) {
                $plandocument->update([
                    'title' => $input['title'],
                    'document_type_id' => $input['document_type_id'],
                    'plan_id' => $this->projectPlan->id,
                    'project_creation_id' => $this->project->id,
                    'publish_at' => $input['publish_at'],
                    'department_id' => $this->project->department_id,
                    'plan_document' => isset($input['base64_file']) ? $input['base64_file'] : $plandocument->plan_document,
                ]);
            }

            if (isset($input['temp_path']) && file_exists($input['temp_path'])) {
                unlink($input['temp_path']);
            }

            $this->notification()->success('Document updated successfully!');
        } else {
            // Create mode: Insert new record
            PlanDocument::create([
                'title' => $input['title'],
                'document_type_id' => $input['document_type_id'],
                'plan_id' => $this->projectPlan->id,
                'project_creation_id' => $this->project->id,
                'publish_at' => $input['publish_at'],
                'department_id' => $this->project->department_id,
                'plan_document' => $input['base64_file'] ?? null,
            ]);

            if (isset($input['temp_path']) && file_exists($input['temp_path'])) {
                unlink($input['temp_path']);
            }

            $this->notification()->success('Document added successfully!');
        }
    }

    // Close modal, reset form, and emit event to refresh the list
    $this->openPlanDocumentModal = false;
    $this->resetExcept(['project', 'projectPlan']);
    $this->emit('refreshPlanDocument');
}

    public function render()
    {
        return view('livewire.plan-documents.create-plan-document');
    }
}
