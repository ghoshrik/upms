<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DeleteButton extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $id, $message, $position;
    public function __construct($id, $message, $position)
    {
        $this->id = $id;
        $this->message = $message;
        $this->position = $position;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.delete-button');
    }
}
