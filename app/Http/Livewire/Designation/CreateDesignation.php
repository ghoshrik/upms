<?php

namespace App\Http\Livewire\Designation;

use Livewire\Component;
use App\Http\Requests\Designation;
use App\Models\Designation as ModelsDesignation;
use Illuminate\Http\Request;

class CreateDesignation extends Component
{
    public $designation_name;
    protected $rules = [
        'designation_name' => 'required|string|unique:designations,designation_name|max:255',
    ];
    protected $messages =
    [
        'designation_name.required'=>'this field is required',
        'designation_name.string'=>'this field must be string',
    ];
    public function store()
    {
        $validatedData = $this->validate();
        try {
            ModelsDesignation::create($validatedData);
            $this->reset();
            // $this->dispatchBrowserEvent('alert', [
            //     'type' => 'success',
            //     'message' => 'Designation Created Successfully'
            // ]);

        } catch (\Throwable $th) {
            session()->flash('serverError', $th->getMessage());
        }
    }
    public function render()
    {
        $assets = ['chart', 'animation'];
        return view('livewire.designation.create-designation',compact('assets'));
    }
}
