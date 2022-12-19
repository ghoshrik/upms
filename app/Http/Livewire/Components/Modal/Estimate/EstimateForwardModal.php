<?php

namespace App\Http\Livewire\Components\Modal\Estimate;

use App\Models\AccessMaster;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EstimateForwardModal extends Component
{
    protected $listeners = ['openForwardModal'=> 'forwardModalOpen'];
    public $forwardModal = false,$estimate_id,$getUserList = [];

    public function forwardModalOpen($estimate_id)
    {
        $this->reset();
        $this->estimate_id = $estimate_id;
        $this->forwardModal = !$this->forwardModal;
        $userAccess_id = AccessMaster::select('access_parent_id')->join('access_types', 'access_masters.access_type_id', '=', 'access_types.id')->where('user_id', Auth::user()->id)->first();
        $this->getUserList = User::join('access_masters', 'users.id', '=', 'access_masters.user_id')
            ->join('access_types', 'access_masters.access_type_id', '=', 'access_types.id')
            ->where('access_types.id', $userAccess_id->access_parent_id)
            ->get();
            // dd($this->getUserList);
    }
    public function render()
    {
        return view('livewire.components.modal.estimate.estimate-forward-modal');
    }
}
