<?php
namespace App\Http\Livewire\Components\Modal\ImportFile;

use App\Jobs\ImportJob;
use App\Models\TestSor;
use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;

class FileUpload extends Component
{

    use Actions;
    protected $listeners = ['OpenImportFile'];
    public $viewModal = false;
    public $show;

    use WithFileUploads;

    public $batchId;
    public $importFile;
    public $importing = false;
    public $importFilePath;
    public $importFinished = false;

    public function mount() {
        $this->show = false;
    }
    public function doShow() {
        $this->show = true;
    }

    public function doClose() {
        $this->show = false;
    }
    public function OpenImportFile()
    {
        // dd("success");
        $this->viewModal = !$this->viewModal;
        //logic
        // $this->doClose();
    }

   
    public function import()
    {
        // dd($this->importFile);
        // dd(file_put_contents($this->file_upload));
        $this->validate([
            'importFile' => 'required',
        ]);
        $this->importing = true;
        /* `->importFilePath` is storing the path of the uploaded file. It is used later in the
        code to read the contents of the file and perform operations on it. */
        $this->importFilePath = $this->importFile->getRealPath();
        
        // dd($this->importFilePath);
        // $batch = Bus::batch([
        //    new ImportJob(1,100)
        // ])->dispatch();
        // $this->batchId = $batch->id;
        $data = array_map('str_getcsv', file($this->importFile->getRealPath()));
        // $data = $this->importFile->getRealPath();
        $header = $data[0];
        unset($data[0]);
        // dd($data[0]);


        /* 
        * chunks file 
         */
        /*$chunks = array_chunk($data,1000);
        // dd(count($chunks));
        foreach($chunks as $key =>$chunk)
        {
           $name = "/tmp{$key}.csv";
           $path = resource_path('temp');
           file_put_contents($path.$name,$chunk);

        }
        */
        foreach($data as $value)
        {   
            $dataList = array_combine($header,$value);
            TestSor::create($dataList);
        }
        $this->notification()->success(
            $title = 'File Upload Successfully'
        );
        $this->reset('importFile');
        return ;
    }

    /*
    public function getImportBatchProperty()
    {
        if (!$this->batchId) {
            return null;
        }

        return Bus::findBatch($this->batchId);
    }
    */
    public function updateImportProgress()
    {
        // $this->importFinished = $this->importBatch->finished();

        // if ($this->importFinished) {
        //     Storage::delete($this->importFilePath);
        //     $this->importing = false;
        // }
        return ;
    }
    public function render()
    {
        return view('livewire.components.modal.import-file.file-upload');
    }
}
