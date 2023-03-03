<?php

namespace App\Http\Livewire\Tender;

use Livewire\Component;

class Tenders extends Component
{
    public $formOpen = false,$updateDataTableTracker;
    protected $listeners = ['openForm' => 'formOCControl'];
    public $openedFormType= false,$isFromOpen,$subTitel = "List",$selectedIdForEdit,$errorMessage,$titel;

    public function fromEntryControl($data='')
    {
        // dd($data);
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
    public function render()
    {
        $this->updateDataTableTracker = rand(1,1000);
        $this->titel = trans('cruds.tenders.title');
        $assets = ['chart', 'animation'];
        return view('livewire.tender.tenders',compact('assets'));
    }
}
