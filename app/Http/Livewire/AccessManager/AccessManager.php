<?php

namespace App\Http\Livewire\AccessManager;

use App\Models\AccessMaster;
use Livewire\Component;

class AccessManager extends Component
{
    public $formOpen = false, $editFormOpen = false, $updateDataTableTracker;
    protected $listeners = ['openEntryForm' => 'fromEntryControl'];
    public $openedFormType = false, $isFromOpen, $subTitel = "List", $selectedIdForEdit, $errorMessage, $titel, $AccessManagerTable = [];


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
            $this->selectedIdForEdit = $data['id'];
        }
    }

    // public function formOCControl($isEditFrom = false, $eidtId = null)
    // {
    //     if ($isEditFrom) {
    //         $this->editFormOpen = !$this->editFormOpen;
    //         $this->emit('changeSubTitel', ($this->editFormOpen) ? 'Edit' : 'List');
    //         if ($eidtId != null) {
    //             $this->emit('editEstimateRow',$eidtId);
    //         }
    //         return;
    //     }
    //     $this->editFormOpen = false;
    //     $this->formOpen = !$this->formOpen;
    //     $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
    //     $this->updateDataTableTracker = rand(1,1000);
    // }
    public function render()
    {

        $this->AccessManagerTable = AccessMaster::OrderBy('id', 'desc')->get();
        $this->updateDataTableTracker = rand(1, 1000);
        $this->titel = trans('cruds.access-manager.title');
        $assets = ['chart', 'animation'];
        return view('livewire.access-manager.access-manager', compact('assets'));
    }
}