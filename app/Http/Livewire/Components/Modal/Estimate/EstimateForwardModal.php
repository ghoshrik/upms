<?php

namespace App\Http\Livewire\Components\Modal\Estimate;

use App\Models\AccessMaster;
use App\Models\EstimateUserAssignRecord;
use App\Models\SorMaster;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use WireUi\Traits\Actions;

class EstimateForwardModal extends Component
{
    use Actions;
    protected $listeners = ['openForwardModal' => 'forwardModalOpen'];
    public $forwardModal = false, $estimate_id, $assigenUsersList = [],$assignUserDetails,$userAssignRemarks;

    public function forwardModalOpen($estimate_id)
    {
        $this->reset();
        $this->estimate_id = $estimate_id;
        $this->forwardModal = !$this->forwardModal;
        // $userAccess_id = AccessMaster::select('access_parent_id')->join('access_types', 'access_masters.access_type_id', '=', 'access_types.id')->where('user_id', Auth::user()->id)->first();
        // $this->assigenUsersList = User::join('access_masters', 'users.id', '=', 'access_masters.user_id')
        //     ->join('access_types', 'access_masters.access_type_id', '=', 'access_types.id')
        //     ->where('access_types.id', $userAccess_id->access_parent_id)
        //     ->get();
        //dd($this->assigenUsersList);
    }

    public function forwardAssignUser()
    {
        $forwardUserDetails = explode('-', $this->assignUserDetails);
        $data = [
            'estimate_id' => $forwardUserDetails[2],
            'estimate_user_type' => $forwardUserDetails[1],
            'estimate_user_id' => $forwardUserDetails[0],
            'comments' => $this->userAssignRemarks,
        ];
        if (EstimateUserAssignRecord::create($data)) {
            SorMaster::where('estimate_id', $forwardUserDetails[2])->update(['status' => 2]);
            $this->notification()->success(
                $title = 'Success',
                $description =  'Successfully Assign!!'
            );
        }
        $this->reset();
    }
    public function render()
    {
        // TODO:: 1) REMOVE THIS SQL FROM RENDER 2) AFTER GEETING THE USER DATA, IF WE TYPE THE REMARKS THE USER DATA CHANGING TO ADMIN [NEED TO BE FIXED]
        $userAccess_id = AccessMaster::select('access_parent_id')->join('access_types', 'access_masters.access_type_id', '=', 'access_types.id')->where('user_id', Auth::user()->id)->first();
        $this->assigenUsersList = User::join('access_masters', 'users.id', '=', 'access_masters.user_id')
            ->join('access_types', 'access_masters.access_type_id', '=', 'access_types.id')
            ->where('access_types.id', $userAccess_id->access_parent_id)
            ->get();
        // Log::info(json_encode($this->assigenUsersList));
        return view('livewire.components.modal.estimate.estimate-forward-modal');
    }
}
