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
    public $fetchData, $InputStoreData = [];

    protected $rules = [
        'InputStoreData.projID' => 'required',
        'InputStoreData.tenderNo' => 'required|numeric',
        'InputStoreData.tenderTitle' => 'required|string',
        'InputStoreData.publishDate' => 'required',
        'InputStoreData.closeDate' => 'required',
        'InputStoreData.BiderNo' => 'required|numeric',
        'InputStoreData.tenderCategory' => 'required',
        'InputStoreData.tenderAmount' => 'required|numeric'
    ];
    protected $messages = [
        'InputStoreData.projID.required' => 'This projects field is required',
        'InputStoreData.tenderNo.required' => 'This tenderNo field is required',
        'InputStoreData.tenderNo.numeric' => 'this field is must be number',
        'InputStoreData.tenderTitle.required' => 'This tender title field is required',
        'InputStoreData.tenderTitle.string' => 'This tender Title must be string',
        'InputStoreData.publishDate.required' => 'This field is required',
        'InputStoreData.publishDate.date_format' => 'This field must be valid only date format',
        'InputStoreData.closeDate.required' => 'This field is required',
        'InputStoreData.closeDate.date_format' => 'This field must be valid only date format',
        'InputStoreData.BiderNo.required' => 'This field is required',
        'InputStoreData.BiderNo.numeric' => 'This field must be valid number format',
        'InputStoreData.tenderCategory.required' => 'This field is required',
        'InputStoreData.tenderAmount.required' => 'This field is required',
        'InputStoreData.tenderAmount.numeric' => 'This field only number Allow'
    ];

    public function mount()
    {
        $this->InputStoreData['projID'] = '';
        $this->InputStoreData['tenderNo'] = '';
        $this->InputStoreData['tenderTitle'] = '';
        $this->InputStoreData['publishDate'] = '';
        $this->InputStoreData['closeDate'] = '';
        $this->InputStoreData['BiderNo'] = '';
        $this->InputStoreData['tenderCategory'] = '';
        $this->InputStoreData['tenderAmount'] = '';
    }

    public function updated($param)
    {
        $this->validateOnly($param);
    }
    // public function getProjectDetails()
    // {
    //     dd($keyword['_x_bindings']['value']);
    //     // dd($this->fetchData['project_number']['estimate_id']);
    // }
    public function store()
    {
        $this->validate();
        try {
            $insert = [
                'project_no' => $this->InputStoreData['projID'],
                'tender_id' => $this->InputStoreData['tenderNo'],
                'tender_title' => $this->InputStoreData['tenderTitle'],
                'publish_date' => $this->InputStoreData['publishDate'],
                'close_date' => $this->InputStoreData['closeDate'],
                'bidder_name' => $this->InputStoreData['BiderNo'],
                'tender_category' => $this->InputStoreData['tenderCategory'],
                'tender_amount' => $this->InputStoreData['tenderAmount']
            ];
            // dd($insert);

            Tender::create($insert);
            $this->notification()->success(
                $title = trans('cruds.tenders.create_msg')
            );
            $this->reset();
            $this->emit('openEntryForm');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            $this->emit('showError', $th->getMessage());
        }
    }
    public function render()
    {
        $this->fetchData['project_number'] = SorMaster::select('estimate_masters.*', 'estimate_prepares.total_amount as total_project_cost')
            ->join('estimate_prepares', 'estimate_prepares.estimate_id', '=', 'estimate_masters.estimate_id')
            ->where('estimate_prepares.operation', '=', 'Total')
            ->where('is_verified', '=', 1)->get();
        return view('livewire.tender.create-tender');
    }
}
