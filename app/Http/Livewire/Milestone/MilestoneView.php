<?php

namespace App\Http\Livewire\Milestone;

use App\Models\Milestone;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class MilestoneView extends Component
{
    // public $viewMode = false;
    protected $listeners = ['ApprovedMilestone'=>'ApprovedViewMilestone'];


    public $milestones,$allTree;


    public function ApprovedMilestone($value)
    {
        // dd("start");
        dd($value);
    }

    // public function buildTree($nodes)
    // {

    //     $this->milestones = $nodes;
        // dd($this->milestones);
        // $children = array();

        // foreach ($nodes as $node) {
        //     $children[$node['index']] = $node;
        //     $children[$node['index']]['children'] = array();
        // }
        // foreach ($children as $child) {
        //     if (isset($children[$child['parent_id']])) {
        //         $children[$child['parent_id']]['children'][] = &$children[$child['index']];
        //     }
        // }
        // $rootNodes = array();
        // foreach ($children as $child) {
        //     if ($child['parent_id']==0) {
        //         $rootNodes[] = $child;
        //     }
        // }
        // dd($rootNodes);
        // // Log::info(json_encode($rootNodes));
        // return $rootNodes;

        // $this->milestones = Milestone::whereNull('milestone_id')->where('project_id',$this->mileview)
        // ->with('childrenMilestones')
        // ->get();
        // dd($this->milestones);
    // }



    public function render()
    {
        return view('livewire.milestone.milestone-view');
    }
}
