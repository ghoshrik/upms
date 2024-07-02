<?php

namespace App\Http\Livewire\VendorRegs;

use App\Models\Vendor;
use Livewire\Component;
use WireUi\Traits\Actions;

class CreateVendor extends Component
{

    use Actions;
    public $vendorRegs = [];

    protected $rules = [
        'vendorRegs.comp_name' => 'required',
        'vendorRegs.tin_number' => 'required',
        'vendorRegs.pan_number' => 'required',
        'vendorRegs.gstin' => 'required',
        'vendorRegs.class_vendor' => 'required',
        'vendorRegs.mobile' => 'required|numeric',
        'vendorRegs.address' => 'required|string'
    ];
    protected $messages = [
        'vendorRegs.comp_name.required' => 'This company name field is required',
        'vendorRegs.tin_number.required' => 'This Tin number field is required',
        'vendorRegs.pan_number.required' => 'This Pan Number field is required',
        'vendorRegs.gstin.required' => 'This GSTIN Number field is required',
        'vendorRegs.class_vendor.required' => 'This class vendor field is required',
        'vendorRegs.mobile.required' => 'Mobile number is required',
        'vendorRegs.mobile.numeric' => 'Only validate number value',
        'vendorRegs.address.required' => 'This address field is required',
        'vendorRegs.address.string' => 'This address field is required'
    ];

    public function updated($param)
    {
        $this->validateOnly($param);
    }

    public function mount()
    {
        $this->vendorRegs['comp_name'] = '';
        $this->vendorRegs['tin_number'] = '';
        $this->vendorRegs['pan_number'] = '';
        $this->vendorRegs['gstin'] = '';
        $this->vendorRegs['class_vendor'] = '';
        $this->vendorRegs['mobile'] = '';
        $this->vendorRegs['address'] = '';
    }
    public function store()
    {
        $this->validate();
        try {
            // dd($this->vendorRegs);
            $insert = [
                'comp_name' => $this->vendorRegs['comp_name'],
                'tin_number' => $this->vendorRegs['tin_number'],
                'pan_number' => $this->vendorRegs['pan_number'],
                'mobile' => $this->vendorRegs['mobile'],
                'address' => $this->vendorRegs['address'],
                'gstn_no' => $this->vendorRegs['gstin'],
                'class_vendor' => $this->vendorRegs['class_vendor']
            ];
            // dd($insert);
            Vendor::create($insert);
            $this->notification()->success(
                $title = trans('cruds.vendors.create_msg'),
            );
            $this->reset();
            $this->emit('openEntryForm');
        } catch (\Throwable $th) {
            $this->emit('showError', $th->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.vendor-regs.create-vendor');
    }
}
