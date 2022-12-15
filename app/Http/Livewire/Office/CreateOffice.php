<?php

namespace App\Http\Livewire\Office;

use App\Models\District;
use App\Models\GP;
use App\Models\Office;
use App\Models\Role;
use App\Models\Taluka;
use App\Models\Urban_body;
use App\Models\Urban_body_Name;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class CreateOffice extends Component
{
    use Actions;
    public $fetchDropdownData = [], $officeData = [];
    public $selectedOption;
    public function mount()
    {
        $this->selectedOption = [
            'dist_code' => '',
            'In_area' => '',
            'rural_block_code' => '',
            'gp_code' => '',
            'urban_code' => '',
            'ward_code' => ''
        ];
        $this->officeData = [
            'office_address' => '',
            'office_name' => '',
            'department_id'=> Auth::user()->department_id
        ];
    }

    protected $rules = [
        'office_address'=>'required|string|max:255',
        'office_name'=>'required|string|regex:/(^([a-zA-Z]+)(\d+)?$)/u',
        'department_id'=>'required|integer'
    ];
    protected $message = [
        'office_address.required'=>'This field is required',
        'office_address.string'=>'This is not valid input',
        'office_name.required'=>'This field is required',
        'office_name.integer'=>'invalid Format'
    ];
    public function areaChangeEvent()
    {
        if ($this->selectedOption['In_area'] == 1) {
            $this->fetchDropdownData['rural_block'] = Taluka::select('block_code', 'block_name')->where('district_code', $this->selectedOption['dist_code'])->get();
            return;
        }
        if ($this->selectedOption['In_area'] == 2) {
            $this->fetchDropdownData['urban_body'] = Urban_body::select('urban_body_code', 'urban_body_name')->where('district_code', $this->selectedOption['dist_code'])->get();
            return;
        }
    }
    public function changeRuralBlock()
    {
        $this->fetchDropdownData['rural_gp'] = GP::select("gram_panchyat_code", "gram_panchyat_name")->where("block_code", $this->selectedOption['rural_block_code'])->get();
    }
    public function changeUrbanBody()
    {
        $this->fetchDropdownData['urban_word'] = Urban_body_Name::select("urban_body_ward_code", "urban_body_ward_name")->where('urban_body_code', $this->selectedOption['urban_code'])->get();
    }
    public function store()
    {
        // $validateData = $this->validate();

        try {
            $insert = array_merge($this->selectedOption, $this->officeData);
            // dd($insert);
            Office::create($insert);
            $this->notification()->success(
                $title = 'Office Created Successfully!!'
            );
            $this->reset();
            $this->emit('openForm');

        } catch (\Throwable $th) {
            $this->emit('showError', $th->getMessage());
        }
    }
    public function render()
    {
        $this->fetchDropdownData['district'] = District::all();
        return view('livewire.office.create-office');
    }
}
