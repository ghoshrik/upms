<?php

namespace App\Http\Livewire\Compositsor;

use App\Models\CompositSor;
use App\Models\DynamicSorHeader;
use App\Models\SorCategoryType;
use App\Models\UnitMaster;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;

class CreateCompositeSor extends Component
{
    use Actions, WithFileUploads;
    protected $listeners = ['getRowValue', 'closeModal'];
    public $fetchDropDownData = [], $storeItem = [], $viewModal = false, $counterForItemNo = 0, $inputsData = [], $updateDataTableTracker;
    public $table_no = '', $page_no = '', $sorType;


    protected $rules = [
        'storeItem.dept_category_id' => 'required',
        'storeItem.table_no' => 'required',
        'storeItem.page_no' => 'required|integer',


        'inputsData.*.table_no' => 'required',
        'inputsData.*.table_' => 'required|integer',
        'inputsData.*.page_no' => 'required|integer',
        'inputsData.*.description' => 'required',
        'inputsData.*.unit_id' => 'required|integer',
        'inputsData.*.qty' => 'required',
    ];

    protected $messages = [
        'storeItem.dept_category_id.required' => 'This field is required',
        'storeItem.table_no.required' => 'This field is required',
        'storeItem.page_no.required' => 'This field is required',
        'storeItem.page_no.integer' => 'This field data mismatch',

        'inputsData.*.table_no.required' => 'This field is required',
        'inputsData.*.table_.required' => 'This field is required',
        'inputsData.*.table_.integer' => 'This field data mismatch',
        'inputsData.*.page_no.required' => 'This field is required',
        'inputsData.*.page_no.integer' => 'This field data mismatch',
        'inputsData.*.description.required' => 'This field is required',
        'inputsData.*.unit_id.required' => 'This field is required',
        'inputsData.*.unit_id.integer' => 'This field data mismatch',
        'inputsData.*.qty.required' => 'This field is required',

    ];








    public function mount()
    {
        $this->fetchDropDownData['departmentCategory'] = SorCategoryType::where('department_id', Auth::user()->department_id)->get();
        $this->fetchDropDownData['tables'] = [];
        $this->fetchDropDownData['pages'] = [];
        $this->storeItem['dept_category_id'] = '';
        $this->storeItem['table_no'] = '';
        $this->storeItem['page_no'] = '';
        $this->storeItem['item_no'] = '';
        $this->storeItem['parent_id'] = '';
        $this->inputsData = [
            [
                'table_no' => '',
                'page_no' => '',
                'child_index_id' => '',
                'item_no' => '',
                'description' => '',
                'qty' => '',
                'unit_id' => '',
                'table_' => '',
            ],
        ];
    }
    public function onTableSelect($key)
    {
        if ($this->inputsData[$key]['table_'] == 1) {
        } else {
            $this->viewModal = !$this->viewModal;
        }
    }

    public function addNewRow()
    {

        $this->inputsData[] = [
            'table_no' => '',
            'page_no' => '',
            'child_index_id' => '',
            'item_no' => '',
            'description' => '',
            'qty' => '',
            'unit_id' => '',
            'table_' => ''
        ];
        //dd($this->inputsData);
    }
    public function removeRow($index)
    {
        if (count($this->inputsData) > 1) {
            unset($this->inputsData[$index]);
            $this->inputsData = array_values($this->inputsData);
            return;
        }
    }
    public function getDeptCategorySORTables()
    {
        $this->storeItem['table_no'] = '';
        $this->storeItem['page_no'] = '';
        $this->storeItem['item_no'] = '';
        $this->fetchDropDownData['tables'] = DynamicSorHeader::where('dept_category_id', $this->storeItem['dept_category_id'])->select('table_no')->groupBy('table_no')->get();
    }

    public function getPageNo()
    {
        $this->fetchDropDownData['pages'] = [];
        $this->fetchDropDownData['pages'] = DynamicSorHeader::where([['dept_category_id', $this->storeItem['dept_category_id']], ['table_no', $this->storeItem['table_no']]])->select('id', 'page_no', 'corrigenda_name')->get();
        $this->viewModal = false;
        $this->storeItem['page_no'] = '';
    }

    public function getDynamicSor($type)
    {
        // dd($type);
        if ($type == 'parent') {
            $this->storeItem['item_no'] = '';
            $this->fetchDropDownData['getSor'] = [];
            $this->fetchDropDownData['getSor'] = DynamicSorHeader::where('id', $this->storeItem['page_no'])->first();
        } else {
            $this->fetchDropDownData['getSor'] = [];
            $this->fetchDropDownData['getSor'] = DynamicSorHeader::where('id', $this->inputsData[$type]['page_no'])->first();
            $this->sorType = $type;
        }
        if ($type != 'parent' && $this->inputsData[$type]['table_'] == 1) {
            // dd();
            $this->table_no = $this->fetchDropDownData['getSor']['table_no'];
            $this->inputsData[$type]['description'] = $this->fetchDropDownData['getSor']['title'];
            $this->page_no = $this->fetchDropDownData['getSor']['page_no'];
            $this->inputsData[$type]['sor_id'] = (int)$this->inputsData[$type]['page_no'];
        } else {
            // $this->viewModal = !$this->viewModal;
            // dd('hlw');
            if ($this->fetchDropDownData['getSor'] != null) {
                $this->table_no = $this->fetchDropDownData['getSor']['table_no'];
                $this->page_no = $this->fetchDropDownData['getSor']['page_no'];
                $this->viewModal = !$this->viewModal;
                $this->modalName = "dynamic-sor-modal_" . rand(1, 1000);
                $this->modalName = str_replace(' ', '_', $this->modalName);
            }
        }
        // dd($this->fetchDropDownData['getSor']);

    }

    public function getRowValue($data)
    {
        // dd($data);
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
            $this->extractItemNoOfItems($fetchRow, $itemNo, $convertedArray);
            $itemNo .= $this->storeItem['item_no'];
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
            $this->extractItemNoOfItems($fetchRow, $itemNo, $convertedArray);
            // $itemNo .= $this->inputsData[$this->sorType]['item_no'];
            $this->inputsData[$this->sorType]['item_no'] = $itemNo;
            $this->inputsData[$this->sorType]['description'] = $data[0]['desc'];
            $this->inputsData[$this->sorType]['sor_id'] = $this->fetchDropDownData['getSor']['id'];
        }
        if ($this->storeItem['item_no'] != '') {
            $this->fetchDropDownData['child_tables'] = DynamicSorHeader::where('dept_category_id', $this->storeItem['dept_category_id'])->select('table_no')->groupBy('table_no')->get();
            $this->fetchDropDownData['unitMaster'] = UnitMaster::select('id', 'unit_name', 'short_name', 'is_active')->where('is_active', 1)->orderBy('id', 'desc')->get();
        }


        /*
        // dd($this->storeItem, $this->inputsData);
        // if ($this->selectedCategoryId == 5) {
        //     $id = explode('.',$data['id'])[0];
        //     foreach (json_decode($this->getSor['row_data']) as $d) {
        //         if ($d->id == $id && $d->desc_of_item != '') {
        //             $this->sorMasterDesc .= $d->desc_of_item;
        //         }
        //     }
        //     $this->getItemDetails1($data);
        // } else {
        //     $rowId = explode('.', $data[0]['id'])[0];
        //     dd($rowId);
        //     foreach (json_decode($this->getSor['row_data']) as $row) {
        //         if ($row->id == $rowId) {
        //             $fetchRow = $row;
        //         }
        //     }
        //     $selectedItemId = $data[0]['id'];

        //     // ---------explode the id------
        //     $hierarchicalArray = explode(".", $selectedItemId);
        //     $convertedArray = [];
        //     $partialItemId = "";
        //     foreach ($hierarchicalArray as $part) {
        //         if ($partialItemId !== "") {
        //             $partialItemId .= ".";
        //         }
        //         $partialItemId .= $part;
        //         $convertedArray[] = $partialItemId;
        //     }
        //     $this->extractDescOfItems($fetchRow, $descriptions, $convertedArray);

        //     if ($data != null) {
        //         $this->viewModal = !$this->viewModal;
        //         $this->estimateData['description'] = $descriptions . " " . $data[0]['desc'];
        //         $this->estimateData['qty'] = 1;
        //         $this->estimateData['rate'] = $data[0]['rowValue'];
        //         $this->estimateData['item_number'] = $data[0]['itemNo'];
        //         $this->calculateValue();
        //     }
        // }

        // dd($this->estimateData['description']);
        */
        $this->viewModal = !$this->viewModal;
    }
    public function getChildPageNo($key)
    {
        $this->viewModal = false;
        $this->fetchDropDownData[$key]['child_pages'] = [];
        $this->inputsData[$key]['page_no'] = '';
        $this->fetchDropDownData[$key]['child_pages'] = DynamicSorHeader::where([['dept_category_id', $this->storeItem['dept_category_id']], ['table_no', $this->inputsData[$key]['table_no']]])->select('id', 'page_no', 'corrigenda_name')->get();
        // dd($this->fetchDropDownData);
    }
    // public function extractItemNoOfItems($data, &$itemNo, $counter)
    // {
    //     if (count($counter) > 1) {
    //         if (isset($data->item_no) && $data->item_no != '') {
    //             $itemNo = $data->item_no . ' ';
    //         }
    //         if (isset($data->_subrow)) {
    //             foreach ($data->_subrow as $key => $item) {
    //                 if (isset($counter[$this->counterForItemNo + 1])) {
    //                     if (isset($item->item_no) && $item->id == $counter[$this->counterForItemNo + 1]) {
    //                         $itemNo .= $item->item_no . ' ';
    //                     }
    //                     if (!empty($item->_subrow)) {
    //                         $this->extractItemNoOfItems($item->_subrow, $itemNo, $counter);
    //                     }
    //                 }
    //             }
    //         }
    //     } else {
    //         $itemNo = $data->item_no;
    //     }

    // }
    public function extractItemNoOfItems($data, &$itemNo, $counter)
    {
        // dd($data);
        if (count($counter) > 1) {
            if (isset($data->item_no) && $data->item_no != '') {
                $itemNo = $data->item_no . ' ';
            }
            if (isset($data->_subrow)) {
                foreach ($data->_subrow as $key => $item) {
                    if (isset($counter[$this->counterForItemNo + 1])) {
                        if (isset($item->item_no) && $item->id == $counter[$this->counterForItemNo + 1]) {
                            $itemNo .= $item->item_no . ' ';
                        }
                        if (!empty($item->_subrow)) {
                            $this->extractItemNoOfItems($item->_subrow, $itemNo, $counter);
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
    public function closeModal()
    {
        $this->viewModal = !$this->viewModal;
        if ($this->storeItem['item_no'] == '') {
            $this->storeItem['page_no'] = '';
        }
    }
    public function store()
    {
        // dd($this->inputsData, $this->storeItem);
        $this->validate();
        try {
            $intId = random_int(100000, 999999);
            foreach ($this->inputsData as $data) {

                // $last = CompositSor::create([
                $insert = [
                    'composite_id' => $intId,
                    'dept_category_id' => $this->storeItem['dept_category_id'],
                    'sor_itemno_parent_id' => $this->storeItem['parent_id'],
                    'sor_itemno_parent_index' => $this->storeItem['sor_itemno_parent_index'],
                    'col_position' => $this->storeItem['col_position'],
                    'sor_itemno_child' => $data['child_index_id'],
                    'sor_itemno_child_id' => $data['sor_id'] ?? '',
                    'description' => $data['description'],
                    'unit_id' => $data['unit_id'],
                    'is_row' => $data['table_'],
                    'rate' => $data['qty'],
                    'created_by' => Auth::user()->id,
                    'parent_itemNo' => $this->storeItem['item_no']
                ];
                // dd($insert);
                CompositSor::create($insert);
            }
            // dd($test);
            $this->notification()->success(
                $title = trans('cruds.sor.create_msg')
            );
            // $this->reset();
            $this->emit('openEntryForm');
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            $this->emit('showError', $th->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.compositsor.create-composite-sor');
    }
}
