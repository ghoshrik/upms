<?php

namespace App\Http\Livewire\Compositsor;

use Livewire\Component;
use App\Models\UnitMaster;
use WireUi\Traits\Actions;
use App\Models\DepartmentCategories;
use App\Models\DynamicSorHeader;
use Illuminate\Support\Facades\Session;

class Create extends Component
{
    use Actions;
    protected $listeners = ['getRowValue', 'closeModal'];
    public $fetchDropDownData = [], $storeItem = [], $inputsData = [], $viewModal = false, $table_no, $page_no, $modalName, $counterForItemNo = 0, $sorType;
    public function mount()
    {
        $this->fetchDropDownData['departmentCategory'] = DepartmentCategories::where('department_id', Session::get('user_data.department_id'))->get();
        $this->fetchDropDownData['tables'] = [];
        $this->fetchDropDownData['pages'] = [];
        $this->storeItem['dept_category_id'] = '';
        $this->storeItem['table_no'] = '';
        $this->storeItem['page_no'] = '';
        $this->storeItem['item_no'] = '';
        $this->storeItem['parent_id'] = '';
        $this->fetchDropDownData['types'] = [
            [
                'id' => 0,
                'name' => 'Table',
            ],
            [
                'id' => 1,
                'name' => 'Row',
            ],
            [
                'id' => 2,
                'name' => 'Other',
            ],
        ];
    }
    public function getDeptCategoryTable()
    {
        $this->storeItem['table_no'] = '';
        $this->storeItem['page_no'] = '';
        $this->storeItem['item_no'] = '';
        $sessionKey = 'dept_cat_table_' . $this->storeItem['dept_category_id'];
        $getSessionTables = Session::get($sessionKey);
        if ($getSessionTables != '') {
            $this->fetchDropDownData['tables'] = $getSessionTables;
        } else {
            $this->fetchDropDownData['tables'] = DynamicSorHeader::where('dept_category_id', $this->storeItem['dept_category_id'])->select('table_no')->groupBy('table_no')->get();
            Session()->put($sessionKey, $this->fetchDropDownData['tables']);
        }
    }
    public function getPageNoTableWise()
    {
        $this->fetchDropDownData['pages'] = [];
        $sessionKey = 'table_wise_page_' . $this->storeItem['table_no'];
        $getSessionData = Session::get($sessionKey);
        if ($getSessionData != '') {
            $this->fetchDropDownData['pages'] = $getSessionData;
        } else {
            $this->fetchDropDownData['pages'] = DynamicSorHeader::where('table_no', $this->storeItem['table_no'])->select('id', 'page_no', 'corrigenda_name')->get();
        }
        $this->viewModal = false;
        $this->storeItem['page_no'] = '';
    }
    public function getChildPageNo($key)
    {
        $this->fetchDropDownData[$key]['child_pages'] = [];
        $sessionKey = 'table_wise_page_' . $this->inputsData[$key]['table_no'];
        $getSessionData = Session::get($sessionKey);
        if ($getSessionData != '') {
            $this->fetchDropDownData[$key]['child_pages'] = $getSessionData;
        } else {
            $this->fetchDropDownData[$key]['child_pages'] = DynamicSorHeader::where('table_no', $this->inputsData[$key]['table_no'])->select('id', 'page_no', 'corrigenda_name')->get();
        }
        $this->viewModal = false;
        $this->inputsData[$key]['page_no'] = '';
    }
    public function getDynamicSor($type)
    {
        if ($type == 'parent') {
            $this->storeItem['item_no'] = '';
            $this->fetchDropDownData['getSor'] = [];
            $this->fetchDropDownData['getSor'] = DynamicSorHeader::where('id', $this->storeItem['page_no'])->first();
        } else {
            $this->fetchDropDownData['getSor'] = [];
            $this->fetchDropDownData['getSor'] = DynamicSorHeader::where('id', $this->inputsData[$type]['page_no'])->first();
            $this->sorType = $type;
        }
        if ($type != 'parent' && $this->inputsData[$type]['table'] == 0) {
            // dd($this->fetchDropDownData['getSor']);
            $this->table_no = $this->fetchDropDownData['getSor']['table_no'];
            $this->inputsData[$type]['description'] = $this->fetchDropDownData['getSor']['title'];
            $this->page_no = $this->fetchDropDownData['getSor']['page_no'];
            $this->inputsData[$type]['sor_id'] = (int) $this->inputsData[$type]['page_no'];
        } else {
            if ($this->fetchDropDownData['getSor'] != null) {
                $this->table_no = $this->fetchDropDownData['getSor']['table_no'];
                $this->page_no = $this->fetchDropDownData['getSor']['page_no'];
                $this->viewModal = !$this->viewModal;
                $this->modalName = "dynamic-sor-modal_" . rand(1, 1000);
                $this->modalName = str_replace(' ', '_', $this->modalName);
            }
        }
    }
    public function getRowValue($data)
    {
        // dd($data);
        $this->reset('counterForItemNo');
        $itemNo = '';
        $fetchRow[] = [];
        if ($this->storeItem['item_no'] == '') {
            // dd("yes");
            if (isset($data[0]['itemNo'])) {
                $this->storeItem['item_no'] = $data[0]['itemNo'];
            }
            $this->storeItem['parent_id'] = $this->fetchDropDownData['getSor']['id'];
            $this->storeItem['sor_itemno_parent_index'] = $data[0]['id'];
            $rowId = explode('.', $data[0]['id'])[0];
            foreach (json_decode($this->fetchDropDownData['getSor']['row_data']) as $row) {
                if ($row->id == $rowId) {
                    $fetchRow = $row;
                }
            }
            $selectedItemId = $data[0]['id'];
            // ---------explode the id------
            $hierarchicalArray = explode(".", $selectedItemId);
            $convertedArray = [];
            $partialItemId = "";
            foreach ($hierarchicalArray as $part) {
                if ($partialItemId !== "") {
                    $partialItemId .= ".";
                }
                $partialItemId .= $part;
                $convertedArray[] = $partialItemId;
            }
            // dd($convertedArray);
            $this->extractItemNoOfItems($fetchRow, $itemNo, $convertedArray, $this->counterForItemNo);
            // if (count($convertedArray) > count($convertedArray)-1) {
            //     $itemNo .= $this->storeItem['item_no'];
            // }
            $this->storeItem['item_no'] = $itemNo;
            $this->storeItem['col_position'] = $data[0]['colPosition'];
        } else {
            if (isset($data[0]['itemNo'])) {
                $this->inputsData[$this->sorType]['item_no'] = $data[0]['itemNo'];
            }
            $this->inputsData[$this->sorType]['child_index_id'] = $data[0]['id'];

            $rowId = explode('.', $data[0]['id'])[0];
            foreach (json_decode($this->fetchDropDownData['getSor']['row_data']) as $row) {
                if ($row->id == $rowId) {
                    $fetchRow = $row;
                }
            }
            $selectedItemId = $data[0]['id'];
            // ---------explode the id------
            $hierarchicalArray = explode(".", $selectedItemId);
            $convertedArray = [];
            $partialItemId = "";
            foreach ($hierarchicalArray as $part) {
                if ($partialItemId !== "") {
                    $partialItemId .= ".";
                }
                $partialItemId .= $part;
                $convertedArray[] = $partialItemId;
            }
            // dd($convertedArray);
            $this->extractItemNoOfItems($fetchRow, $itemNo, $convertedArray, $this->counterForItemNo);
            // $itemNo .= $this->inputsData[$this->sorType]['item_no'];
            $this->inputsData[$this->sorType]['item_no'] = $itemNo;
            $this->inputsData[$this->sorType]['description'] = $data[0]['desc'];
            $this->inputsData[$this->sorType]['sor_id'] = $this->fetchDropDownData['getSor']['id'];
        }
        if ($this->storeItem['item_no'] != '') {
            if (count($this->inputsData) < 1) {
                $this->getChildRow(count($this->inputsData));
            }
            // $this->fetchDropDownData['child_tables'] = DynamicSorHeader::where('dept_category_id', $this->storeItem['dept_category_id'])->select('table_no')->groupBy('table_no')->get();
            $this->fetchDropDownData['unitMaster'] = UnitMaster::select('id', 'unit_name', 'short_name', 'is_active')->where('is_active', 1)->orderBy('id', 'desc')->get();
        }
        $this->viewModal = !$this->viewModal;
    }
    public function extractItemNoOfItems($data, &$itemNo, $counter, $position)
    {
        $position++;
        $this->counterForItemNo = $position;
        if (count($counter) > 1) {
            if (isset($data->item_no) && $data->item_no != '') {
                $itemNo = $data->item_no . ' ';
            }
            if (isset($data->_subrow)) {
                foreach ($data->_subrow as $key => $item) {
                    if (isset($counter[$position])) {
                        if (isset($item->item_no) && $item->id == $counter[$position]) {
                            $itemNo .= $item->item_no . ' ';
                        }
                        if (isset($item->_subrow)) {
                            $this->extractItemNoOfItems($item->_subrow, $itemNo, $counter, $position);
                        }
                    }
                }
            } else {
                // dd($data);
                if (count($data) > 0) {
                    foreach ($data as $key => $item) {
                        if (isset($counter[$position]) && isset($item->_subrow)) {
                            if (isset($item->item_no) && $item->id == $counter[$position]) {
                                $itemNo .= $item->item_no . ' ';
                            }
                            if (isset($item->_subrow)) {
                                $this->extractItemNoOfItems($item->_subrow, $itemNo, $counter, $position);
                            }
                        } else {
                            if (isset($counter[$position])) {
                                if (isset($item->item_no) && $item->id == $counter[$position]) {
                                    $itemNo .= $item->item_no . ' ';
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $itemNo = $data->item_no;
        }
    }
    public function extractDescOfItems($data, &$descriptions, $counter)
    {
        if (isset($data->desc_of_item) && $data->desc_of_item != '') {
            $descriptions .= $data->desc_of_item . ' ';
        }
        if (isset($data->_subrow) && count($counter) > 2) {
            foreach ($data->_subrow as $item) {
                if (isset($item->desc_of_item)) {
                    $descriptions .= $item->desc_of_item . ' ';
                }
                if (!empty($item->_subrow)) {
                    $this->extractDescOfItems($item->_subrow, $descriptions, $counter);
                }
            }
        }
    }
    public function getChildRow($key)
    {
        $this->inputsData[$key] =
            [
            'table_no' => '',
            'page_no' => '',
            'child_index_id' => '',
            'item_no' => '',
            'description' => '',
            'qty' => '',
            'unit_id' => '',
            'table' => '',
        ];
        $this->fetchDropDownData[$key]['child_pages'] = [];
    }
    public function getCategory($key)
    {
        $this->inputsData[$key]['table'] = (int) $this->inputsData[$key]['table'];
    }
    public function addNewRow()
    {
        // dd($this->inputsData);
        $this->inputsData[] = [
            'table_no' => '',
            'page_no' => '',
            'child_index_id' => '',
            'item_no' => '',
            'description' => '',
            'qty' => '',
            'unit_id' => '',
            'table' => '',
        ];
    }
    public function closeModal()
    {
        $this->viewModal = !$this->viewModal;
        if ($this->storeItem['item_no'] == '') {
            $this->storeItem['page_no'] = '';
        }
    }
    public function render()
    {
        return view('livewire.compositsor.create');
    }
}
