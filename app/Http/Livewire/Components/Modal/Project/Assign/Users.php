<?php

namespace App\Http\Livewire\Components\Modal\Project\Assign;

use App\Models\Group;
use App\Models\Office;
use App\Models\ProjectCreation;
use App\Models\Role;
use App\Models\User;
use App\Models\UsersHasRoles;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use WireUi\Traits\Actions;

class Users extends Component
{

    use Actions;
    protected $listeners = ['assignProjectuser'];

    public $projectID, $grouplists = [], $officeLists = [], $userLists = [];
    public $group, $office, $user;
    public $assignModal = false;
    public $office_users=[];
    public $title;

    public function assignProjectuser($projectid)
    {
        $this->reset();
        $projectId = is_array($projectid) ? $projectid['id'] : $projectid;
        $this->projectID = $projectId;

        // dd($projectId);
        // if($projectId->users)
        // {
        //     dd("asdasd");
        // }    
        // else
        // {

            $this->assignModal = !$this->assignModal;
            // $this->existingAssignUser();
            $this->grouplists = Group::where('department_id', Auth::user()->department_id)->get();
        // }

        
        // $this->emit('GroupsLists',$this->groups);
    }


    public function getDeptOffice()
    {
        // dd($this->group);
        $this->officeLists = Office::where('group_id', $this->group)->get();
        
    }

    public function getDeptUsers()
    {
        $this->userLists = User::leftjoin('user_resources','user_resources.user_id','=','users.id')
        ->leftjoin('users_has_roles','users_has_roles.user_id','=','users.id')
        ->where('users_has_roles.role_id',12)
        ->where('user_resources.resource_id',$this->office)
        ->select('users.id as id','users.emp_name as emp_name')
        ->get();
        // $this->userLists= User::join('user_resources','user_resources.user_id','=','users.id')
        //                 // ->join('users_has_roles','users_has_roles.office_id','=','user_resources.resource_id')
        //                 ->where('user_resources.resource_id', $this->office)
        //                 // ->where('users_has_roles.role_id',12)
        //                         ->get();
    }

    public function assignUser()
    {
        // dd($this->user,$this->projectID);
        // DB::table('projects_users')->insert(['user_id'=>$this->user,'project_creation_id'=>$this->projectID]);
        $user = User::find($this->user);
        $user->projects()->attach($this->projectID, [
            'assigned_at' => Carbon::now(),
        ]);
        $this->notification()->success(
            $this->title = 'User Assign successfully'
        );
        $this->reset();
    }

    public function existingAssignUser()
    {
        $this->office_users = DB::table('projects_users as pu')
            ->join('project_creations as p', 'pu.project_creation_id', '=', 'p.id')
            ->join('users as u', 'pu.user_id', '=', 'u.id') 
            ->select('pu.*', 'p.name as project_name', 'u.emp_name as user_name') 
            ->get();

        // dd($this->office_users);
    }

    public function render()
    {

        return view('livewire.components.modal.project.assign.users');
    }
}
