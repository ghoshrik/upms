<?php

namespace App\Http\Livewire\Sorapprove;

use App\Models\SOR;
use Livewire\Component;
use Barryvdh\DomPDF\PDF;
use WireUi\Traits\Actions;
use Livewire\WithFileUploads;
// use PhpOffice\PhpWord\Writer\PDF;
use Illuminate\Support\Facades\Auth;

class SorApprovers extends Component
{

    use Actions, WithFileUploads;
    public $updateDataTableTracker;
    protected $listeners = ['openEntryForm' => 'fromEntryControl'];
    public $openedFormType = false, $isFromOpen, $subTitel = "List", $titel;
    public $SorLists = [], $selectedSors = [], $supported_data;

    public function mount()
    {
        $this->SorLists = SOR::where('department_id', '=', Auth::user()->department_id)->where('IsActive', '=', '0')->get();
        // $this->blukDisable = count($this->selectedSors)< 1;

    }
    public function approvedSOR()
    {
        $listsSors = implode(',', $this->selectedSors);

        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'icon' => 'success',
            'accept' => [
                'label' => 'Yes, Approved',
                'method' => 'approvedListSor',
                'params' => $listsSors,
            ],
            'reject' => [
                'label' => 'No, cancel',
                // 'method' => 'cancel',
            ],
        ]);
    }
    public function approvedListSor($value)
    {
        SOR::whereIn('id', explode(",", $value))->update(['IsActive' => 1]);
        $this->SorLists = [];
        $this->selectedSors = [];
        $this->notification()->success(
            $title = "Record Approved"
        );
    }
    public function SelectedRecordApprove($value)
    {
        // dd($value);
        // $this->supported_data->storeAs('/', $name);
        SOR::where('id', $value)->update(['IsActive' => 1]);
        $this->SorLists = [];
        $this->notification()->success(
            $title = "Record Approved"
        );
    }
    // public function pdfViewRow($value)
    // {
    //     // $this->emit('PdfView', $value);

    //     $sor = SOR::select('attach_docs.*')->join('attach_docs', 'attach_docs.sor_docu_id', '=', 's_o_r_s.id')->where('s_o_r_s.id', $value)->first();
    //     $allData = [
    //         // 'dataMime' => $sor->document_mime,
    //         // 'dataType' => $sor->document_type,
    //         // 'docSize' => $sor->document_size,
    //         'file' => 'data:' . $sor->document_mime . ';base64' . $sor->attach_doc
    //     ];
    //     dd(base64_encode($sor->attach_doc));
    //     // return view('SorApprovePDF', ['allData' => $allData]);

    //     $pdf = PDF::loadView('SorApprovePDF', ['allData' => $allData]);
    //     $pdf->setOptions('isPhpEnabled', true);
    //     $pdf->setPaper('L', 'landscape');
    //     return $pdf->stream('test_pdf.pdf');

    //     // $pdf = PDF::loadView('SorApprovePDF', $allData)->setPaper('a4', 'portrait');

    //     // return $pdf->download('abcd.pdf');
    // }
    public function render()
    {
        $this->SorLists = SOR::where('department_id', '=', Auth::user()->department_id)->where('IsActive', '=', '0')->get();
        // $this->updateDataTableTracker = rand(1,1000);
        $this->titel = trans('cruds.sor-approver.title_singular');
        $assets = ['chart', 'animation'];
        return view('livewire.sorapprove.sor-approvers', compact('assets'));
    }
}