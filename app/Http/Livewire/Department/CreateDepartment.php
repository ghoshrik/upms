<?php

namespace App\Http\Livewire\Department;

use App\Models\Department;
use Livewire\Component;
use WireUi\Traits\Actions;

class CreateDepartment extends Component
{
    use Actions;
    public $department_name;
    protected $rules = [
        'department_name' => 'required|string'
    ];
    protected $messages = [
        'department_name.required' => 'This Field is Required',
        'department_name.string' => 'Invalid Input'
    ];
    public function updated($param)
    {
        $this->validateOnly($param);
    }
    public function store()
    {
        $validateData = $this->validate();
        try{
            Department::create($validateData,['department_name' => $this->department_name]);
                $this->notification()->success(
                    $title = trans('cruds.department.create_msg')
                );
            $this->reset();
            $this->emit('openEntryForm');

        }catch (\Throwable $th) {
            $this->emit('showError', $th->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.department.create-department');
    }
}
