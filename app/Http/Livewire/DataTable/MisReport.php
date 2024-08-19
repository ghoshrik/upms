<?php

namespace App\Http\Livewire\DataTable;

use App\Models\SorMaster;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

final class MisReport extends PowerGridComponent
{
    use ActionButton;

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
     */

    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(),
            [
                'rowActionEvent',
                'bulkActionEvent',
            ]
        );
    }
    public function header(): array
    {
        return [
            Button::add('bulk-demo')
                ->caption('PDF')
                ->class('cursor-pointer btn btn-soft-primary btn-sm')
                ->emit('bulkActionEvent', [])
        ];
    }
    public function bulkActionEvent()
    {
        $ModelList = [
            'Department Name' => '30%',
            'Department Code' => '15%',
            'Estimate No' => '11%',
            'Current Status' => '12%',
            'Estimate Description' => '19%',
        ];
        if (count($this->checkboxValues) == 0) {

            $reports = SorMaster::select('departments.department_name', 'departments.department_code', 'estimate_statuses.status', 'sor_masters.estimate_id', 'sor_masters.sorMasterDesc')
                ->join('estimate_statuses', 'sor_masters.status', '=', 'estimate_statuses.id')
                ->join('departments', 'sor_masters.dept_id', '=', 'departments.id')
                ->get();

            $i = 1;
            foreach ($reports as $key => $report) {
                $dataView[] = [
                    '1' => $i,
                    '2' => $report->department_name,
                    '3' => $report->department_code,
                    '4' => $report->estimate_id,
                    '5' => $report->status,
                    '6' => $report->sorMasterDesc,
                ];
            }
            $i++;
            // dd($res);
            return generatePDF($ModelList, $dataView, "Mis Report");
        } else {
            $ids = implode(',', $this->checkboxValues);
            $reports = SorMaster::whereIn('sor_masters.id', explode(",", $ids))
                ->select('departments.department_name', 'departments.department_code', 'estimate_statuses.status', 'sor_masters.estimate_id', 'sor_masters.sorMasterDesc')
                ->join('estimate_statuses', 'sor_masters.status', '=', 'estimate_statuses.id')
                ->join('departments', 'sor_masters.dept_id', '=', 'departments.id')
                ->get();
            $i = 1;
            foreach ($reports as $key => $report) {
                $dataView[] = [
                    '1' => $i,
                    '2' => $report->department_name,
                    '3' => $report->department_code,
                    '4' => $report->estimate_id,
                    '5' => $report->status,
                    '6' => $report->sorMasterDesc,
                ];
            }
            $i++;
            // dd($res);
            return generatePDF($ModelList, $dataView, "Mis Report");
        }
    }

    public function datasource(): Builder
    {
        $res = SorMaster::query()
            ->select(
                'sor_masters.id',
                'departments.department_name as dept_name',
                'departments.department_code as dept_code',
                'estimate_statuses.status as estCurrStatus',
                'sor_masters.estimate_id',
                'sor_masters.sorMasterDesc',
                'estimate_prepares.total_amount as total_amount',
                DB::raw(
                    'ROW_NUMBER() OVER (ORDER BY sor_masters.id) as serial_no'
                )
            )
            ->join('estimate_statuses', 'sor_masters.status', '=', 'estimate_statuses.id')
            ->join('departments', 'sor_masters.dept_id', '=', 'departments.id')
            ->join('estimate_prepares', 'estimate_prepares.estimate_id', '=', 'sor_masters.estimate_id')
            ->where('estimate_prepares.operation', '=', 'Total')
            ->where('sor_masters.status', 1)
            ->orderBy('departments.department_name');
        return $res;
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
     */
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            // Exportable::make('export')
            //     ->striped()
            //     ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
     */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('serial_no')
            ->addColumn('dept_name')
        // ->addColumn('dept_code')
            ->addColumn('estimate_id')
        // ->addColumn('estCurrStatus')
            ->addColumn('sorMasterDesc')
            ->addColumn('total_amount');
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |

     */
    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::make('Sl. No', 'serial_no')
                ->searchable()
                ->sortable(),

            Column::make('Department Name', 'dept_name')
                ->searchable(),
            // ->makeInputText('departments.department_name'),
            // Column::make('Department Code', 'dept_code')
            //     ->searchable()
            //     ->makeInputText('departments.department_code')
            //     ->sortable(),

            Column::make('Estimate No.', 'estimate_id'),
            // Column::make('Status', 'estCurrStatus')
            //     ->sortable(),

            Column::make('Description', 'sorMasterDesc')
                ->headerAttribute('style', 'white-space: normal; word-wrap: break-word; word-break: break-word; overflow-wrap: break-word;')
                ->bodyAttribute('style', 'white-space: normal; word-wrap: break-word; word-break: break-word; overflow-wrap: break-word;'),
            Column::make('Total Amount.', 'total_amount'),
        ];
    }
}
