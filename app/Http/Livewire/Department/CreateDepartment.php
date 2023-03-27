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
        'department_name' => 'required|unique:departments,department_name'
    ];
    protected $messages = [
        'department_name.required' => 'This Field is Required',
        'department_name.unique' => 'The department name is already in use',
        // 'department_name.max'=>'The department maximum '
        // 'department_name.string' => 'Invalid Input'
    ];
    public function updated($param)
    {
        $this->validateOnly($param);
    }
    public function store()
    {
        $this->validate();
        try {
            $words = explode(' ', $this->department_name);
            $initials = '';
            foreach ($words as $word) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
            // dd($initials);
            $insert = [
                'department_name' => $this->department_name, 'dept_code' => $initials
            ];
            // dd($insert);

            Department::create($insert);
            $this->notification()->success(
                $title = trans('cruds.department.create_msg')
            );
            $this->reset();
            $this->emit('openEntryForm');
        } catch (\Throwable $th) {
            $this->emit('showError', $th->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.department.create-department');
    }
}
