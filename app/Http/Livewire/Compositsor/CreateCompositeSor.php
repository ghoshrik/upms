<?php

namespace App\Http\Livewire\Compositsor;
use App\Models\SOR;
use Livewire\Component;
use App\Models\UnitMaster;
use WireUi\Traits\Actions;
use App\Models\ComposerSor;
use App\Models\CompositSor;
use Livewire\WithFileUploads;
use App\Models\SorCategoryType;
use App\Models\DynamicSorHeader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CreateCompositeSor extends Component
{
    use Actions, WithFileUploads;
    public $fetchDropDownData = [],$storeItem = [],$viewModal = false;

    public function mount() {
        $this->fetchDropDownData['departmentCategory'] = SorCategoryType::where('department_id', Auth::user()->department_id)->get();
        $this->fetchDropDownData['tables'] = [];
        $this->fetchDropDownData['pages'] = [];
        $this->storeItem['dept_category_id'] = '';
        $this->storeItem['table_no'] = '';
        $this->storeItem['page_no'] = '';
        $this->storeItem['item_no'] = '';
    }

    public function getDeptCategorySORItem()
    {
        $this->fetchDropDownData['tables'] = DynamicSorHeader::select('table_no','dept_category_id')->where('dept_category_id',$this->storeItem['dept_category_id'])->get();
    }

    public function getPageNo()
    {
        $this->fetchDropDownData['pages'] = DynamicSorHeader::select('dept_category_id','page_no', 'table_no')->where([['dept_category_id',$this->storeItem['dept_category_id']],['table_no', $this->storeItem['table_no']]])->get();
        $this->viewModal = false;
        $this->fetchDropDownData['page_no'] = '';

    }

    public function getDynamicSor()
    {
        $this->fetchDropDownData['getSor'] = [];
        $this->fetchDropDownData['getSor'] = DynamicSorHeader::where([['dept_category_id',$this->storeItem['dept_category_id']],['page_no', $this->storeItem['page_no'], ['table_no', $this->storeItem['table_no']]]])->first();
        if ($this->fetchDropDownData['getSor'] != null) {
            $this->viewModal = !$this->viewModal;
            $this->modalName = "dynamic-sor-modal_" . rand(1, 1000);
            $this->modalName = str_replace(' ', '_', $this->modalName);
        }
    }
    public function render()
    {
        return view('livewire.compositsor.create-composite-sor');
    }
}
