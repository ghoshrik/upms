<?php

namespace App\Http\Livewire\Estimate;

use App\Models\Department;
use App\Models\SOR;
use App\Models\SORCategory;
use App\Models\SorCategoryType;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CreateEstimate extends Component
{
    public $estimateData = [], $getCategory = [], $categoriesList = '';
    public $fatchDropdownData = [];
    public $kword = null;
    public function changeCategory($value)
    {
        $value = $value['_x_bindings']['value'];
        $this->estimateData['item_name'] = $value;
        if ($this->estimateData['item_name'] == 'SOR') {
            $this->fatchDropdownData['departments'] = Department::select('id', 'department_name')->get();
            $this->estimateData['dept_id'] = null;
            $this->estimateData['dept_category_id'] = null;
            $this->estimateData['version'] = null;
            $this->estimateData['item_number'] = null;
            $this->estimateData['description'] = null;
            $this->estimateData['qty'] = null;
            $this->estimateData['rate'] = null;
            $this->estimateData['total_amount'] = null;
        }
    }

    public function getDeptCategory()
    {
        $this->fatchDropdownData['departmentsCategory'] = SorCategoryType::select('id', 'dept_category_name')->where('department_id', '=', $this->estimateData['dept_id'])->get();
    }

    public function getVersion()
    {
        $this->fatchDropdownData['versions'] = SOR::select('version')->where('department_id', $this->estimateData['dept_id'])
            ->where('dept_category_id', $this->estimateData['dept_category_id'])->groupBy('version')
            ->get();
    }

    public function autoSearch($keyword)
    {
        $keyword = $keyword['_x_bindings']['value'];
        $this->kword = $keyword;
        $this->fatchDropdownData['items_number'] = SOR::where('department_id', $this->estimateData['dept_id'])
            ->where('dept_category_id', $this->estimateData['dept_category_id'])
            ->where('version', $this->estimateData['version'])
            ->where('Item_details', 'like', '%' . $keyword . '%')->get();
    }

    public function getItemDetails()
    {
        // dd($this->fatchDropdownData);
        $selectedKey =  $this->estimateData['item_number'];
        $this->estimateData['description'] = $this->fatchDropdownData['items_number'][$selectedKey]['description'];
        $this->estimateData['qty'] = $this->fatchDropdownData['items_number'][$selectedKey]['unit'];
        $this->estimateData['rate'] = $this->fatchDropdownData['items_number'][$selectedKey]['cost'];
        $this->estimateData['item_number'] = $this->fatchDropdownData['items_number'][$selectedKey]['id'];
        $this->calculateValue();
    }

    public function calculateValue()
    {
        if (floatval($this->estimateData['qty']) >= 0 && floatval($this->estimateData['rate']) >= 0) {
            $this->estimateData['total_amount'] = floatval($this->estimateData['qty']) * floatval($this->estimateData['rate']);
        }
    }

    public function render()
    {
        $this->getCategory = SORCategory::select('item_name', 'id')->get();

        return view('livewire.estimate.create-estimate');
    }
}
