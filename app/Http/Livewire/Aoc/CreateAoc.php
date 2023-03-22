<?php

namespace App\Http\Livewire\Aoc;

use App\Models\AAFS;
use App\Models\Aoc;
use App\Models\Vendor;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;

class CreateAoc extends Component
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
        try {
            foreach ($this->storeInputData['vendorId'] as $key => $vendorId) {
                $insert = [
                    'project_id' => $this->storeInputData['projectId'],
                    'go_id' => $this->storeInputData['goId'],
                    'vendor_id' => $vendorId,
                    // 'go_record'=>$this->storeInputData['uploadData']->storeAs($this->storeInputData['uploadData']),
                    'approved_date' => getFromDateAttribute($this->storeInputData['approvedDate']),
                    'amount' => $this->storeInputData['amount'],
                ];
                Aoc::create($insert);
            }
            $this->notification()->success(
                $title = trans('cruds.funds.create_msg')
            );
            // $this->reset();
            $this->emit('openEntryForm');
        } catch (\Throwable$th) {
            $this->emit('showError', $th->getMessage());
        }

    }
    public function render()
    {
        // $this->fetchData['project_number'] = SorMaster::where('is_verified','=',1)->get();
        $this->fetchData['vendors'] = Vendor::all();

        // $this->emit('changeTitel', trans('cruds.funds.title'));
        return view('livewire.aoc.create-aoc');
    }
}
