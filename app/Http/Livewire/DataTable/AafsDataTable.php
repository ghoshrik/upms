<?php

namespace App\Http\Livewire\DataTable;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\AAFS;

class AafsDataTable extends DataTableComponent
{
    protected $model = AAFS::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Project No", "project_no")
                ->sortable(),
            Column::make("Department Name", "dept_id")
                ->sortable(),
            Column::make("Status", "status_id")
                ->sortable(),
            Column::make("Project Cost", "project_cost")
                ->sortable(),
            Column::make("Tender Cost", "tender_cost")
                ->sortable(),
            Column::make("AAFS ID", "aafs_mother_id")
                ->sortable(),
            Column::make("AAFS Sub ID", "aafs_sub_id")
                ->sortable(),
            Column::make("Project Type", "project_type")
                ->sortable(),
            Column::make("Completion Period", "completePeriod")
                ->sortable(),
            Column::make("Un No", "unNo")
                ->sortable(),
            Column::make("Go No", "goNo")
                ->sortable(),
            Column::make("Pre AAfs Expenditure", "preaafsExp")
                ->sortable(),
            Column::make("Post AAfs Expenditure", "postaafsExp")
                ->sortable(),
            Column::make("Fund Released", "Fundcty")
                ->sortable(),
            Column::make("Executing Authority", "exeAuthority")
                ->sortable(),
            // Column::make("Go id", "Go_id")
            //     ->sortable(),
            // Column::make("Support data", "support_data")
            //     ->sortable(),
            // Column::make("Status", "status")
            //     ->sortable(),
            // Column::make("Go date", "go_date")
            //     ->sortable(),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
        ];
    }
}
