<?php

namespace App\Http\Livewire\Milestone;

use App\Models\Milestone;
use Livewire\Component;
use App\Models\SorMaster;

class CreateMilestone extends Component
{
    public $mileStoneData = [], $Index = 0,$treeView,$arrayData=[],$projectId,$projects_number=[],$description;


    protected $rules = [
        'projectId'=>'required|integer|unique:mile_stones,project_id',
    ];
    protected $messages = [
        'projectId.required'=>'this filed is required',
        'projectId.integer'=>'format invalid',
        'projectId.unique'=>'project number must be unique',
    ];


    public function addMilestone($id)
    {
        $this->Index = count($this->mileStoneData)+1;
            $this->mileStoneData[] = [
                'index' => $this->Index,
                'parent_id' => $id,
                'project_id'=>$this->projectId,
                'milestone_name'=>'',
                'weight'=>'',
                'unit_type'=>'',
                'cost'=>'',
            ];

        // dd($this->mileStoneData);
        $this->treeView= buildTree($this->mileStoneData);
        // dd($this->treeView);
    }

    // public function buildTree($nodes)
    // {
    //     $children = array();

    //     foreach ($nodes as $node) {
    //         $children[$node['index']] = $node;
    //         $children[$node['index']]['children'] = array();
    //     }
    //     foreach ($children as $child) {
    //         if (isset($children[$child['parent_id']])) {
    //             $children[$child['parent_id']]['children'][] = &$children[$child['index']];
    //         }
    //     }
    //     $rootNodes = array();
    //     foreach ($children as $child) {
    //         if ($child['parent_id']==0) {
    //             $rootNodes[] = $child;
    //         }
    //     }
    //     return $rootNodes;
    // }


    public function removeMilestone($deleteId)
    {
                // dd($deleteId);
        // remove_element_by_value($this->mileStoneData,$deleteId);
        // $array = array_values($this->mileStoneData);
        foreach($this->mileStoneData as $k => $v) {

            if($v['index']== $deleteId)
            {
                unset($this->mileStoneData [$k]);
                array_values($this->mileStoneData);
            }
            if($v['parent_id'] == $deleteId)
            {
                unset($this->mileStoneData[$k]);
            }
        }
        //
        // return $array;
        // dd($this->treeView());
        $this->reset('mileStoneData');
        // $this->mileStoneData = $array;
        // $reindexed = array_map('array_values',  $this->mileStoneData);
        // $reindexed = array_values($reindexed);
        $this->treeView= buildTree($this->mileStoneData);
        // dd($this->mileStoneData);
        // unset($this->mileStoneData[$deleteId]);
        // dd($this->mileStoneData);
        // die();

        // $newArray = [];
        // foreach ($this->mileStoneData as $key => $value) {

        //     unset($this->mileStoneData[$value['index']]);
        //     if (is_array($value)) {
        //         unset($value['parent_id']);
        //     } else {
        //         $newArray[$key] = $value;
        //     }
        // }
    }


    public function store()
    {
        // $this->validate();
        // die();
        // dd($this->mileStoneData);
        try{
            foreach($this->mileStoneData as $mileStone)
            {
                // dd($mileStone);
                // MileStone::create($mileStone);
                $insert = [
                    'index'=>$mileStone['index'],
                    'milestone_id'=>$mileStone['parent_id'],
                    'project_id'=>$mileStone['project_id'],
                    'milestone_name'=>$mileStone['milestone_name'],
                    'weight'=>$mileStone['weight'],
                    'unit_type'=>$mileStone['unit_type'],
                    'cost'=>$mileStone['cost']
                ];
                // dd($insert);
                Milestone::create($insert);
            }
        }


        catch (\Throwable $th) {
            $this->emit('showError', $th->getMessage());
        }

        $this->reset();
        $this->emit('openForm');

    }


    public function mount()
    {
        $this->projects_number = SorMaster::where('is_verified','=',1)->get();
    }

    public function changeProject()
    {//$this->projectId = $value;
        // dd($value);
        $this->description = SorMaster::select('sorMasterDesc')->where('estimate_id','=',$this->projectId)->first();
        // dd($this->description);
        $this->description = $this->description['sorMasterDesc'];
    }

    public $Type;

    public function chMileType($value)
    {
        return $this->Type = $value;
        // dd($this->Type);
    }

    public function render()
    {
        $this->emit('changeTitle', 'Milestone');
        $assets = ['chart', 'animation'];
        return view('livewire.milestone.create-milestone',compact('assets'));
    }
}
