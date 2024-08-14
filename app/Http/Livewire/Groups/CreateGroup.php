<?php

namespace App\Http\Livewire\Groups;

use App\Models\Group;
use Livewire\Component;
use App\Models\Department;
use WireUi\Traits\Actions;
use App\Models\DepartmentCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class CreateGroup extends Component
{
    use Actions;
    public $fetchDropdownData = [];
    public $department_id, $dept_category_id, $group_name;

    protected $rules = [
        'department_id' => 'required',
        'dept_category_id' => 'required',
        'group_name' => 'required',
    ];
    protected $messages = [
        'department_id.required' => 'Field is Required',
        'dept_category_id.required' => 'Field is Required',
        'group_name.required' => 'Field is Required',
    ];
    public function mount()
    {
        $allDept = Cache::get('allDept');
        if ($allDept != '') {
            $this->fetchDropdownData['departments'] = $allDept;
        } else {
            $this->fetchDropdownData['departments'] = Cache::remember('allDept', now()->addMinutes(720), function () {
                return Department::select('id', 'department_name')->get();
            });
        }
    }
    public function getDeptCategory()
    {
        $cacheKey = 'dept_cat' . '_' . $this->department_id;
        $cacheHasDeptCat = Cache::get($cacheKey);
        if ($cacheHasDeptCat != '') {
            $this->fetchDropdownData['departmentsCategory'] = $cacheHasDeptCat;
        } else {
            $this->fetchDropdownData['departmentsCategory'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
                return DepartmentCategory::select('id', 'dept_category_name')->where('department_id', '=', $this->department_id)->get();
            });
        }
    }
    public function storeGroup()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            Group::create([
                'department_id'=> $this->department_id,
                'dept_category_id'=> $this->dept_category_id,
                'group_name' => $this->group_name
            ]);
            DB::commit();
            $this->notification()->success(
                $title = "Created successfully"
            );
            $this->reset();
            $this->emit('openEntryForm');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->notification()->error(
                $title = "Failed to create records",
                // $description = $e->getMessage()
            );
            $this->emit('showError',"Failed to create records");
        }
    }
    public function render()
    {
        return view('livewire.groups.create-group');
    }
}
