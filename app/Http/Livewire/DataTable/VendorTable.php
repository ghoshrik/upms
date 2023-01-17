<?php

namespace App\Http\Livewire\DataTable;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Vendor;

class VendorTable extends DataTableComponent
{
    protected $model = Vendor::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Comp name", "comp_name")
                ->sortable(),
            Column::make("Tan number", "tin_number")
                ->sortable(),
            Column::make("Pan number", "pan_number")
                ->sortable(),
            Column::make("Mobile", "mobile")
                ->sortable(),
            Column::make("Address", "address")
                ->sortable(),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
        ];
    }
}
