<?php

namespace App\Http\Livewire\Sor;

use Livewire\Component;
use App\Models\SOR as ModelsSOR;
use Illuminate\Support\Facades\Auth;

class Sor extends Component
{
    public $formOpen = false, $editFormOpen = false, $updateDataTableTracker;
    protected $listeners = ['openEntryForm' => 'fromEntryControl', 'showError' => 'setErrorAlert','sorFileDownload' => 'generatePdf'];
    public $openedFormType = false, $isFromOpen, $subTitel = "List", $selectedIdForEdit, $errorMessage, $titel, $editId = null, $CountSorListPending;

    public function mount()
    {
        $this->updateDataTableTracker = rand(1, 1000);
        $this->CountSorListPending = ModelsSOR::where('department_id', Auth::user()->department_id)->count();
    }

    // public function formOCControl($isEditFrom = false, $editId = null)
    // {
    //     if ($isEditFrom) {
    //         $this->editFormOpen = !$this->editFormOpen;
    //         $this->emit('changeSubTitel', ($this->editFormOpen) ? 'Edit' : 'List');
    //         if ($editId != null) {
    //             $this->emit('editSorRow',$editId);
    //         }
    //         return;
    //     }
    //     $this->editFormOpen = false;
    //     $this->formOpen = !$this->formOpen;
    //     $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
    // }

    public function fromEntryControl($data = '')
    {
        // dd($data);
        $this->openedFormType = is_array($data) ? $data['formType'] : $data;
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
        if (isset($data['id'])) {
            // $this->selectedIdForEdit = $data['id'];

            $this->editId = $data['id'];
            if ($this->editId) {
                $this->editFormOpen = !$this->editFormOpen;
                if ($this->editId != null) {
                    $this->emit('editSorRow', $this->editId);
                }
            }
        }
        $this->updateDataTableTracker = rand(1, 1000);
    }
    public function generatePdf($value)
    {
        $sor = ModelsSOR::join('attach_docs', 'attach_docs.sor_docu_id', '=', 's_o_r_s.id')->where('s_o_r_s.id', $value)->first();
        $decoded = base64_decode($sor->docfile);
        $file = $sor->Item_details . '.pdf';
        file_put_contents($file, $decoded);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        //     header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        return response()->download($file)->deleteFileAfterSend(true);
        $this->reset('sor');
    }
    public function setErrorAlert($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1, 1000);
        $this->titel = trans('cruds.sor.title');
        $assets = ['chart', 'animation'];
        return view('livewire.sor.sor', compact('assets'));
    }
}
