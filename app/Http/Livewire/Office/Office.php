<?php

namespace App\Http\Livewire\Office;

use Livewire\Component;
use Barryvdh\DomPDF\PDF;

class Office extends Component
{
    public $formOpen = false;
    protected $listeners = ['openEntryForm' => 'fromEntryControl','showError'=>'setErrorAlert'];
    public $openedFormType= false,$isFromOpen,$subTitel = "List",$selectedIdForEdit,$errorMessage,$titel;

    public $addedOfficeUpdateTrack;

    public function mount()
    {
        $this->addedOfficeUpdateTrack = rand(1,1000);
    }

    public function fromEntryControl($data='')
    {
        $this->openedFormType = is_array($data) ? $data['formType']:$data;
        $this->isFromOpen = !$this->isFromOpen;
        switch ($this->openedFormType) {
            case 'create':
                $this->subTitel = 'Create';
                break;
            case 'edit':
                $this->subTitel = 'Edit';
                break;
            default:
                $this->subTitel = 'List';
                break;
        }
        if(isset($data['id'])){
            $this->selectedIdForEdit = $data['id'];
        }
    }
    public function setErrorAlert($errorMessage)
    {
       $this->errorMessage = $errorMessage;
    }
    public function pdfView()
    {
        $office = Office::findOrFail(3);
            dd($office);
        $pdf = PDF::loadView('pdfView',['office'=>$office])->setPaper('a4', 'portrait');
    // $fileName = $report->issue_number;
    return $pdf->stream('abcd.pdf');
    }
    public function render()
    {
        $this->titel =  "Offices";
        $assets = ['chart', 'animation'];
        return view('livewire.office.office',compact('assets'));
    }
}
