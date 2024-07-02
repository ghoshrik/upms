<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DownloadButton extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $id,$iconName;
    public function __construct($id,$iconName)
    {
        $this->id = $id;
        $this->iconName = $iconName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.download-button');
    }
}
