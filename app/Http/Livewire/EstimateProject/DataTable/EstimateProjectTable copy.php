<?php

namespace App\Http\Livewire\EstimateProject\DataTable;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use App\Models\EstimatePrepare;
use App\Models\SorMaster;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class EstimateProjectTable extends DataTableComponent
{
    // protected $model = EstimatePrepare::class;

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
                ->format(fn ($row) => round($row, 10, 2))
                ->sortable(),
            Column::make("Status","SOR.getEstimateStatus.status")
                ->sortable()
                ->format( fn($row) => '<span class="badge bg-soft-primary fs-6">'.$row.'</span>')
                    ->html(),
            Column::make("Actions", "estimate_id")
            ->format(
                fn($value, $row, Column $column) => view('livewire.action-components.estimate-prepare.action-buttons')->withValue($value))
        ];
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
    public function builder(): Builder
    {
        return EstimatePrepare::query()
        ->join('estimate_user_assign_records','estimate_user_assign_records.estimate_id','=','estimate_prepares.estimate_id')
        ->join('sor_masters','sor_masters.estimate_id','=','estimate_prepares.estimate_id')
        ->where('estimate_user_assign_records.estimate_user_type','=',5)
        ->where(function ($query) {
            $query->where('sor_masters.status', '=', 1)
                  ->orWhere('sor_masters.status', '=', 10);
        })
        ->where('operation', 'Total')
        ->where('created_by',Auth::user()->id);
    }
}
