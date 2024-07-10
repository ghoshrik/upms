<?php

namespace App\Http\Livewire\Designation;

use App\Models\Role;
use App\Models\Levels;
use Livewire\Component;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\Auth;
use App\Models\Designation as ModelsDesignation;

class CreateDesignation extends Component
{
    use Actions;

    public $designation_name, $dropdownData=[],$level_no ,$updatedDataTableTracker;
    protected $rules = [
        'designation_name' => 'required|string|unique:designations,designation_name|max:255',
        'level_no' => 'required'
    ];
    protected $messages =
    [
        'designation_name.required' => 'This field is required',
        'designation_name.string' => 'This field must be string',
        'designation_name.unique' => 'This designation name already exists',
        'designation_name.max' => 'Not allow',
        'level_no.required' => 'This field is required'
    ];
    public function mount(){
        $userRole = Auth::user()->roles->first();
        $childRoles = Role::where('role_parent',$userRole->id)->get();
        // dd($childRoles);
        // $childRoles = $userRole->parentRole;
        // dd($childRoles);
        foreach ($childRoles as $key => $data) {
            if ($key != 0) {
                // Compare current item with the previous item
                if ($childRoles[$key - 1]->has_level_no != $data->has_level_no) {
                    $this->dropdownData['levels'][] = Levels::where('id', $data->has_level_no)->first();
                }
            } else {
                // Add the first item unconditionally (optional, depending on your needs)
                $this->dropdownData['levels'][] = Levels::where('id', $data->has_level_no)->first();
            }
        }
    }
    public function updated($param)
    {
        $this->validateOnly($param);
    }
    public function store()
    {
        $validatedData = $this->validate();
        try {
            ModelsDesignation::create($validatedData);
            $this->reset();
            $this->notification()->success(
                $title = 'Designation Created Successfully'
            );
            $this->updatedDataTableTracker = rand(1,1000);
            $this->emit('openEntryForm');
            $this->reset();
        } catch (\Throwable $th) {
            $this->emit('showError', $th->getMessage());
        }
    }
    public function render()
    {
        $assets = ['chart', 'animation'];
        return view('livewire.designation.create-designation', compact('assets'));
    }
}
