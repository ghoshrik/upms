<?php

namespace App\Http\Livewire\Office;

use App\Models\District;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateOffice extends Component
{
    public $fatchDropdownData = [],$officeData = [];
    public $selectedOption;
    public function mount()
    {
        $this->selectedOption = [
            'district'=>'',
            'area'=>'',
            'rural_block_code'=>'',
            'gp_code'=>'',
            'urban_body_code'=>'',
            'urban_word_no'=>''
        ];
    }
    public function distChangeEvent()
    {
        $this->officeData['district_code'] = $this->selectedOption['district'];
    }
    public function areaChangeEvent()
    {
        $this->officeData['area_code'] = $this->selectedOption['area'];
    }
    public function changeRuralBlock()
    {

    }
    public function changeUrbanBody()
    {

    }
    public function render()
    {
        $this->fatchDropdownData['district'] = District::all();
        return view('livewire.office.create-office');
    }
}
