<?php

namespace App\Http\Livewire\DepartmentCategory;

use Livewire\Component;

class DepartmentCategoryList extends Component
{
    public $formOpen=false,$updatedDataTableTracker;
    protected $listeners = ['openForm' => 'formOCControl'];
    public $openedFormType= false,$isFromOpen,$subTitel = "List",$selectedIdForEdit,$errorMessage,$titel = "Department Category";

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
        $assets = ['chart', 'animation'];
        $this->emit('changeTitle', 'Designation');
        return view('livewire.department-category.department-category-list',compact('assets'));
    }
}
