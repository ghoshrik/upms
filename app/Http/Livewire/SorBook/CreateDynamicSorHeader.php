<?php

namespace App\Http\Livewire\SorBook;

use Livewire\Component;

class CreateDynamicSorHeader extends Component
{
    public $table_no, $page_no, $header_data,$row_data, $processHeaderData;

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
        return view('livewire.sor-book.create-dynamic-sor-header');
    }
}
