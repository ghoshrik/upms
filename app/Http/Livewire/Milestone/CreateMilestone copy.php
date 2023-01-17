<?php

namespace App\Http\Livewire\Milestone;

use App\Models\MileStone;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CreateMilestone extends Component
{
    public $mileStoneData = [], $Index = 0,$treeView,$arrayData=[];
    public $mStone_name,$mVal,$mUnit,$mCost,$projectId,$description;
    public function addMilestone($id)
    {
        if($id == 0)
        {
            $this->Index = count($this->mileStoneData)+1;
            $this->mileStoneData[] = [
                'index' => $this->Index,
                'parent_id' => $id,
            ];
        }
        elseif($this->mileStoneData != null)
        {
            $index = count($this->mileStoneData)+1;
            $this->mileStoneData[] = [
                'index' => $index,
                'parent_id' => $id
            ];
        }
        // dd($this->mileStoneData);
        $this->treeView= $this->buildTree($this->mileStoneData);
        // dd($this->treeView);
    }


    //note
    /*
    1)vendor registration
                => vendor company name,TIN,PAN,username,mobile,address,vendor type

    2) AcFs project
                =>project id,GEO id, upload
    3)DPR upload with pdf


    */
    public function buildTree($nodes)
    {
        $children = array();

        foreach ($nodes as $node) {
            $children[$node['index']] = $node;
            $children[$node['index']]['children'] = array();
        }
        foreach ($children as $child) {
            if (isset($children[$child['parent_id']])) {
                $children[$child['parent_id']]['children'][] = &$children[$child['index']];
            }
        }
        $rootNodes = array();
        foreach ($children as $child) {
            if ($child['parent_id']==0) {
                $rootNodes[] = $child;
            }
        }
        return $rootNodes;
    }


    public function removeMilestone($parent_id)
    {
        // dd($this->mileStoneData);


        // if($this->mileStoneData[$Index]['parent_id'] == $Index){
        //     // dd($this->mileStoneData[$Index]['index']);
        //     $id = $this->mileStoneData[$Index]['index'];
        //     // dd($this->mileStoneData[$id-1]);
        //     unset($this->mileStoneData[$id-1]);
        //     // dd($this->mileStoneData);
        // }
        $newArray = [];
        foreach ($this->mileStoneData as $key => $value) {
            if (is_array($value)) {
                unset($value['parent_id']);
            } else {
                $newArray[$key] = $value;
            }
        }
    }

    public function store()
    {
    //    dd($this->arrayData);
    dd($this->mileStoneData,$this->arrayData);
    // dd(array_merge($this->arrayData,$this->mileStoneData));
    // 'projectId'=>$this->projectId,
    // 'description'=>$this->description,
    foreach($this->arrayData as $key => $list)
    {
        // $mileIndex = $list['index'];
        // $mileparent = $list['parent_id'];

            $insert= [
                'project_id'=>$this->projectId,
                'Index_id'=>$list['index'],
                'parent_id'=>$list['parent_id'],
                'm1'=>$list['mStone_name'],
                'm2'=>$list['mVal'],
                'm3'=>$list['mUnit'],
                'm4'=>$list['mCost'],
            ];
dd($insert);
            MileStone::create($insert);
        //
    }

    // $insert[] = [
    //     ,
    //     'project_id'=>$this->projectId,
    //     'Index_id'=>$list['index'],
    //     'parent_id'=>$list['parent_id'],
    //     'm1'=>$val['mStone_name'],
    //     'm2'=>$val['mVal'],
    //     'm3'=>$val['mUnit'],
    //     'm4'=>$val['mCost'],
    // ];
    // dd($insert);
    // MileStone::create($insert);

        $this->reset();
        $this->emit('openForm');
        // dd($insert);
        // MileStone::create($insert);

    }

    public $Type;

    public function chMileType($value)
    {
        return $this->Type = $value;
        // dd($this->Type);
    }

    public function render()
    {
        // info($this->inputsData);

        $this->emit('changeTitle', 'Milestone');
        $assets = ['chart', 'animation'];
        return view('livewire.milestone.create-milestone', compact('assets'));
    }
}
