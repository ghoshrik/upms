<?php

namespace App\Http\Livewire\Designation;

use Livewire\Component;
use App\Http\Requests\Designation;
use App\Models\Designation as ModelsDesignation;
use Illuminate\Http\Request;
use WireUi\Traits\Actions;


abstract class CreateDesignation extends Component
{
    use Actions;

    public $designation_name;
    protected $rules = [
        'designation_name' => 'required|string|unique:designations,designation_name|max:255',
    ];
    protected $messages =
    [
        'designation_name.required'=>'this field is required',
        'designation_name.string'=>'this field must be string',
    ];

    abstract public function query();
    public function mount()
    {
        $this->showDropdown = false;
        $this->results = collect();
    }

    //testing

    public function updatedSelected()
    {
        $this->emitSelf('valueSelected', $this->selected);
    }

    public function updatedSearch()
    {
        if (strlen($this->search) < 2) {
            $this->results = collect();
            $this->showDropdown = false;
            return;
        }

        if ($this->query()) {
            $this->results = $this->query()->get();
        } else {
            $this->results = collect();
        }

        $this->selected = '';
        $this->showDropdown = true;
    }


    //testing






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
            $this->notification()->success(
                $title = 'Designation Created Successfully'
            );

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
