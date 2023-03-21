<?php

namespace App\Http\Livewire\Sorapprove;

use Livewire\Component;

class FileView extends Component
{
    protected $listeners = ['PdfView' => 'pdfRowView'];

    public function pdfRowView($id)
    {
        dd($id);
    }

    public function render()
    {
        return view('livewire.sorapprove.file-view');
    }
}