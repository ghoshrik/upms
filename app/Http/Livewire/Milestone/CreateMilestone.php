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
    public function printTreeHTML($tree) {
        echo "<ul>\n";
        foreach ($tree as $node) {
          echo "<li>" . $node['id'] . "</li>\n";
        //   if (!empty($node['children'])) {
        //     printTreeHTML($node['children']);
        //   }
        }
        echo "</ul>\n";
    }

    public function addMilestone($nodes)
    {
        // $this->printTreeHTML($nodes);
        // dd($nodes);
        $this->Index = $nodes+1;
        $this->mileStoneData[$this->Index] = [
            'Index'=>$this->Index,
            'M1'=>'',
            'M2'=>'',
            'M3'=>'',
            'M4'=>'',
            'p'=>0
        ];
        // dd($this->mileStoneData);
        // $nodes = [
        //     ['id' => 1, 'parent_id' => null],
        //     ['id' => 2, 'parent_id' => 1],
        //     ['id' => 3, 'parent_id' => 1],
        //     ['id' => 4, 'parent_id' => 2],
        //     ['id' => 5, 'parent_id' => 2],
        //     ['id' => 6, 'parent_id' => 3],
        // ];
        // $children = array();

        // foreach ($nodes as $node) {
        //     $children[$node['id']] = $node;
        //     $children[$node['id']]['children'] = array();
        // }

        // foreach ($children as $child) {
        //     if (isset($children[$child['parent_id']])) {
        //         $children[$child['parent_id']]['children'][] = &$children[$child['id']];
        //     }
        // }

        // $rootNodes = array();
        // foreach ($children as $child) {
        //     if (!isset($child['parent_id'])) {
        //         $rootNodes[] = $child;
        //     }
        // }
        // dd($rootNodes);
        // return $rootNodes;


//         $nodes = [
//             ['id' => 1, 'parent_id' => null],
//             ['id' => 2, 'parent_id' => 1],
//             ['id' => 3, 'parent_id' => 1],
//             ['id' => 4, 'parent_id' => 2],
//             ['id' => 5, 'parent_id' => 2],
//             ['id' => 6, 'parent_id' => 3],
//         ];

// $this->treeView = $this->buildTree($nodes);

// public function buildTree($nodes)
//     {
//         $children = array();

//         foreach ($nodes as $node) {
//             $children[$node['id']] = $node;
//             $children[$node['id']]['children'] = array();
//         }

//         foreach ($children as $child) {
//             if (isset($children[$child['parent_id']])) {
//                 $children[$child['parent_id']]['children'][] = &$children[$child['id']];
//             }
//         }

//         $rootNodes = array();
//         foreach ($children as $child) {
//             if (!isset($child['parent_id'])) {
//                 $rootNodes[] = $child;
//             }
//         }

//         return $rootNodes;
//     }



// function printTreeHTML($tree) {
//   echo "<ul>\n";
//   foreach ($tree as $node) {
//     echo "<li>" . $node['id'] . "</li>\n";
//     if (!empty($node['children'])) {
//       printTreeHTML($node['children']);
//     }
//   }
//   echo "</ul>\n";












    }
    public function render()
    {
        // info($this->inputsData);

        $this->emit('changeTitle', 'Milestone');
        $assets = ['chart', 'animation'];
        return view('livewire.milestone.create-milestone',compact('assets'));
    }
}
