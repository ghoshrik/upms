<?php

namespace App\Http\Livewire\SorBook;

use Livewire\Component;
use App\Models\SorCategoryType;
use Illuminate\Support\Facades\Auth;
class CreateDynamicSorHeader extends Component
{
    public $table_no, $page_no, $header_data,$row_data, $processHeaderData,$department_no;
    public $deptCategories,$dept_category_id;

    public function store(Request $request)
    {
        error_log(print_r($request->all(), true));
        $data = $request->all();
        DynamicSorHeader::create([
            'table_no' => $data['table_no'],
            'page_no' => $data['page_no'],
            'header_data' => $data['header_data'],
            'row_data' => $data['row_data'],
        ]);
    }

    public function render()
    {
        $this->deptCategories = SorCategoryType::select('id', 'dept_category_name')->where('department_id', '=', Auth::user()->department_id)->get();
	//$this->deptCategories = SorCategoryType::select('id', 'dept_category_name')->get();

	$this->department_no = Auth::user()->department_id;
        // dd($this->deptCategories);
        return view('livewire.sor-book.create-dynamic-sor-header');
    }
}
