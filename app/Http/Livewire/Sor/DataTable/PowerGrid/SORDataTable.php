<?php

namespace App\Http\Livewire\Sor\DataTable\PowerGrid;

use App\Models\SOR;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class SORDataTable extends PowerGridComponent
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
     * @return Builder<\App\Models\SOR>
     */
    public function datasource(): Builder
    {
        return SOR::query();
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
            // ->addColumn('id')
            ->addColumn('Item_details')

            /** Example of custom column using a closure **/
            ->addColumn('Item_details_lower', function (SOR $model) {
                return strtolower(e($model->Item_details));
            })

            ->addColumn('getDepartmentName.department_name')
            ->addColumn('getDeptCategoryName.dept_category_name')
            ->addColumn('description')
            ->addColumn('unit')
            ->addColumn('cost')
            ->addColumn('version')
            ->addColumn('effect_from_formatted', fn (SOR $model) => Carbon::parse($model->effect_from)->format('d/m/Y'))
            ->addColumn('effect_to_formatted', fn (SOR $model) => Carbon::parse($model->effect_to)->format('d/m/Y'))
            ->addColumn('IsActive')
            ->addColumn('getUserName.emp_name')
            ->addColumn('IsApproved', function (SOR $model) {
                ($model->IsApproved == 0) ? 'pending' : 'Approved';
            });
        // ->addColumn('created_at_formatted');
        // ->addColumn('created_at_formatted', fn (SOR $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
        // ->addColumn('updated_at_formatted', fn (SOR $model) => Carbon::parse($model->updated_at)->format('d/m/Y H:i:s'));
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
            // Column::make('ID', 'id')
            //     ->makeInputRange(),

            Column::make('ITEM DETAILS', 'Item_details')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('DEPARTMENT ID', 'getDepartmentName.department_name')
                ->makeInputRange(),

            Column::make('DEPT CATEGORY ID', 'getDeptCategoryName.dept_category_name')
                ->makeInputRange(),

            Column::make('DESCRIPTION', 'description')
                ->sortable()
                ->searchable(),

            Column::make('UNIT', 'unit')
                ->makeInputRange(),

            Column::make('COST', 'cost')
                ->sortable()
                ->searchable(),

            Column::make('VERSION', 'version')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('EFFECT FROM', 'effect_from_formatted', 'effect_from')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker(),

            Column::make('EFFECT TO', 'effect_to_formatted', 'effect_to')
                ->searchable()
                ->sortable()
                ->makeInputDatePicker(),

            Column::make('ISACTIVE', 'IsActive')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('CREATED BY', 'getUserName.emp_name')
                ->makeInputRange(),
            //$canEdit = true;
            Column::make('ISAPPROVED', 'IsApproved')
                // ->toggleable($canEdit, 'yes', 'no')
                ->sortable()
                ->searchable()
                ->makeInputText(),
            // Button::make('Edit', 'Edit')
            // Column::make('CREATED AT', 'created_at_formatted', 'created_at')
            //     ->searchable()
            //     ->sortable()
            //     ->makeInputDatePicker(),

            // Column::make('UPDATED AT', 'updated_at_formatted', 'updated_at')
            //     ->searchable()
            //     ->sortable()
            //     ->makeInputDatePicker(),

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
     * PowerGrid SOR Action Buttons.
     *
     * @return array<int, Button>
     */


    public function actions(): array
    {
        return [
            Button::add('Edit')
                ->caption('Edit')
                ->class('btn btn-soft-warning btn-sm text-dark')
                // ->icon('fa-window')
                // ->html('')
                ->emit('openEntryForm', ['formType' => 'edit', 'id' => 'id'])
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
     * PowerGrid SOR Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($s-o-r) => $s-o-r->id === 1)
                ->hide(),
        ];
    }
    */
}