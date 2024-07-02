<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ActionButton extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $type;
    public $disabled;
    public $class;
    public $onClick;
    public function __construct($type = 'button', $disabled = false, $class = '', $onClick = null)
    {
        $this->type = $type;
        $this->disabled = $disabled;
        $this->class = $class;
        $this->onClick = $onClick;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.action-button');
    }
}
