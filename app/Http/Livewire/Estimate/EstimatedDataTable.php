<?php

namespace App\Http\Livewire\Estimate;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use App\Models\EstimatePrepare;
use App\Models\SorMaster;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class EstimatedDataTable extends DataTableComponent
{
    protected $model = SorMaster::class;

    public function configure(): void
    {
        $this->setPrimaryKey('estimate_id');
        // $this->setDebugEnabled();
    }

    public function columns(): array
    {
        
        return [
            // Column::make("Id", "id")
            //     ->sortable(),
            Column::make("Estimate no", "estimate_id")
                ->sortable(),
            Column::make("DESCRIPTION", "sorMasterDesc"),
            Column::make("ESTIMATE TOTAL", "estimate.total_amount")
            ->sortable(),
            Column::make("status", "status")
            ->sortable(),
            Column::make("user", "userAR.estimate_user_id")
            ->hideIf(true),
        ];
    }
    public function builder(): Builder
    {
        return SorMaster::query()->where('status',1)->where('estimate_prepares.operation','Total')->where('estimate_user_assign_records.estimate_user_id',Auth::user()->id);
    }
}
