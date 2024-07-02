<?php

namespace App\Http\Livewire\AbstructCosts;

use Livewire\Component;
use App\Models\Abstracts;
use Illuminate\Support\Facades\Auth;

class CreateAbstruct extends Component
{

    protected $listeners = ['storeTheadData', 'getRowValue'];
    public $selectCategory = [], $selectDeptCategory = [];

    public function mount()
    {
        if (Auth::user()->department_id !== 26) {
            $this->selectCategory = 'Estimates Lists';
            $this->selectDeptCategory = Auth::user()->dept_category_id;
            // dd(Auth::user()->dept_category_id);
        } else {
            $this->selectCategory = 'Schedule of Rates';
            $this->selectDeptCategory = (Auth::user()->dept_category_id === '') ?? 0;
        }
        // $this->emit('deptCategory', Auth::user()->dept_category_id);
        //$this->emit('selectCategory', $this->selectCategory);
    }
    public function storeTheadData($value)
    {
        // dd($value);
        Abstracts::create(
            [
                'tableHeader' => $value['jsonData1'],
                'tableData' => $value['jsonData'],
                'project_desc' => $value['projectDesc'],
                'category_id' => Auth::user()->dept_category_id,
                'department_id' => Auth::user()->department_id,
                'total_amount' => $value['totalAmount'],
                'created_by' => Auth::user()->id
            ]
        );
        $this->reset();
        $this->emit('openEntryForm');
    }
    public function render()
    {
        return view('livewire.abstruct-costs.create-abstruct');
    }
}
