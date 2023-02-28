<?php

namespace App\Http\Livewire\DepartmentCategory;

use Livewire\Component;

class DepartmentCategoryList extends Component
{
    public $formOpen=false,$updatedDataTableTracker;
    protected $listeners = ['openForm' => 'formOCControl'];
    public function formOCControl()
    {
        $this->formOpen = !$this->formOpen;
        $this->emit('changeSubTitle', ($this->formOpen)?'Create new':'List');
        $this->updatedDataTableTracker = rand(1,1000);
    }
    public function render()
    {
        $assets = ['chart', 'animation'];
        $this->emit('changeTitle', 'Designation');
        return view('livewire.department-category.department-category-list',compact('assets'));
    }
}
