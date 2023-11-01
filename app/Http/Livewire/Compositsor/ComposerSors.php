<?php

namespace App\Http\Livewire\Compositsor;

use App\Models\SOR;
use Livewire\Component;
use App\Models\CompositSor;
use Illuminate\Support\Facades\Auth;

class ComposerSors extends Component
{
    public $formOpen = false, $editFormOpen = false, $updateDataTableTracker;
    protected $listeners = ['openEntryForm' => 'fromEntryControl', 'showError' => 'setErrorAlert', 'sorFileDownload' => 'generatePdf','refresh' => 'render'];
    public $openedFormType = false, $isFromOpen, $subTitel = "List", $selectedIdForEdit, $errorMessage, $titel, $editId = null, $CountSorListPending;
    public $composerSor = [];

    public function mount()
    {
        $this->updateDataTableTracker = rand(1, 1000);
        $this->CountSorListPending = SOR::where([['department_id', Auth::user()->department_id], ['created_by', Auth::user()->id]])->where('is_approved', 0)->count();
        $this->composerSor = CompositSor::select('sor_itemno_parent_id','dept_category_id','sor_itemno_parent_index','sor_itemno_child_id')->groupBy('sor_itemno_parent_id','dept_category_id','sor_itemno_parent_index','sor_itemno_child_id')->get();
    }
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
    public function setErrorAlert($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    public function viewComposite($parent_id,$child_id,$sor_itemno_parent_index)
    {
        $sor_itemno_parent_index = implode('.', str_split($sor_itemno_parent_index));
        // dd($sor_itemno_parent_index);
        $this->viewCompositSOR = CompositSor::where([['sor_itemno_parent_id',$parent_id],['sor_itemno_child_id',$child_id],['sor_itemno_parent_index',$sor_itemno_parent_index]])->get();
        $this->emit('viewModal',$this->viewCompositSOR);
    }
    public function render()
    {
        $this->titel = 'Composit SOR';
        $assets = ['chart', 'animation'];
        $this->updateDataTableTracker = rand(1, 1000);
        $this->composerSor = CompositSor::where('created_by',Auth::user()->id)->select('sor_itemno_parent_id','dept_category_id','sor_itemno_parent_index','sor_itemno_child_id','parent_itemNo')->groupBy('sor_itemno_parent_id','dept_category_id','sor_itemno_parent_index','sor_itemno_child_id','parent_itemNo')->get();
        return view('livewire.compositsor.composer-sors', compact('assets'));
    }
}
