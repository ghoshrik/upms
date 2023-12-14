<?php

namespace App\Http\Livewire\ViewSorBook;

use Livewire\Component;
use App\Models\SorCategoryType;
use App\Models\DynamicSorHeader;

class ViewBookList extends Component
{
    public $selectedIdForEdit, $dept_category, $dept_category_id, $field, $rowData;
    public function render()
    {
        $getData = DynamicSorHeader::where('id', $this->selectedIdForEdit)->first();
        $this->dept_category = SorCategoryType::select('id', 'dept_category_name')->where('id', '=', $getData['dept_category_id'])->first();
        $this->dept_category_id = $this->dept_category['id'];
        $this->field['headerData'] = json_decode($getData['header_data'], true);
        $this->rowData = json_decode($getData['row_data'], true);
        $this->field['tableNo'] = $getData['table_no'];
        $this->field['title'] = $getData['title'];
        $this->field['dept_category'] = $getData['dept_category_id'];
        $this->field['dept_category'] = SorCategoryType::select('dept_category_name')->where('id', $this->field['dept_category'])->first();
        $this->field['volumeNo'] = $getData['volume_no'];
        if ($this->field['volumeNo'] == 1) {
            $this->field['volumeNo'] = "Volume I";
        } else if ($this->field['volumeNo'] == 2) {
            $this->field['volumeNo'] = "Volume II";
        } else {
            $this->field['volumeNo'] = "Volume III";
        }
        $this->field['pageNo'] = $getData['page_no'];
        $this->field['publishDate'] = $getData['effective_date'];
        $this->field['Note'] = $getData['note'];

        $this->field['selectId'] = $getData['id'];
	$this->field['corrigenda'] = $getData['corrigenda_name'];
        return view('livewire.view-sor-book.view-book-list');
    }
    
}
