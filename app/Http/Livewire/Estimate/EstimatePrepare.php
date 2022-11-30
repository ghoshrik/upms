<?php

namespace App\Http\Livewire\Estimate;

use App\Models\SORCategory;
use App\View\Components\AppLayout;
use Illuminate\Http\Request;

use Livewire\Component;


class EstimatePrepare extends Component
{
    public $open = 'false';
    public $item_name,$getCategory = [],$categoriesList = '';
    protected $listeners = [
        'changeCategory'
    ];

    public function test()
    {
        $this->open='true';
    }

    public function changeCategory($value)
    {
        dd($value);
        $this->categoriesList =  $value;
    }
    public function render()
    {

        $this->getCategory = SORCategory::select('item_name','id')->get();
        $assets = ['chart', 'animation'];
        return view('livewire.estimate.estimate-prepare',compact('assets'));
    }
}
