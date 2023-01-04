<?php

namespace App\Http\Livewire\Milestone;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CreateMilestone extends Component
{
    public $mileStoneData = [], $Index = 0,$treeView;
    public $mStone_name,$mVal,$mUnit,$mCost,$projectId,$description;
    public function addMilestone($id)
    {
        if($id == 0)
        {
            $this->Index = count($this->mileStoneData) + 1;
            $this->mileStoneData[] = [
                'index' => $this->Index,
                'parent_id' => $id
            ];
        }
        elseif($this->mileStoneData != null)
        {
            $index = count($this->mileStoneData) + 1;
            $this->mileStoneData[] = [
                'index' => $index,
                'parent_id' => $id
            ];
        }else{

        }
        $this->treeView= $this->buildTree($this->mileStoneData);
        // dd($this->treeView);
    }
    // public function mount()
    // {
    //    $this->treeView = [
    //         // [
    //             'mStone_name'=>'',
    //             'mVal'=>'',
    //             'mUnit'=>'',
    //             'mCost'=>'',
    //         // ]
    //    ];
    // }

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

    public function store()
    {
       dd($this->treeView);
    }


    public function render()
    {
        // info($this->inputsData);

        $this->emit('changeTitle', 'Milestone');
        $assets = ['chart', 'animation'];
        return view('livewire.milestone.create-milestone', compact('assets'));
    }
}
