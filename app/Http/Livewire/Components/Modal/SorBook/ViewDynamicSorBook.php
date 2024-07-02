<?php

namespace App\Http\Livewire\Components\Modal\SorBook;

use App\Models\DynamicSorHeader;
use Livewire\Component;

class ViewDynamicSorBook extends Component
{

    public $show=false, $headerData, $rowData, $note, $volumeNo, $page_no, $table_no, $effect_date, $title, $modalName = '';
    protected $listeners = ['ViewSorList' => 'ShowList','closeModal'=>'doClose'];

    public function mount()
    {
        // $this->data = $data;
        $this->show = false;
    }
    public function ShowList($data)
    {
        $getDatas = DynamicSorHeader::where('id', $data)->first();
        $this->headerData = json_decode($getDatas['header_data'], true);
        $this->rowData = json_decode($getDatas['row_data'], true);
        $this->note = $getDatas['note'];
        $this->title = $getDatas['title'];
        $this->volumeNo = $getDatas['volume_no'];
        $this->page_no = $getDatas['page_no'];
        $this->table_no = $getDatas['table_no'];
        $this->effect_date = $getDatas['effective_date'];
        $this->doShow();
    }
    public function doShow()
    {
        $this->show = !$this->show;
        $this->modalName = "dynamic-sor-modal_" . rand(1, 1000);
        $this->modalName = str_replace(' ', '_', $this->modalName);
    }
    public function doClose()
    {
        $this->show = !$this->show;
    }
    public function doSomething()
    {
        $this->doClose();
    }
    public function render()
    {
        return view('livewire.components.modal.sor-book.view-dynamic-sor-book');
    }
}
