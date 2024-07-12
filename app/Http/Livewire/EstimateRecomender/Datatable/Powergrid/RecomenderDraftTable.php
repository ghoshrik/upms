<?php

namespace App\Http\Livewire\EstimateRecomender\Datatable\Powergrid;

use App\Models\Esrecommender;
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

final class RecomenderDraftTable extends PowerGridComponent
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
                ->type(Exportable::TYPE_XLS),
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
     * @return Builder<\App\Models\Esrecommender>
     */
    public function datasource(): Builder
    {
        return EstimatePrepare::query()
            ->select(
                'estimate_prepares.id',
                'estimate_prepares.estimate_id',
                'estimate_prepares.operation',
                'estimate_prepares.total_amount',
                'estimate_prepares.created_by',
                'estimate_user_assign_records.estimate_id as user_assign_records_estimate_id',
                'estimate_user_assign_records.estimate_user_type',
                'estimate_user_assign_records.assign_user_id',
                'estimate_user_assign_records.estimate_user_type',
                'estimate_user_assign_records.comments',
                'estimate_masters.estimate_id as sor_masters_estimate_id',
                'estimate_masters.sorMasterDesc',
                'estimate_masters.status', DB::raw('ROW_NUMBER() OVER (ORDER BY estimate_masters.id) as serial_no')
            )
            ->join('estimate_user_assign_records', 'estimate_user_assign_records.estimate_id', '=', 'estimate_prepares.estimate_id')
            ->join('estimate_masters', 'estimate_masters.estimate_id', '=', 'estimate_prepares.estimate_id')
            ->where('estimate_user_assign_records.assign_user_id', '=', Auth::user()->id)
            ->where('estimate_user_assign_records.estimate_user_type', '=', 3)
            ->where('estimate_masters.is_verified', '=', 0)
            ->where('estimate_masters.status', '!=', 9)
            ->where('estimate_masters.status', '!=', 11)
            ->where('estimate_masters.status', '!=', 3)
            ->where('operation', 'Total');
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
            ->addColumn('serial_no')
            ->addColumn('estimate_id')
            ->addColumn('sorMasterDesc')
            ->addColumn('total_amount', fn($model) => round($model->total_amount, 10, 2))
            ->addColumn('recomender_cost', function ($model) {
                $recomenderCost = Esrecommender::where('estimate_id', $model->estimate_id)->where('operation', 'Total')->first();
                $recomenderCost = ($recomenderCost) ? $recomenderCost->total_amount : '';
                return $recomenderCost;
            })
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
                ->title('Sl. No')
                ->field('serial_no'),
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
                ->title('ESTIMATOR COST')
                ->field('total_amount')
                ->makeInputRange(),
            Column::add()
                ->title('RECOMENDER COST')
                ->field('recomender_cost')
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
     * PowerGrid Esrecommender Action Buttons.
     *
     * @return array<int, Button>
     */

    public function actions(): array
    {
        return [
            // Button::add('custom')
            // ->bladeComponent('action-components.estimate-recomender.draft-table-buttons', ['value'=>'estimate_id']),
            Button::add('view')
                ->caption('View')
                ->class('btn btn-soft-primary btn-sm')
                ->emit('openModal', ['estimate_id']),
            Button::add('approve')
                ->caption('Approve')
                ->class('btn btn-soft-primary btn-sm')
                ->emit('openApproveModal', ['estimate_id']),
            Button::add('revert')
                ->caption('Revert')
                ->class('btn btn-soft-primary btn-sm')
                ->emit('openRevertModal', ['estimate_id']),
            Button::add('forward')
                ->caption('Forward')
                ->class('btn btn-soft-primary btn-sm')
                ->emit('openForm', ['estimate_id']),
            Button::add('modify')
                ->caption('Modify')
                ->class('btn btn-soft-primary btn-sm')
                ->emit('openForm', ['formType' => 'modify', 'id' => 'estimate_id']),
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
     * PowerGrid Esrecommender Action Rules.
     *
     * @return array<int, RuleActions>
     */

    public function actionRules(): array
    {
        return [
            Rule::button('forward')
                ->when(fn($model) => $model->status == 2 || $model->status == 4)
                ->hide(),
            Rule::button('approve')
                ->when(fn($model) => $model->status == 6)
                ->hide(),
            Rule::button('revert')
                ->when(fn($model) => $model->status == 6 || $model->status == 4)
                ->hide(),
        ];
    }

}
