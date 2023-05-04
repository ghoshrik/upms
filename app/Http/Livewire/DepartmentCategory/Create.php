<?php

namespace App\Http\Livewire\DepartmentCategory;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\SorCategoryType;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    use Actions;
    public $dept_category_name;
    protected $rules = [
        'dept_category_name' => 'required|string|max:255'
    ];
    protected $messages = [
        'dept_category_name.required'=>'This field is required',
        'dept_category_name.string'=>'This field is must be string',
    ];
    public function updated($param)
    {
        $this->validateOnly($param);
    }
    public function store()
    {
        $validateData = $this->validate();
        try {
            SorCategoryType::create([
                'department_id'=> Auth::user()->department_id,
                'dept_category_name'=>$this->dept_category_name
            ]);
            $this->notification()->success(
                $title = 'Department category created'
            );
            $this->reset();
            $this->emit('openEntryForm');

        } catch (\Throwable $th) {
            $this->emit('showError', $th->getMessage());
        }
    }

    public function render()
    {
        $this->emit('changeTitel', 'Office');
        $assets = ['chart', 'animation'];
        return view('livewire.department-category.create',compact('assets'));
    }
}
