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
    public $selectedIdForEdit;
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

    public function mount($selectedIdForEdit = null)
    {
        if ($selectedIdForEdit) {
            $this->selectedIdForEdit = $selectedIdForEdit;
            $group = Group::find($selectedIdForEdit);
            if ($group) {
                $this->department_id = $group->department_id;
                $this->dept_category_id = $group->dept_category_id;
                $this->group_name = $group->group_name;
    
                // Preload department categories for the selected department
                $this->getDeptCategory();
            }
        }
    
        $this->fetchDropdownData['departments'] = Cache::remember('allDept', now()->addMinutes(720), function () {
            return Department::select('id', 'department_name')->get();
        });
    }
    

    public function getDeptCategory()
    {
        $cacheKey = 'dept_cat' . '_' . $this->department_id;
        $this->fetchDropdownData['departmentsCategory'] = Cache::remember($cacheKey, now()->addMinutes(720), function () {
            $categories = DepartmentCategory::select('id', 'dept_category_name')
                ->where('department_id', '=', $this->department_id)
                ->get();
    
            
            if ($categories->isEmpty()) {
                logger('No categories found for department ID: ' . $this->department_id);
            } else {
                logger('Categories found: ' . $categories->count());
            }
    
            return $categories;
        });
    }

    public function storeGroup()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            if ($this->selectedIdForEdit) {
                $group = Group::find($this->selectedIdForEdit);
                $group->update([
                    'department_id' => $this->department_id,
                    'dept_category_id' => $this->dept_category_id,
                    'group_name' => $this->group_name
                ]);
                $this->notification()->success("Updated successfully");
            } else {
                Group::create([
                    'department_id' => $this->department_id,
                    'dept_category_id' => $this->dept_category_id,
                    'group_name' => $this->group_name
                ]);
                $this->notification()->success("Created successfully");
            }
            DB::commit();
            $this->reset();
            $this->emit('openEntryForm');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->notification()->error("Failed to save record");
            $this->emit('showError', "Failed to save record");
        }
    }

    public function render()
    {
        return view('livewire.groups.create-group');
    }

}