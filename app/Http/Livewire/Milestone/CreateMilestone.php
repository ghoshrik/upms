<?php

namespace App\Http\Livewire\Milestone;

use Livewire\Component;

class CreateMilestone extends Component
{
    public $project_name,$description;
    public function store()
    {
        // dd($this->unit_type);
    }
    public function addMileStep()
    {
        dd($this->project_name,$this->description);
    }
    public function render()
    {
        $this->emit('changeTitel', 'Milestone');
        $assets = ['chart', 'animation'];
        return view('livewire.milestone.create-milestone',compact('assets'));
    }
}
