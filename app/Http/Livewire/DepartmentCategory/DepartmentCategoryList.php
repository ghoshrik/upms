<?php

namespace App\Http\Livewire\DepartmentCategory;

use Livewire\Component;

class DepartmentCategoryList extends Component
{
    public $formOpen=false;
    protected $listeners = ['openForm' => 'formOCControl'];
    public function formOCControl()
    {
        $this->formOpen = !$this->formOpen;
        $this->emit('changeSubTitle', ($this->formOpen)?'Create new':'List');
    }
    public function render()
    {
        $assets = ['chart', 'animation'];
        $this->emit('changeTitle', 'Designation');
        return view('livewire.department-category.department-category-list',compact('assets'));
    }
}
