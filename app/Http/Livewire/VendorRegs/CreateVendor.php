<?php

namespace App\Http\Livewire\VendorRegs;

use Throwable;
use App\Models\Vendor;
use Livewire\Component;

class CreateVendor extends Component
{
    public $vendorRegs = [];

    protected $rules = [
        'vendorRegs.comp_name' => 'required|string',
        'vendorRegs.tin_number' => 'required|unique:vendors.tin_number',
        'vendorRegs.pan_number' => 'required|unique:vendors.pan_number',
        'vendorRegs.mobile' => 'required|unique:vendors.mobile',
        'vendorRegs.address' => 'required',

    ];
    protected $messages = [
        'vendorRegs.comp_name.required'=>'This field is required',
        'vendorRegs.comp_name.string'=>'field must be string',
        'vendorRegs.tin_number.required'=>'This field is required',
        'vendorRegs.pan_number.required'=>'This field is required',
        'vendorRegs.mobile.required'=>'This field is required',
        'vendorRegs.address.required'=>'This field is required',
    ];
    public function mount()
    {
        $this->vendorRegs['comp_name']='';
        $this->vendorRegs['mobile']='';
        $this->vendorRegs['pan_number']='';
        $this->vendorRegs['tin_number']='';
        $this->vendorRegs['address']='';
        $data = Vendor::all();
        // dd($data);
    }
    public function store()
    {
        // dd($this->vendorRegs);
        // $this->validate();
        try{
            $insert = [
                'comp_name'=>$this->vendorRegs['comp_name'],
                'tin_number'=>$this->vendorRegs['tin_number'],
                'pan_number'=>$this->vendorRegs['pan_number'],
                'mobile'=>$this->vendorRegs['mobile'],
                'address'=>$this->vendorRegs['address'],
            ];
            // Vendor::create([
            //     'comp_name'=>$this->vendorRegs['comp_name'],
            //     'tin_number'=>$this->vendorRegs['tin_number'],
            //     'pan_number'=>$this->vendorRegs['pan_number'],
            //     'mobile'=>$this->vendorRegs['mobile'],
            //     'address'=>$this->vendorRegs['address'],
            // ]);
            // dd($insert);
            Vendor::create($insert);
            $this->reset();
            $this->emit('openForm');
        }
        catch (Throwable $th) {
            // session()->flash('serverError', $th->getMessage());
            $this->emit('showError', $th->getMessage());
        }

    }
    // public function updated($param)
    // {
    //     $this->validateOnly($param);
    // }
    public function render()
    {
        return view('livewire.vendor-regs.create-vendor');
    }
}
