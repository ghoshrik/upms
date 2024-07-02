<?php

namespace App\Http\Livewire\SorBook;

use App\Models\DynamicSorHeader;
use Livewire\Component;
use App\Models\SorCategoryType;
use Illuminate\Support\Facades\Auth;

class CreateDynamicSor extends Component
{
    public $header_data, $row_data, $selectedIdForEdit, $selectedId, $noteDtls, $tbl_title, $volume_no, $page_no, $table_no, $effective_date;
    public $dept_category, $dept_category_id, $corrigenda_name, $deptCateName;
    public $subTitle, $fetchData = [];

    public function render()
    {
        $getDatas = DynamicSorHeader::where('id', $this->selectedIdForEdit)->first();
        //dd($getDatas);
        $this->dept_category = SorCategoryType::select('id', 'dept_category_name')->where('id', '=', $getDatas['dept_category_id'])->first();
        $this->dept_category_id = $this->dept_category['id'];
        // dd($this->dept_category);
        $this->selectedId = $getDatas['id'];
        $this->header_data = json_decode($getDatas['header_data'], true);
        $this->row_data = json_decode($getDatas['row_data'], true);
        $this->noteDtls = $getDatas['note'];
        $this->tbl_title = $getDatas['title'];
        $this->subTitle = $getDatas['subtitle'] ?? '';
        //dd($this->subTitle);
        $this->deptCateName = $getDatas->getDeptCategoryName->dept_category_name;
        // dd($getDatas->getDeptCategoryName->dept_category_name);
        if ($getDatas['volume_no'] == '1') {
            $this->volume_no = 'Volume I';
        } elseif ($getDatas['volume_no'] == '2') {
            $this->volume_no = 'Volume II';
        } else {
            $this->volume_no = 'Volume III';
        }
        //$this->volume_no = $getDatas['volume_no'];
        $this->page_no = $getDatas['page_no'];
        $this->table_no = $getDatas['table_no'];
        $this->effective_date = $getDatas['effective_date'];
        $this->corrigenda_name = $getDatas['corrigenda_name'];
        $this->fetchData['approver'] = $getDatas['is_approve'];
        $this->fetchData['verifier'] = $getDatas['is_verified'];
        return view('livewire.sor-book.create-dynamic-sor');
    }
}
