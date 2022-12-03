<?php

namespace App\Http\Livewire\Estimate;

use App\Models\SORCategory;
use App\View\Components\AppLayout;
use Illuminate\Http\Request;

use Livewire\Component;


class EstimatePrepare extends Component
{

    public $formOpen=false;
    protected $listeners = ['openForm' => 'formOCControl'];
    public function formOCControl()
    {
        $this->formOpen = !$this->formOpen;
    }
    public function render()
    {
        $assets = ['chart', 'animation'];
        return view('livewire.estimate.estimate-prepare',compact('assets'));
    }
}
