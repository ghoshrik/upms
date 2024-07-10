<?php

namespace App\Http\Livewire\Office;

use App\Models\GP;
use App\Models\Role;
use App\Models\Levels;
use App\Models\Office;
use App\Models\Taluka;
use Livewire\Component;
use App\Models\District;
use App\Models\Department;
use App\Models\Urban_body;
use WireUi\Traits\Actions;
use Illuminate\Support\Arr;
use App\Models\Urban_body_Name;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
            'ward_code' => '',
            'level' => '',
        ];
        $this->officeData = [
            'office_address' => '',
            'office_name' => '',
            'office_code' => '',
            'department_id' => (Auth::user()->department_id != 0) ? Auth::user()->department_id : '',
        ];
        $userRole = Auth::user()->roles->first();
        // $childRoles = $userRole->childRoles;
        $childRoles = Role::where('role_parent',$userRole->id)->get();
        foreach ($childRoles as $key => $data) {
            if ($key != 0) {
                // Compare current item with the previous item
                if ($childRoles[$key - 1]->has_level_no != $data->has_level_no) {
                    $this->fetchDropdownData['levels'][] = Levels::where('id', $data->has_level_no)->first();
                }
            } else {
                // Add the first item unconditionally (optional, depending on your needs)
                $this->fetchDropdownData['levels'][] = Levels::where('id', $data->has_level_no)->first();
            }
        }
        if (Auth::user()->user_type == 2) {
            $allDept = Cache::get('allDept');
            if ($allDept != '') {
                $this->fetchDropdownData['departments'] = $allDept;
            } else {
                $this->fetchDropdownData['departments'] = Cache::remember('allDept', now()->addMinutes(720), function () {
                    return Department::select('id', 'department_name')->get();
                });
            }
            // $this->fetchDropdownData['levels'] = [
            //     ['name' => 'L1 Level', 'id' => 1]
            // ];
        }
        $this->fetchDropdownData['district'] = District::all();
    }

    protected $rules = [
        'officeData.office_address' => 'required|string|max:255',
        'officeData.office_name' => 'required|string',
        'officeData.office_code' => 'required|string|unique:offices,office_code',
        'selectedOption.dist_code' => 'required|integer',
        'selectedOption.In_area' => 'required|integer',
        'selectedOption.level' => 'required|integer',
    ];
    protected $messages = [
        'officeData.office_address.required' => 'This field is required',
        'officeData.office_address.string' => 'This is not valid input',
        'officeData.office_name.required' => 'This field is required',
        'officeData.office_code.string' => 'invalid Format',
        'officeData.office_code.required' => 'This field is required',
        'officeData.office_code.unique' => 'Already exists office',
        'officeData.office_name.string' => 'invalid Format',
        'selectedOption.dist_code.required' => 'This field is required',
        'selectedOption.dist_code.integer' => 'Invalid field',
        'selectedOption.In_area.required' => 'This field is required',
        'selectedOption.In_area.required' => 'Invalid format',
        "selectedOption.gp_code.required" => "This field is required",
        'selectedOption.rural_block_code.required' => 'This field is required',
        'selectedOption.rural_block_code.integer' => 'Invalid format',
        'selectedOption.urban_code.required' => 'This field is required',
        'selectedOption.ward_code.integer' => 'Invalid format',
        'selectedOption.level.integer' => 'Invalid format',
        'selectedOption.level.required' => 'This field is required',
    ];
    public function updated($param)
    {
        $this->validateOnly($param);
    }
    public function booted()
    {
        if ($this->selectedOption['In_area'] == 1) {
            $this->rules = Arr::collapse([$this->rules, [
                'selectedOption.rural_block_code' => 'required|integer',
                'selectedOption.gp_code' => 'required|integer',
            ]]);
        }
        if ($this->selectedOption['In_area'] == 2) {
            $this->rules = Arr::collapse([$this->rules, [
                'selectedOption.urban_code' => 'required|integer',
                'selectedOption.ward_code' => 'required|integer',
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
        try {
            $insert = array_merge($this->selectedOption, $this->officeData);
            $insert = [
                'in_area' => $this->selectedOption['In_area'],
                'department_id' => $this->officeData['department_id'],
                'office_name' => $this->officeData['office_name'],
                'office_code' => $this->officeData['office_code'],
                'office_address' => $this->officeData['office_address'],
                'dist_code' => $this->selectedOption['dist_code'],
                'rural_block_code' => ($this->selectedOption['rural_block_code'] == '') ? 0 : $this->selectedOption['dist_code'],
                'gp_code' => ($this->selectedOption['gp_code'] == '') ? 0 : $this->selectedOption['dist_code'],
                'urban_code' => ($this->selectedOption['urban_code'] == '') ? 0 : $this->selectedOption['urban_code'],
                'ward_code' => ($this->selectedOption['ward_code'] == '') ? 0 : $this->selectedOption['ward_code'],
                'level_no' => $this->selectedOption['level'],
                'office_parent' => Auth::user()->office_id,
                'created_by'=>Auth::user()->id
            ];
            // dd($insert);
            Office::create($insert);

            $this->notification()->success(
                $title = 'Office Created Successfully'
            );
            // $this->reset();
            $this->emit('openEntryForm');

        } catch (\Throwable $th) {
            $this->emit('showError', $th->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.office.create-office');
    }
}
