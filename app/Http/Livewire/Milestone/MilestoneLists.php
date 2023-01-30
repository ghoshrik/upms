<?php

namespace App\Http\Livewire\Milestone;

use Livewire\Component;
use App\Models\MileStone;

class MilestoneLists extends Component
{

    public $updateDataTableTracker;
    public function mileStoneRowView($Id)
    {
        $this->emit('mileStoneRow',$Id);
    }
    public function render()
    {
        $this->updateDataTableTracker = rand(1,1000);
        $mileStone = MileStone::select('project_id')->groupBy('project_id')->get();
        return view('livewire.milestone.milestone-lists',compact('mileStone'));
    }
}
