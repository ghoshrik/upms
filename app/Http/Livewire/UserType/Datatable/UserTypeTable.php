<?php

namespace App\Http\Livewire\UserType\Datatable;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\UserType;

class UserTypeTable extends DataTableComponent
{
    protected $model = UserType::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Type", "type")
                ->sortable(),
                Column::make("Parent", "parent_id")
                ->sortable(),
        ];
    }
}
