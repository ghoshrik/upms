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
            Column::make(trans('cruds.aoc.fields.tender_id'), "tender_id")
                ->sortable()
                ->searchable(),
            Column::make(trans('cruds.aoc.fields.title'), "tender_title")
                ->sortable()
                ->searchable(),
            Column::make(trans('cruds.aoc.fields.project_id'), "projects.estimate_id")
                ->sortable()
                ->searchable(),
            Column::make(trans('cruds.aoc.fields.category'), "tender_category")
                ->sortable(),
            // Column::make(trans('cruds.aoc.fields.actions'), "id")->view('components.data-table-components.buttons.edit'),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
        ];
    }

    public function edit($ID)
    {
        return $this->emit('editAOC',$ID);
    }
}
