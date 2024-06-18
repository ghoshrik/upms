<?php

namespace App\Http\Livewire\DocumentSor;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\DocumentSor;
use App\Models\SorDocument;
use Livewire\WithFileUploads;
use App\Models\DepartmentCategories;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CreateDocumentSor extends Component
{

    public $deptCategories, $field = [],$file_upload;
    use Actions, WithFileUploads;
    protected $rules = [
        'field.dept_category' => 'required',
        'field.volume_no' => 'required',
        'field.upload_at' => 'required',
        // 'field.file_upload' => 'required'
    ];
    protected $messages = [
        'field.dept_category.required' => 'This is required file',
        'field.volume_no.required' => 'This is required file',
        'field.upload_at' => 'This is required file',
        // 'field.file_upload' => 'This is required file'

    ];
    public function store()
    {
        // $this->validate();
	//dd($this->file_upload);
	//dd($_FILES[$this->file_upload]['livewire-tmp']);
	//dd($this->file_upload->getRealPath());
	dd($this->file_upload->store('file_upload'));
        $temporaryFilePath = $this->file_upload->getRealPath();


        $filePath = file_get_contents($temporaryFilePath);
        $fileSize = $this->field['file_upload']->getSize();
        $filExt = $this->field['file_upload']->getClientOriginalExtension();
        $mimeType = $this->field['file_upload']->getMimeType();

        SorDocument::create([
            'dept_category_id' => $this->field['dept_category'],
            'volume_no' => $this->field['volume_no'],
            'upload_at' => $this->field['upload_at'],
            'docu_file' => base64_encode($filePath),
            'document_type' => $filExt,
            'document_mime' => $mimeType,
            'document_size' => $fileSize,
        ]);

        // DB::connection('pgsql_docu_external')->table('sors_docu')->insert([
        //     'dept_category_id' => $this->field['dept_category'],
        //     'volume_no' => $this->field['volume_no'],
        //     'upload_at' => $this->field['upload_at'],
        //     'docu_file' => base64_encode($filePath),
        //     'document_type' => $filExt,
        //     'document_mime' => $mimeType,
        //     'document_size' => $fileSize,
        // ]);


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
    public function mount()
    {
        $this->field = [
            'dept_category' => '',
            'volume_no' => '',
            'upload_at' => ''
        ];
    }
    public function render()
    {

	if(Auth::user()->dept_category_id !=null)
	{
		$this->deptCategories = DepartmentCategories::select('sor_category_types.id','sor_category_types.dept_category_name')
		->join('departments','departments.id','=','sor_category_types.department_id')
		->where('sor_category_types.department_id','=',Auth::user()->department_id)
		->where('sor_category_types.id','=',Auth::user()->dept_category_id)
		->groupBy('sor_category_types.id')
		->get();
	}
	else
	{
		$this->deptCategories = DepartmentCategories::select('sor_category_types.id','sor_category_types.dept_category_name')
		->join('departments','departments.id','=','sor_category_types.department_id')
		->where('sor_category_types.department_id','=',Auth::user()->department_id)
		->groupBy('sor_category_types.id')
		->get();

	}
        return view('livewire.document-sor.create-document-sor');
    }
}