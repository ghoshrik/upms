<?php

namespace App\Http\Livewire\VendorRegs;

use App\Models\Vendor;
use Livewire\Component;
use WireUi\Traits\Actions;

class CreateVendor extends Component
{

    use Actions;
    public $vendorRegs;

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
        // dd("else");
       try{
        // dd($this->vendorRegs);
            $insert = [
                'comp_name'=>$this->vendorRegs['comp_name'],
                'tin_number'=>$this->vendorRegs['tin_number'],
                'pan_number'=>$this->vendorRegs['tin_number'],
                'mobile'=>$this->vendorRegs['mobile'],
                'address'=>$this->vendorRegs['address'],
                'gstn_no'=>$this->vendorRegs['gstin'],
                'class_vendor'=>$this->vendorRegs['class_vendor']
            ];
            // dd($insert);
            Vendor::create($insert);
            $this->notification()->success(
                $title = trans('cruds.vendors.create_msg'),
            );
            $this->reset();
            $this->emit('openForm');

       }
        catch (\Throwable $th) {
            $this->emit('showError', $th->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.vendor-regs.create-vendor');
    }
}
