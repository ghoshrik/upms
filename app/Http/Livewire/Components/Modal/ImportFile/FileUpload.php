<?php
namespace App\Http\Livewire\Components\Modal\ImportFile;

use App\Jobs\ImportJob;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;

class FileUpload extends Component
{

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
        $this->importFilePath = $this->importFile->getRealPath();
        // $this->importFilePath = $this->importFile->store('imports');
        $batch = Bus::batch([
            new ImportJob($this->importFilePath),
        ])->dispatch();
        $this->batchId = $batch->id;
        // $data = array_map('str_getcsv', file($this->importFile->getRealPath()));
        // dd($data);
    }
    public function getImportBatchProperty()
    {
        if (!$this->batchId) {
            return null;
        }

        return Bus::findBatch($this->batchId);
    }

    public function updateImportProgress()
    {
        $this->importFinished = $this->importBatch->finished();

        if ($this->importFinished) {
            Storage::delete($this->importFilePath);
            $this->importing = false;
        }
    }
    public function render()
    {
        return view('livewire.components.modal.import-file.file-upload');
    }
}
