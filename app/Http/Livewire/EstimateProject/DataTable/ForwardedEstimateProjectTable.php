<?php

namespace App\Http\Livewire\EstimateProject\DataTable;

use App\Models\EstimatePrepare;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ForwardedEstimateProjectTable extends DataTableComponent
{
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
                ->searchable()
                ->sortable(),
            Column::make("DESCRIPTION", "SOR.sorMasterDesc")
                ->searchable()
                ->sortable(),
            Column::make("TOTAL AMOUNT", "total_amount")
                ->format(fn($row) => round($row, 10, 2))
                ->sortable(),
            Column::make("Status", "SOR.getEstimateStatus.status")
                ->sortable()
                ->format(fn($row) => '<span class="badge bg-soft-info fs-6">' . $row . '</span>')
                ->html(),
            Column::make("Remarks", "comments"),
            Column::make("Actions", "estimate_id")
                ->format(
                    fn($value, $row, Column $column) => view('livewire.action-components.estimate-prepare.forwarded-table-buttons')->withValue($value)),
        ];
    }

    public function edit($id)
    {
        $this->emit('openForm', true, $id);
    }
    public function view($estimate_id)
    {
        $this->emit('openModal', $estimate_id);
    }
    public function forward($estimate_id)
    {
        $this->emit('openForwardModal', $estimate_id);
    }
    public function builder(): Builder
    {
        return EstimatePrepare::query()
            ->select('estimate_prepares.id', 'estimate_prepares.estimate_id', 'estimate_prepares.operation', 'estimate_prepares.total_amount', 'estimate_prepares.created_by',
                'estimate_user_assign_records.estimate_id as user_assign_records_estimate_id', 'estimate_user_assign_records.estimate_user_type',
                'estimate_user_assign_records.user_id', 'estimate_user_assign_records.estimate_user_type', 'estimate_user_assign_records.comments',
                'sor_masters.estimate_id as sor_masters_estimate_id', 'sor_masters.sorMasterDesc', 'sor_masters.status')
            ->join('estimate_user_assign_records', function ($join) {
                $join->on('estimate_user_assign_records.estimate_id', '=', 'estimate_prepares.estimate_id')
                    ->where('estimate_user_assign_records.status', '=', 2)
                    ->where('estimate_user_assign_records.created_at', '=', DB::raw("(SELECT max(created_at) FROM estimate_user_assign_records WHERE estimate_prepares.estimate_id = estimate_user_assign_records.estimate_id AND estimate_user_assign_records.status = 2)"));
            })
            ->join('sor_masters', 'sor_masters.estimate_id', '=', 'estimate_prepares.estimate_id')
            ->where('operation', '=', 'Total')
            ->where('estimate_no','!=',NULL)
            ->where('created_by', '=', Auth::user()->id);
        // ->groupBy('estimate_id.estimate_id');
    }
}
