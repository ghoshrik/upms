<?php

namespace App\Http\Livewire\Department;

use Livewire\Component;
use App\Models\Department;
use WireUi\Traits\Actions;
use Illuminate\Support\Facades\DB;

class CreateDepartment extends Component
{
    use Actions;
    public $department_name, $department_code;
    protected $rules = [
<<<<<<< Updated upstream
        'department_name' => 'required|string|unique:departments',
        'department_code' => 'required|string|unique:departments',
=======
        'department_name' => 'required|string|unique:departments,department_name',
        'department_code' => 'required|string|unique:departments,department_code'
>>>>>>> Stashed changes
    ];
    protected $messages = [
        'department_name.required' => 'This Field is Required',
        'department_name.string' => 'Invalid Input',
        'department_name.unique' => 'Department Name Already Exists',
        'department_code.required' => 'This Field is Required',
        'department_code.string' => 'Invalid Input',
        'department_code.unique' => 'Department Code Already Exists',
    ];
    public function updated($param)
    {
        $this->validateOnly($param);
    }
    public function mount()
    {
        $this->department_name = '';
        $this->department_code = '';
    }
    public function store()
    {
        // $this->validate();
        // dd($this->department_name, $this->department_code);
        try {
            $insert = [
                'department_name' => $this->department_name,
                'department_code' => $this->department_code,
            ];
            // dd($insert);
            // if ($validateData) {
            // Department::create($insert);
            DB::table('departments')->insert($insert);
            $this->notification()->success(
                $title = trans('cruds.department.create_msg')
            );
            // }
            $this->reset();
            $this->emit('openEntryForm');
        } catch (\Throwable $th) {
            $this->emit('showError', $th->getMessage());
        }
        // $this->validate();
        // try {
        //     $words = explode(' ', $this->department_name);
        //     $initials = '';
        //     foreach ($words as $word) {
        //         $initials .= strtoupper(substr($word, 0, 1));
        //     }
        //     // dd($initials);
        //     $insert = [
        //         'department_name' => $this->department_name, 'dept_code' => $initials
        //     ];
        //     // dd($insert);

        //     Department::create($insert);
        //     $this->notification()->success(
        //         $title = trans('cruds.department.create_msg')
        //     );
        //     $this->reset();
        //     $this->emit('openEntryForm');
        // } catch (\Throwable $th) {
        //     $this->emit('showError', $th->getMessage());
        // }
    }
    public function render()
    {
        return view('livewire.department.create-department');
    }
}
