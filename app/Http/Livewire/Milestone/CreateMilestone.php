<?php

namespace App\Http\Livewire\Milestone;

use App\Models\MileStone;
use App\Models\SorMaster;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CreateMilestone extends Component
{
    public $mileStoneData = [], $Index = 0,$treeView,$arrayData=[],$projectId,$projects_number=[],$description;

    public function mount()
    {
        $this->projects_number = SorMaster::where('is_verified','=',1)->get();
    }
    public function addMilestone($id)
    {
        $this->Index = count($this->mileStoneData)+1;
            $this->mileStoneData[] = [
                'index' => $this->Index,
                'parent_id' => $id,
                'project_id'=>$this->projectId,
                'm1'=>'',
                'm2'=>'',
                'm3'=>'',
                'm4'=>'',
            ];
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

    public function changeproject()
    {//$this->projectId = $value;
        // dd($value);
        $this->description = SorMaster::select('sorMasterDesc')->where('estimate_id','=',$this->projectId)->first();
        // dd($this->description);
        $this->description = $this->description['sorMasterDesc'];
    }
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
        // $this->validate();
        try{
            foreach($this->mileStoneData as $mileStone)
            {
                Milestone::create($mileStone);
            }
        }


        catch (\Throwable $th) {
            $this->emit('showError', $th->getMessage());
        }

        $this->reset();
        $this->emit('openForm');

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
