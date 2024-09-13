<?php

namespace App\Http\Livewire\RateAnalysis\Datatable;

use App\Models\RatesAnalysis;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class EstimatedDataTable extends DataTableComponent
{
    // protected $model = EstimatePrepare::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        // $this->setDebugEnabled();
    }

    public function columns(): array
    {

        return [
            // Column::make("Id", "id")
            //     ->sortable(),
            Column::make("Rate no", "rate_id")
                ->searchable()
                ->sortable(),
            Column::make("DESCRIPTION", "description")
                ->searchable()
                ->sortable()
                ->format(fn($row) => '<span class="text-wrap">' . $row . '</span>')
                ->html(),
            Column::make("TYPE", "operation")
                ->searchable()
                ->sortable(),
            Column::make("TOTAL AMOUNT", "total_amount")
                ->format(fn($row) => round($row, 10, 2))
                ->sortable(),
            // Column::make("Status","SOR.getEstimateStatus.status")
            //     ->sortable()
            //     ->format( fn($row) => '<span class="badge bg-soft-primary fs-6">'.$row.'</span>')
            //         ->html(),
            Column::make("Status", "rate_id")
                ->format(function ($value, $row, Column $column) {
                    return view('components.data-table-components.buttons.status', [
                        'value' => $value,
                        'type' => 'Rate',
                    ]);
                }),
            Column::make("Actions", "rate_id")
                ->format(
                    fn($value, $row, Column $column) => view('livewire.action-components.rate-analysis.action-buttons')->withValue($value)
                ),
        ];
    }

    public function edit($id)
    {
        $this->emit('openForm', ['formType' => 'edit', 'id' => $id]);
    }
    public function view($rate_id)
    {
        $this->emit('openRateAnalysisModal', $rate_id);
    }
    public function forward($estimate_id)
    {
        $this->emit('openForwardModal', ['estimate_id' => $estimate_id, 'forward_from' => 'EP']);
    }
    public function builder(): Builder
    {
        // dd(Auth::user()->id);

        // dd(Auth::user()->getAllPermissions('create rate-analysis'));

        // if (Auth::user()->can('view rate-analysis')) {
        //     return $query = RatesAnalysis::query()
        //         ->where(function ($query) {
        //             $query->orWhere('operation', 'Total')
        //                 ->orWhere('operation', 'With Stacking')
        //                 ->orWhere('operation', 'Without Stacking');
        //         })
        //         ->where('item_name', '=', '');
        // } else {

        //     $userData = Session::get('user_data');
        //     $sessionKey = 'rate_data' . '_' . $userData->id . '_' . $userData->department_id;
        // $sessionRateData = Session::get($sessionKey);
        // dd($sessionRateData);
        // if ($sessionRateData !== '') {
        //     return $sessionRateData;
        // } else {
        // $query = RatesAnalysis::query()
        //     ->where(function ($query) {
        //         $query->orWhere('operation', 'Total')
        //             ->orWhere('operation', 'With Stacking')
        //             ->orWhere('operation', 'Without Stacking');
        //     })
        //     ->where('item_name', '=', '')
        //     ->where('created_by', $userData->id);
        // Session::put($sessionKey, $query);
        $query = RatesAnalysis::query()
            ->where(function ($query) {
                $query->orWhere('operation', 'Total')
                    ->orWhere('operation', 'With Stacking')
                    ->orWhere('operation', 'Without Stacking');
            })
            ->where('created_by', Auth::user()->id)
            ->where('dept_id', Auth::user()->department_id);
        return $query;
        // }
        // }
    }
}
