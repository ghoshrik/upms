<?php

namespace App\Http\Livewire\DataTable;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\AOC;

class AocTable extends DataTableComponent
{
    protected $model = AOC::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make(trans('cruds.aoc.fields.project_id'), "tender_id")
                ->sortable()
                ->searchable(),
            Column::make(trans('cruds.aoc.fields.title'), "tender_title")
                ->sortable()
                ->searchable(),
            Column::make(trans('cruds.aoc.fields.ref_no'), "refc_no")
                ->sortable()
                ->searchable(),
            Column::make(trans('cruds.aoc.fields.category'), "tender_category")
                ->sortable(),
            Column::make(trans('cruds.aoc.fields.actions'), "id")->view('components.data-table-components.buttons.edit'),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
        ];
    }
}
