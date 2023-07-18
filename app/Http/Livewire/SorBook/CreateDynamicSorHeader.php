<?php

namespace App\Http\Livewire\SorBook;

use App\Models\DynamicSorHeader;
use Livewire\Component;
use WireUi\Traits\Actions;

class CreateDynamicSorHeader extends Component
{
    use Actions;
    protected $listeners = ['storeData' => 'store', 'showError' => 'setErrorAlert'];
    public $table_no, $page_no, $header_data, $row_data, $processHeaderData,$errorMessage;

    public function setErrorAlert($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }
    public function store($data)
    {
        try {
            DynamicSorHeader::create([
                'table_no' => $data['table_no'],
                'page_no' => $data['page_no'],
                'header_data' => $data['header_data'],
                'row_data' => $data['row_data'],
            ]);
            $this->emit('openEntryForm');
            $this->notification()->success(
                $title = 'Dynamic SOR Created Successfully!!'
            );
        } catch (\Exception $e) {
            $this->emit('showError', $e->getMessage());
            $this->emit('openEntryForm');
        }
    }

    public function render()
    {
        return view('livewire.sor-book.create-dynamic-sor-header');
    }
}
