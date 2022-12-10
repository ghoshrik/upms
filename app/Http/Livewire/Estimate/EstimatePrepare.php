<?php

namespace App\Http\Livewire\Estimate;

use App\Models\SORCategory;
use App\Models\SorMaster;
use App\View\Components\AppLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class EstimatePrepare extends Component
{

    public $formOpen=false;
    protected $listeners = ['openForm' => 'formOCControl'];
    public function mount()
    {
        $a = SorMaster::with('estimate')->get();
        // dd($a);
        if(Auth::guest()){
            return route('login');
        }
    }
    public function formOCControl()
    {
        $this->formOpen = !$this->formOpen;
        $this->emit('changeSubTitel', ($this->formOpen)?'Create new':'List');
    }
    public function render()
    {
        $this->emit('changeTitel', 'Estimate Prepare');
        $assets = ['chart', 'animation'];
        return view('livewire.estimate.estimate-prepare',compact('assets'));
    }
}
