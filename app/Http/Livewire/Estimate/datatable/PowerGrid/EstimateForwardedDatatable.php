<?php

namespace App\Http\Livewire\Estimate\datatable\PowerGrid;

use App\Models\EstimatePrepare;
use App\Models\EstimateStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;

use PowerComponents\LivewirePowerGrid\Exportable;

use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\Rules\Rule;
use PowerComponents\LivewirePowerGrid\Rules\RuleActions;use PowerComponents\LivewirePowerGrid\Traits\ActionButton;

final class EstimateForwardedDatatable extends PowerGridComponent
{
    use ActionButton;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
     */
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
     */

    /**
     * PowerGrid datasource.
     *
     * @return Builder<\App\Models\EstimatePrepare>
     */
    public function datasource(): Builder
    {
        // $a= EstimatePrepare::query()
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
            ->where('created_by', '=', Auth::user()->id);
        // dd($a->toSql());
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
     */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
     */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('estimate_id')
            ->addColumn('sorMasterDesc')
            ->addColumn('total_amount', fn($model) => round($model->total_amount, 10, 2))
            ->addColumn('status', function ($model) {
                $statusName = EstimateStatus::where('id', $model->status)->select('status')->first();
                $statusName = $statusName->status;
                return '<span class="badge bg-soft-info fs-6"><x-lucide-eye class="w-4 h-4 text-gray-500" />' . $statusName . '</span>';
            })
            ->addColumn('comments');
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
            Column::add()
                ->title('ESTIMATE ID')
                ->field('estimate_id')
                ->sortable()
                ->searchable(),
            Column::add()
                ->title('DESCRIPTION')
                ->field('sorMasterDesc')
                ->searchable(),
            Column::add()
                ->title('TOTAL AMOUNT')
                ->field('total_amount')
                ->makeInputRange(),
            Column::add()
                ->title('STATUS')
                ->field('status')
                ->searchable(),

            Column::add()
                ->title('COMMENTS')
                ->field('comments'),

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
     */

    /**
     * PowerGrid EstimatePrepare Action Buttons.
     *
     * @return array<int, Button>
     */

    public function actions(): array
    {
        return [
            Button::add('view')
                ->caption('View')
                ->class('btn btn-soft-primary btn-sm')
                ->emit('openModal', ['estimate_id']),

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
     */

    /**
     * PowerGrid EstimatePrepare Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
public function actionRules(): array
{
return [

//Hide button edit for ID 1
Rule::button('edit')
->when(fn($estimate-prepare) => $estimate-prepare->id === 1)
->hide(),
];
}
 */
}
