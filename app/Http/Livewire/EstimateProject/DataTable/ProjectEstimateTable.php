<?php

namespace App\Http\Livewire\EstimateProject\DataTable;

use App\Models\EstimatePrepare;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;

class ProjectEstimateTable extends DataTableComponent
{
    // protected $model = EstimatePrepare::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Estimate no", "estimate_id")
                ->searchable()
                ->sortable(),
            Column::make("DESCRIPTION", "SOR.sorMasterDesc")
                ->searchable()
                ->sortable(),
            // Column::make("TOTAL AMOUNT", "total_amount")
            //     ->format(fn ($row) => round($row, 10, 2))
            //     ->sortable(),
            Column::make("Status","SOR.getEstimateStatus.status")
                ->sortable()
                ->format( fn($row) => '<span class="badge bg-soft-primary fs-6">'.$row.'</span>')
                    ->html(),
                Column::make("Actions", "estimate_id")
                ->format(
                    fn($value, $row, Column $column) => view('livewire.action-components.estimate-prepare.action-buttons')->withValue($value))
        ];
    }
    public function builder(): Builder
    {
        $query = EstimatePrepare::query()
            ->select(
                'estimate_masters.id',
                'estimate_masters.estimate_id',
                // 'estimate_prepares.total_amount',
                'estimate_statuses.status',
                DB::raw('ROW_NUMBER() OVER (ORDER BY estimate_masters.id) as serial_no')
            )
            ->join('estimate_user_assign_records', 'estimate_user_assign_records.estimate_id', '=', 'estimate_prepares.estimate_id')
            ->join('estimate_masters', 'estimate_masters.estimate_id', '=', 'estimate_prepares.estimate_id')
            ->join('estimate_statuses', 'estimate_statuses.id', '=', 'estimate_masters.status')
            ->groupBy('estimate_masters.estimate_id','estimate_prepares.estimate_id', 'estimate_masters.id', 'estimate_statuses.status');
        // ->where('estimate_user_assign_records.estimate_user_type', '=', 5)
        if (Auth::user()->can('create estimate')) {
            $query->whereIn('estimate_masters.status', [1, 10, 12])
                ->where('estimate_prepares.created_by', Auth::user()->id);
        } elseif (Auth::user()->can('modify estimate')) {
            $query->where(function ($query) {
                $query->where('estimate_user_assign_records.user_id', Auth::user()->id)
                    ->orWhere('estimate_user_assign_records.assign_user_id', Auth::user()->id);
            })->where('estimate_masters.is_verified', '=', 0)
                ->where(function ($query) {
                    $query->where('estimate_masters.status', 2)
                        ->orWhere('estimate_masters.status', 4)
                        ->orWhere('estimate_masters.status', 6);
                })
                ->where('estimate_user_assign_records.is_done', 0);
        } else {
            $query->where('estimate_user_assign_records.user_id', Auth::user()->id)
                ->orWhere('estimate_user_assign_records.assign_user_id', Auth::user()->id);
        }
        return $query;
    }
    public function edit($id)
    {
        $this->emit('openForm', ['formType'=>'edit', 'id'=>$id]);
    }
    public function view($estimate_id)
    {
        $this->emit('openModal', $estimate_id);
    }
    public function forward($estimate_id)
    {
        $this->emit('openForwardModal',['estimate_id'=>$estimate_id,'forward_from'=>'EP']);
    }
}
