<?php

namespace App\Http\Livewire\DocumentSor;

use App\Models\SorCategoryType;
use App\Models\SorDocument;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DocumentSorTable extends Component
{
    use WithPagination;

    protected $sorDocuments = [];
    protected $paginationTheme = 'bootstrap';
    public $show = false, $modalName = '', $title, $pdfContent;
    protected $listeners = ['closeModal' => 'doClose', 'edit'], $isLoading = false;

    public function render()
    {
        if (Auth::user()->dept_category_id != null) {
            $this->sorDocuments = SorDocument::where('department_id', '=', Auth::user()->department_id)
                ->where('dept_category_id', Auth::user()->dept_category_id)
                ->paginate(8);
        } else {
            $this->sorDocuments = SorDocument::where('department_id', '=', Auth::user()->department_id)
                ->paginate(8);
        }
        return view('livewire.document-sor.document-sor-table', [
            'sorDocuments' => $this->sorDocuments
        ]);
    }
    public function edit($id)
    {
        $this->emit('openEntryForm', ['formType' => 'edit', 'id' => $id]);
    }
    public function generatePdf($id)
    {
        // dd($id);
        $docFile = SorDocument::select('upload_at', 'docu_file')->where('id', $id)->first();
        // dd($docFile);
        $decoded = base64_decode($docFile->docu_file);
        // dd($decoded);
        if ($docFile->upload_at == 1) {
            $fileName = "Useful Tables.pdf";
        } elseif ($docFile->upload_at == 2) {
            $fileName = "Diagram.pdf";
        } else {
            $fileName = "Formula.pdf";
        }
        file_put_contents($fileName, $decoded);
        header('Content-Description: SOR Document ');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        return response()->download($fileName)->deleteFileAfterSend(true);
    }
    public function pdfLink($id)
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
