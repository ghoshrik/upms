<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
class TestFileUpload extends Component
{
 use WithFileUploads;
    public $pdf;
    public function render()
    {
        return view('livewire.test-file-upload');
    }
}
