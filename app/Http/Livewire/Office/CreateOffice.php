<?php

namespace App\Http\Livewire\Office;

use App\Models\GP;
use App\Models\Role;
use App\Models\Office;
use App\Models\Taluka;
use Livewire\Component;
use App\Models\District;
use App\Models\Urban_body;
use WireUi\Traits\Actions;
use Illuminate\Support\Arr;
use App\Models\Urban_body_Name;
use Illuminate\Support\Facades\Auth;

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
        'officeData.office_address'=>'required|string|max:255',
        'officeData.office_name'=>'required|string',
        'selectedOption.dist_code'=>'required|integer',
        'selectedOption.In_area'=>'required|integer',
    ];
    protected $messages = [
        'officeData.office_address.required'=>'This field is required',
        'officeData.office_address.string'=>'This is not valid input',
        'officeData.office_name.required'=>'This field is required',
        'officeData.office_name.string'=>'invalid Format',
        'selectedOption.dist_code.required'=>'This field is required',
        'selectedOption.dist_code.integer'=>'Invalid field',
        'selectedOption.In_area.required'=>'This field is required',
        'selectedOption.In_area.required'=>'Invalid format',
        "selectedOption.gp_code.required"=>"This field is required",
        'selectedOption.rural_block_code.required'=>'This field is required',
        'selectedOption.rural_block_code.integer'=>'Invalid format',
        'selectedOption.urban_code.required'=>'This field is required',
        'selectedOption.ward_code.integer'=>'Invalid format'
    ];
    public function updated($param)
    {
        $this->validateOnly($param);
    }
    public function booted()
    {
        if ($this->selectedOption['In_area'] == 1)
        {
            $this->rules =  Arr::collapse([$this->rules, [
                'selectedOption.rural_block_code' =>'required|integer',
                'selectedOption.gp_code' =>'required|integer'
            ]]);
        }
        if ($this->selectedOption['In_area'] == 2)
        {
            $this->rules =  Arr::collapse([$this->rules, [
                'selectedOption.urban_code'=>'required|integer',
                'selectedOption.ward_code'=>'required|integer',
            ]]);
        }

    }
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
        $this->validate();
        // dd($this->selectedOption,$this->officeData);
        try {
            $insert = array_merge($this->selectedOption, $this->officeData);
            // dd($insert);
            Office::create($insert);
            // $insert = [
            //     'In_area'=>$this->selectedOption['In_area'],
            //     'department_id'=>$this->officeData['department_id'],
            //     'office_name'=>$this->officeData['office_name'],
            //     'office_address'=>$this->officeData['office_address'],
            //     'dist_code'=>$this->selectedOption['dist_code'],
            //     'rural_block_code'=>$this->selectedOption['dist_code'],
            //     'gp_code'=>$this->selectedOption['dist_code'],
            //     'urban_code'=>$this->selectedOption['urban_code'],
            //     'ward_code'=>$this->selectedOption['ward_code']
            // ];
            // Office::create($insert);
            // dd($insert);
            $this->notification()->success(
                $title = 'Office Created Successfully!!'
            );
            // $this->reset();
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
