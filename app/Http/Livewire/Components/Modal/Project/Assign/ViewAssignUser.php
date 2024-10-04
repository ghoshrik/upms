<?php

namespace App\Http\Livewire\Components\Modal\Project\Assign;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ViewAssignUser extends Component
{

    protected $listeners = ['userDetails'=>'assignUserDetails'];
    public $projectid;
    private $projectDetials;
    public $userLists=[];
    public $showModal = false;

    public function assignUserDetails($userId)
    {

        // $this->users = DB::table('projects_users as pu')
        //     ->join('project_creations as p', 'pu.project_creation_id', '=', 'p.id')
        //     ->join('users as u', 'pu.user_id', '=', 'u.id') 
        //     ->where('users.id',$userId)
        //     ->select('pu.*', 'p.name as project_name', 'u.emp_name as user_name') 
        //     ->get();
        $this->reset();
        $projectId = is_array($userId) ? $userId['id'] : $userId;
        $this->projectid = $projectId;
        $this->showModal = !$this->showModal;
        $projects= DB::table('projects_users')
                        ->join('project_creations','project_creations.id','=','projects_users.project_creation_id')
                        ->where('projects_users.project_creation_id',$userId)
                        ->first();
        // dd($projects);
        $this->projectDetials = $projects;

        $this->userLists = User::find($projects->user_id);
        // $projects->assigned_at
        // dd($this->userLists);
        

    }
    public function render()
    {
        return view('livewire.components.modal.project.assign.view-assign-user');
    }
}
