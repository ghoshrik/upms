<?php

namespace App\Http\Livewire\QuantityEvaluation\Datatable;

use App\Models\QultiyEvaluation;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class QuantityEvaluationTable extends PowerGridComponent
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
    * @return Builder<\App\Models\QultiyEvaluation>
    */
    public function datasource(): Builder
    {
        return QultiyEvaluation::query()
            ->where('operation', 'Final')
            ->where('created_by',Auth::user()->id);
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
            ->addColumn('id')
            ->addColumn('rate_id')
            ->addColumn('getDepartmentName.department_name')
            // ->addColumn('row_id')
            // ->addColumn('row_index')

           /** Example of custom column using a closure **/
            ->addColumn('row_index_lower', function (QultiyEvaluation $model) {
                return strtolower(e($model->row_index));
            })

            // ->addColumn('label')
            // ->addColumn('unit')
            ->addColumn('value');
            // ->addColumn('operation');
            // ->addColumn('created_by')
            // ->addColumn('remarks');
            // ->addColumn('created_at_formatted', fn (QultiyEvaluation $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
            // ->addColumn('updated_at_formatted', fn (QultiyEvaluation $model) => Carbon::parse($model->updated_at)->format('d/m/Y H:i:s'));
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
            Column::make('ID', 'id')
                ->makeInputRange(),

            Column::make('RATE ID', 'rate_id')
                ->makeInputRange(),

            Column::make('DEPT Name', 'getDepartmentName.department_name')
                ->makeInputRange(),

            // Column::make('ROW ID', 'row_id')
            //     ->makeInputRange(),

            // Column::make('ROW INDEX', 'row_index')
            //     ->sortable()
            //     ->searchable()
            //     ->makeInputText(),

            // Column::make('LABEL', 'label')
            //     ->sortable()
            //     ->searchable()
            //     ->makeInputText(),

            // Column::make('UNIT', 'unit')
            //     ->makeInputRange(),

            Column::make('VALUE', 'value')
                ->sortable()
                ->searchable(),

            // Column::make('OPERATION', 'operation')
            //     ->sortable()
            //     ->searchable()
            //     ->makeInputText(),

            // Column::make('CREATED BY', 'created_by')
            //     ->makeInputRange(),

            // Column::make('REMARKS', 'remarks')
            //     ->sortable()
            //     ->searchable()
            //     ->makeInputText(),

            // Column::make('CREATED AT', 'created_at_formatted', 'created_at')
            //     ->searchable()
            //     ->sortable()
            //     ->makeInputDatePicker(),

            // Column::make('UPDATED AT', 'updated_at_formatted', 'updated_at')
            //     ->searchable()
            //     ->sortable()
            //     ->makeInputDatePicker(),

        ]
;
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

     /**
     * PowerGrid QultiyEvaluation Action Buttons.
     *
     * @return array<int, Button>
     */


    public function actions(): array
    {
       return [
        Button::add('View')
        ->bladeComponent('view', ['id' => 'rate_id']),

        //    Button::make('destroy', 'Delete')
        //        ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
        //        ->route('qultiy-evaluation.destroy', ['qultiy-evaluation' => 'id'])
        //        ->method('delete')
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
     * PowerGrid QultiyEvaluation Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($qultiy-evaluation) => $qultiy-evaluation->id === 1)
                ->hide(),
        ];
    }
    */
    public function view($rate_id)
    {
        $this->emit('openQuantityEvaluationModal', $rate_id);
    }
}
