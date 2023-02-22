<?php

namespace App\Http\Livewire\Fund;

use App\Models\Vendor;
use Livewire\Component;
use App\Models\SorMaster;
use WireUi\Traits\Actions;
use App\Models\Fundapprove;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;

class CreateFunds extends Component
{
    use Actions,WithFileUploads;
    public $titel,$subTitel,$formOpen,$fetchData = [],$storeInputData = [];

    public function mount()
    {

        $this->fetchData['project_number'] = SorMaster::where('is_verified','=',1)->get();
        $this->fetchData['vendors'] = Vendor::all();
        $this->storeInputData['projectId'] = '';
        $this->storeInputData['goId'] = '';
        $this->storeInputData['vendorId'] = '';
        $this->storeInputData['approvedDate'] = '';
        $this->storeInputData['amount'] = '';
    }

    public function store()
    {

        $insert = [
            'project_id'=>$this->storeInputData['projectId'],
            'go_id'=>$this->storeInputData['goId'],
            'vendor_id'=>$this->storeInputData['vendorId'],
            // 'go_record'=>$this->storeInputData['uploadData']->storeAs($this->storeInputData['uploadData']),
            'approved_date'=>getFromDateAttribute($this->storeInputData['approvedDate']),
            'amount'=>$this->storeInputData['amount'],
        ];
        // dd($insert);
        Fundapprove::create($insert);
        $this->notification()->success(
            $title = trans('cruds.funds.create_msg')
        );
        $this->reset();
        $this->emit('openForm');


    }
    public function formOCControl()
    {
        $this->formOpen = !$this->formOcreatepen;
        $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
    }
    public function render()
    {
        $this->fetchData['project_number'] = SorMaster::where('is_verified','=',1)->get();
        $this->fetchData['vendors'] = Vendor::all();

        $this->emit('changeTitel','Milestone');
        $assets = ['chart', 'animation'];
        return view('livewire.fund.create-funds',compact('assets'));
    }
}
