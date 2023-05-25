<?php

namespace App\Http\Livewire\Qtyanalysis;

use Livewire\Component;

class AnalysisList extends Component
{
    public $updateDataTableTracker, $titel, $subTitel = 'List', $isFromOpen;
    public $formOpen = false, $editFormOpen = false, $selectedTab = 1, $counterData = [], $errorMessage, $openedFormType;
    protected $listeners = ['openForm' => 'fromEntryControl', 'refreshData' => 'render', 'showError' => 'setErrorAlert'];


    public function fromEntryControl($data = '')
    {
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
            $this->emit('editEstimateRow', $data['id']);
        }
        $this->updateDataTableTracker = rand(1, 1000);
    }
    public function setErrorAlert($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1, 1000);
        $this->titel = 'Qty Analysis';
        $assets = ['chart', 'animation'];
        return view('livewire.qtyanalysis.analysis-list', compact('assets'));
    }
}
