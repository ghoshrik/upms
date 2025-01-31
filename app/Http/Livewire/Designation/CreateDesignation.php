<?php

namespace App\Http\Livewire\Designation;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\Designation as ModelsDesignation;

class CreateDesignation extends Component
{
    use Actions;

    public $designation_name ,$updatedDataTableTracker;
    protected $rules = [
        'designation_name' => 'required|string|unique:designations,designation_name|max:255',
    ];
    protected $messages =
    [
        'designation_name.required' => 'This field is required',
        'designation_name.string' => 'This field must be string',
        'designation_name.unique' => 'This designation name already exists',
        'designation_name.max' => 'Not allow'
    ];

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
