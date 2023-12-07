<?php

namespace App\Http\Livewire\DocumentSor;

use Dompdf\Dompdf;
use Dompdf\Options;
use Livewire\Component;
use App\Models\SorDocument;

class DocumentSorPdfViewer extends Component
{
    public $show = false, $modalName = '', $title, $pdfContent;
    protected $listeners = ['pdfLink' => 'generatePdf', 'closeModal' => 'doClose'];
    public function render()
    {
        return view('livewire.document-sor.document-sor-pdf-viewer');
    }

    public function generatePdf($id)
    {
        $document = SorDocument::select('docu_file')->where('id', $id)->first();
        $decodeDocument = base64_decode($document->docu_file);
        if (!$decodeDocument) {
            return;
        }
        $this->pdfContent = $decodeDocument;
        //dd($this->pdfContent);
        $this->doShow();
    }

    public function doShow()
    {
        $this->show = !$this->show;
        $this->title = "Document SOR";
        $this->modalName = "document-sor-modal_" . rand(1, 1000);
        $this->modalName = str_replace(' ', '_', $this->modalName);
    }
    public function doClose()
    {
        $this->show = !$this->show;
    }
    public function doSomething()
    {
        $this->doClose();
    }
}
