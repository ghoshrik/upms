<?php

namespace App\Http\Livewire\NonSchedule;

use App\Models\Nonsor;
use App\Models\UnitMaster;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class Create extends Component
{
    use Actions;
    public $units=[];
    protected $listeners = ['storeNonSchedule' => 'storeData'];
    public function mount()
    {
        $this->units = UnitMaster::orderBy('id','asc')->get();
    }

    public function storeData($value)
    {
//        dd($value);
        Nonsor::create([
            'item_name'=> $value['Desc'],
            'unit_id'=>$value['unit'],
            'price'=>$value['rate'],
            'created_by'=>Auth::user()->id,
            'associated_at'=>Auth::user()->id,
            'associated_with'=>Carbon::now()
        ]);
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

    public function render()
    {
        return view('livewire.non-schedule.create');
    }
}
