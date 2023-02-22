<?php

namespace App\Http\Livewire\DataTable;

use App\Models\Milestone;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;

class MilestoneDataTable extends DataTableComponent
{
    // protected $model = Milestone::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            // Column::make("Index", "index")
            //     ->sortable(),
            // Column::make("Milestone id", "milestone_id")
            //     ->sortable(),
            Column::make("Project id", "project_id")
                ->sortable(),
            // Column::make("Milestone name", "milestone_name")
            //     ->sortable(),
            // Column::make("Weight", "weight")
            //     ->sortable(),
            // Column::make("Unit type", "unit_type")
            //     ->sortable(),
            // Column::make("Cost", "cost")
            //     ->sortable(),
            // Column::make("Is achived", "Is_achived")
            //     ->sortable(),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
            Column::make("Actions", "project_id")->view('components.data-table-components.buttons.view'),
        ];
    }
    public function builder(): Builder
    {
        return Milestone::query()
        ->whereNull('milestone_id')
        ->with('childrenMilestones');
    }

    public function view($Id)
    {
        $this->emit('mileStoneRow',$Id);
    }
}
