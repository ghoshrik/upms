<?php

namespace App\Http\Livewire\DepartmentCategory;

use Livewire\Component;
use WireUi\Traits\Actions;
use App\Models\SorCategoryType;
use App\Models\VolumeMaster;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    use Actions;
    public $dept_category_name, $volumeNo = [], $totalSorPage,$selectedIdForEdit,$editListData=[];
    protected $rules = [
        'dept_category_name' => 'required|string|max:255',
        'totalSorPage'=>'integer|required'
    ];
    protected $messages = [
        'dept_category_name.required' => 'This field is required',
        'dept_category_name.string' => 'This field is must be string',
        'totalSorPage.required'=>'This field is required',
        'totalSorPage.integer'=>'Data Mismatch'
    ];
    public function updated($param)
    {
        $this->validateOnly($param);
    }
    public function mount()
    {
        // $this->volumeNo = VolumeMaster::select('id', 'volume_name')->get();
        if(!empty($this->selectedIdForEdit))
        {

            $this->editListData = SorCategoryType::where('id',$this->selectedIdForEdit)->first();
            $this->dept_category_name = $this->editListData->dept_category_name;
            $this->totalSorPage = $this->editListData->target_pages;
        }
        // dd($this->selectedIdForEdit,$this->editListData->dept_category_name);
    }
    public function store()
    {
        $validateData = $this->validate();
        try {
            if($this->selectedIdForEdit)
            {
                $category = SorCategoryType::findOrFail($this->selectedIdForEdit);
                $category->update([
                    'dept_category_name' => $this->dept_category_name,
                    'target_pages'=>$this->totalSorPage
                ]);
            $this->notification()->success(
                $title = 'Department category updated'
            );
            }
            else
            {

                SorCategoryType::create([
                    'department_id' => Auth::user()->department_id,
                    'dept_category_name' => $this->dept_category_name
                ]);
                $this->notification()->success(
                    $title = 'Department category created'
                );
            }
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
        return view('livewire.department-category.create', compact('assets'));
    }
}
