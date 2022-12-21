<?php

namespace App\Http\Livewire\Milestone;

use Livewire\Component;

class CreateMilestone extends Component
{
    public $projectId,$description;
    public $mileStoneData=[],$Index=0,$subMileData=[];
    // public function mount()
    // {
    //     $this->mileStoneData = [
    //         [
    //         'id'=>'',
    //         'M1'=>'',
    //         'M2'=>'',
    //         'M3'=>'',
    //         'M4'=>'',
    //         'p1'=>0,
    //         ]
    //     ];
    // }
    // public $inputsData = [],$InputSubData = [];
    // public function store()
    // {
    //     // dd($this->unit_type);
    // }
    // public function mount()
    // {
    //     $this->inputsData = [
    //         [
    //             'milestone_1'=>'',
    //             'milestone_2'=>'',
    //             'milestone_3'=>'',
    //             'milestone_4'=>'',
    //         ]
    //         ];
    // }
    // public function addMileStep()
    // {
    //     // dd($this->project_name,$this->description);
    //     $this->inputsData[]=[
    //         'milestone_1'=>'',
    //         'milestone_2'=>'',
    //         'milestone_3'=>'',
    //         'milestone_4'=>'',
    //     ];
    // }
    // public function removeMileStep($Index)
    // {
    //     if (count($this->inputsData) > 1) {
    //         unset($this->inputsData[$Index]);
    //         $this->inputsData =  array_values($this->inputsData);
    //         return;
    //     }
    // }

    // // public $Index = 1;


    // public function addSubMileStep($Index)
    // {
    //     $this->InputSubData[] = [
    //         'milestone_5'.$Index=>'',
    //         'milestone_6'.$Index=>'',
    //         'milestone_7'.$Index=>'',
    //         'milestone_8'.$Index=>'',
    //     ];
    //     // $Index = $Index+1;
    //     // $this->Index = $Index;
    //     // array_push($this->InputSubData,$Index);

    // }
    // public function removeSubMileStep($Index)
    // {
    //     unset($this->InputSubData[$Index]);
    //     return $this->InputSubData = array_values($this->InputSubData);
    // }
    public function addSubMilestone($Index)
    {
        $this->mileStoneData[$Index] = [
            'M1'=>'',
            'M2'=>'',
            'M3'=>'',
            'M4'=>'',
            'p'=>$Index
        ];

        // $this->mileStoneData[$this->Index][$parent] = [
        //     'M1'=>'',
        //     'M2'=>'',
        //     'M3'=>'',
        //     'M4'=>'',
        //     'p'=>$parent
        // ];
        // dd($this->mileStoneData,$this->Index);
    }
    public function addMilestone($id)
    {
        $this->Index = $id+1;
        $this->mileStoneData[$this->Index] = [
            'M1'=>'',
            'M2'=>'',
            'M3'=>'',
            'M4'=>'',
            'p'=>0
        ];
    }
    public function render()
    {
        // info($this->inputsData);

        $this->emit('changeTitel', 'Milestone');
        $assets = ['chart', 'animation'];
        return view('livewire.milestone.create-milestone',compact('assets'));
    }
}
