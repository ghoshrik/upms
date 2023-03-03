<?php

namespace App\Http\Livewire\Tender;

use App\Models\Aoc;
use App\Models\Tender;
use Livewire\Component;
use App\Models\SorMaster;
use WireUi\Traits\Actions;

class CreateTender extends Component
{
    use Actions;
    public $fetchData,$InputStoreData = [];
    public function mount()
    {
        $this->InputStoreData['projID'] = '';
        $this->InputStoreData['tenderNo'] = '';
        $this->InputStoreData['tenderTitle'] = '';
        $this->InputStoreData['publishDate'] = '';
        $this->InputStoreData['closeDate'] = '';
        $this->InputStoreData['BiderNo'] = '';
        $this->InputStoreData['tenderCategory'] = '';

    }
    public function store()
    {
        try{
            $insert = [
                'project_no'=>$this->InputStoreData['projID'],
                'tender_id'=>$this->InputStoreData['tenderNo'],
                'tender_title'=>$this->InputStoreData['tenderTitle'],
                'publish_date'=>$this->InputStoreData['publishDate'],
                'close_date'=>$this->InputStoreData['closeDate'],
                'bidder_name'=>$this->InputStoreData['BiderNo'] ,
                'tender_category'=>$this->InputStoreData['tenderCategory']
            ];
            // dd($insert);

            Tender::create($insert);
            $this->notification()->success(
                $title = trans('cruds.aoc.create_msg')
            );
            $this->reset();
            $this->emit('openForm');
        }
        catch(\Throwable $th)
        {
            $this->emit('showError', $th->getMessage());
        }
    }
    public function render()
    {
        $this->fetchData['project_number'] = SorMaster::where('is_verified','=',1)->get();
        return view('livewire.tender.create-tender');
    }
}
