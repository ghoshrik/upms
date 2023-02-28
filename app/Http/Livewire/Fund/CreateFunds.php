<?php

namespace App\Http\Livewire\Fund;

use App\Models\AAFS;
use App\Models\Vendor;
use Livewire\Component;
use App\Models\SorMaster;
use WireUi\Traits\Actions;
use App\Models\Fundapprove;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;

class CreateFunds extends Component
{
    use Actions, WithFileUploads;
    public $titel, $subTitel, $formOpen, $fetchData = [], $storeInputData = [];

    public function mount()
    {

        $this->fetchData['project_number'] = AAFS::get();
        // $this->fetchData['vendors'] = Vendor::all();
        $this->storeInputData['projectId'] = '';
        $this->fetchData['goID'] = '';
        $this->storeInputData['goId'] = '';
        $this->storeInputData['vendorId'] = '';
        $this->storeInputData['approvedDate'] = '';
        $this->storeInputData['amount'] = '';
    }
    public function changeProjectID()
    {
        // dd($this->storeInputData['projectId']);
        $this->fetchData['goID'] = AAFS::select('go_id')->where('project_id', $this->storeInputData['projectId'])->first();
        $this->storeInputData['goId'] = $this->fetchData['goID']['go_id'];
        //  dd($this->storeInputData['goId']);
    }

    public function store()
    {
        foreach ($this->storeInputData['vendorId'] as $key => $vendorId) {
            $insert = [
                'project_id' => $this->storeInputData['projectId'],
                'go_id' => $this->storeInputData['goId'],
                'vendor_id' => $vendorId,
                // 'go_record'=>$this->storeInputData['uploadData']->storeAs($this->storeInputData['uploadData']),
                'approved_date' => getFromDateAttribute($this->storeInputData['approvedDate']),
                'amount' => $this->storeInputData['amount'],
            ];
            // dd($insert);
            Fundapprove::create($insert);
        }


        $this->notification()->success(
            $title = trans('cruds.funds.create_msg')
        );
        // $this->reset();
        $this->emit('openForm');
    }



    public function formOCControl()
    {
        $this->formOpen = !$this->formOcreatepen;
        $this->emit('changeSubTitel', ($this->formOpen) ? 'Create new' : 'List');
    }
    public function render()
    {
        // $this->fetchData['project_number'] = SorMaster::where('is_verified','=',1)->get();
        $this->fetchData['vendors'] = Vendor::all();

        $this->emit('changeTitel', trans('cruds.funds.title'));
        $assets = ['chart', 'animation'];
        return view('livewire.fund.create-funds', compact('assets'));
    }
}
