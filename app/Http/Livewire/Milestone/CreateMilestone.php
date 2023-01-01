<?php

namespace App\Http\Livewire\Milestone;

use Livewire\Component;

class CreateMilestone extends Component
{
    public $mileStoneData=[],$Index=0,$subMileData=[];
    public function addMilestone($nodes)
    {
        $this->Index = $nodes+1;
        $this->mileStoneData[] = [
            'Index'=>$this->Index,
            'M1'=>'',
            'M2'=>'',
            'M3'=>'',
            'M4'=>'',
            'p'=>0
        ];

    }
    // public $subMileData=[];

   public function printTreeHTML($tree) {
          echo "<ul>\n";
          foreach ($tree as $node) {
            echo "<li>" . $node['Index'] . "</li>\n";
            // if (!empty($node['children'])) {
            //   printTreeHTML($node['children']);
            // }
          }
          echo "</ul>\n";
   }
   public function addSubMilestone($nodes)
    {
        $this->subMileData[] = [
            'Index'=>$this->Index,
            'M1'=>'',
            'M2'=>'',
            'M3'=>'',
            'M4'=>'',
            'p'=>$nodes
        ];
        dd($this->mileStoneData);
        // $children = array();
        // foreach ($nodes as $node) {
        //     $children[$node['id']] = $node;
        //     $children[$node['id']]['children'] = array();
        // }
    }
    public function render()
    {
        // info($this->inputsData);

        $this->emit('changeTitle', 'Milestone');
        $assets = ['chart', 'animation'];
        return view('livewire.milestone.create-milestone',compact('assets'));
    }
}
