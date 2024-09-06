<?php

namespace App\Http\Livewire\NonSchedule;

use App\Models\Nonsor;
use App\Models\UnitMaster;
use Livewire\Component;

class Create extends Component
{
    public $formData =[],$units=[];

    public function mount()
    {
        $this->formData['item_name'] = '';
        $this->formData['unit']='';
        $this->formData['qty']='';
        $this->formData['price']='';
        $this->formData['total_amount']='';

        $this->units = UnitMaster::orderBy('id','asc')->get();
    }
    public function store()
    {
        Nonsor::create($this->formData);
        $this->reset();
        $this->emit('openEntryForm');
        $this->notification()->success(
            $description = 'New Non Schedule Rate Item Created'
        );
    }
    /*public function updated($field)
    {
        if ($field === $this->formData['qty']  || $field === $this->formData['price']) {
            $this->calculateTotal();
        }
    }

    public function calculateTotal()
    {
        $this->formData['total_amount'] = $this->formData['qty'] * $this->formData['price'];
    }*/
    public function updateTotalAmount($amount)
    {
        dd($this->formData['total_amount']);
    }
    public function render()
    {
        return view('livewire.non-schedule.create');
    }
}
