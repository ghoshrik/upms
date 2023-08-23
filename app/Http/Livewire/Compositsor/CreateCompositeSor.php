<?php

namespace App\Http\Livewire\Compositsor;

use App\Models\DynamicSorHeader;
use App\Models\SorCategoryType;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;

class CreateCompositeSor extends Component
{
    use Actions, WithFileUploads;
    protected $listeners = ['getRowValue', 'closeModal'];
    public $fetchDropDownData = [], $storeItem = [], $viewModal = false,$counterForItemNo = 0;

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
    }

    public function getDeptCategorySORItem()
    {
        $this->fetchDropDownData['tables'] = DynamicSorHeader::select('table_no', 'dept_category_id')->where('dept_category_id', $this->storeItem['dept_category_id'])->get();
    }

    public function getPageNo()
    {
        $this->fetchDropDownData['pages'] = [];
        $this->fetchDropDownData['pages'] = DynamicSorHeader::select('dept_category_id', 'page_no', 'table_no')->where([['dept_category_id', $this->storeItem['dept_category_id']], ['table_no', $this->storeItem['table_no']]])->get();
        $this->viewModal = false;
        $this->fetchDropDownData['page_no'] = '';

    }

    public function getDynamicSor()
    {
        $this->fetchDropDownData['getSor'] = [];
        $this->fetchDropDownData['getSor'] = DynamicSorHeader::where([['dept_category_id', $this->storeItem['dept_category_id']], ['page_no', $this->storeItem['page_no'], ['table_no', $this->storeItem['table_no']]]])->first();
        if ($this->fetchDropDownData['getSor'] != null) {
            $this->viewModal = !$this->viewModal;
            $this->modalName = "dynamic-sor-modal_" . rand(1, 1000);
            $this->modalName = str_replace(' ', '_', $this->modalName);
        }
    }

    public function getRowValue($data)
    {
        // dd($data);
        $fetchRow[] = [];
        if ($this->storeItem['item_no'] == '') {
            if (isset($data[0]['itemNo'])) {
                $this->storeItem['item_no'] = $data[0]['itemNo'];
            }
            $this->storeItem['parent_id'] = $this->fetchDropDownData['getSor']['id'];

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
        }
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
    }
    public function extractItemNoOfItems($data, &$itemNo, $counter)
    {
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
        if($this->storeItem['item_no'] == '')
        {
            $this->storeItem['page_no'] = '';
        }
    }
    public function render()
    {
        return view('livewire.compositsor.create-composite-sor');
    }
}
