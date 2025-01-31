<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EditButton extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $id,$action;
    public function __construct($id,$action)
    {
        $this->id = $id;
        $this->action = $action;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.edit-button');
    }
}
