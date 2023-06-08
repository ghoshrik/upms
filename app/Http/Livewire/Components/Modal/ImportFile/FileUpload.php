<?php

namespace App\Http\Livewire\Components\Modal\ImportFile;

use Livewire\Component;
use Livewire\WithFileUploads;

class FileUpload extends Component
{

    protected $listeners = ['OpenImportFile'];
    public $viewModal = false,$file_upload;
    public $show;

    use WithFileUploads;
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
    public function blukUploadFile()
    {
        // dd(file_put_contents($this->file_upload));
    }
    public function render()
    {
        return view('livewire.components.modal.import-file.file-upload');
    }
}
