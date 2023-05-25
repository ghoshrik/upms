<?php

namespace App\Http\Livewire\Sorapprove;

use App\Models\SOR;
use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SorApprovers extends Component
{

    use Actions, WithFileUploads;
    public $updateDataTableTracker;
    protected $listeners = ['showError' => 'setErrorAlert'];
    public $openedFormType = false, $isFromOpen, $subTitel = "List", $titel, $errorMessage;
    public $SorLists = [], $selectedSors = [];

    public function mount()
    {
        $this->SorLists = SOR::where('department_id', '=', Auth::user()->department_id)->get();
    }
    public function approvedselectSOR($value)
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'icon' => 'success',
            'accept' => [
                'label' => 'Yes, Approved',
                'method' => 'SelectedRecordApprove',
                'params' => $value,
            ],
            'reject' => [
                'label' => 'No, cancel',
                // 'method' => 'cancel',
            ],
        ]);
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
        SOR::whereIn('id', explode(",", $value))->update(['is_approved' => 1]);
        $this->SorLists = [];
        $this->selectedSors = [];
        $this->notification()->success(
            $title = "Record Approved"
        );
    }
    public function SelectedRecordApprove($value)
    {
        SOR::where('id', $value)->update(['is_approved' => 1]);
        $this->SorLists = [];
        $this->notification()->success(
            $title = "Record Approved"
        );
    }
    public function setErrorAlert($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    public function generatePdf($value)
    {
        $sor = SOR::join('attach_docs', 'attach_docs.sor_docu_id', '=', 's_o_r_s.id')->where('s_o_r_s.id', $value)->first();
        $decoded = base64_decode($sor->docfile);
        $file = $sor->Item_details . '.pdf';
        file_put_contents($file, $decoded);
        header('Content-Description: SOR ');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        //     header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        return response()->download($file)->deleteFileAfterSend(true);
        $this->reset('sor');
    }
    public function render()
    {
        $this->SorLists = SOR::where('department_id', '=', Auth::user()->department_id)->get();
        // $this->updateDataTableTracker = rand(1,1000);
        $this->titel = trans('cruds.sor-approver.title_singular');
        $assets = ['chart', 'animation'];
        return view('livewire.sorapprove.sor-approvers', compact('assets'));
    }
}