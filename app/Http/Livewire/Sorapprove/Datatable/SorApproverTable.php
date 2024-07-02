<?php

namespace App\Http\Livewire\Sorapprove\DataTable;

use id;
use Illuminate\Support\Carbon;
use App\Models\DynamicSorHeader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class SorApproverTable extends PowerGridComponent
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
            // Exportable::make('export')
            //     ->striped()
            //     ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return DynamicSorHeader::query()
            ->where('department_id', Auth::user()->department_id)
            ->where('is_approve', '=', '-11');
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
            ->addColumn('getDeptCategoryName.dept_category_name')
            ->addColumn('volume_no', function (DynamicSorHeader $dynamicHeader) {
                if ($dynamicHeader->volume_no == '1') {
                    return '<label class="badge badge-pill bg-info rounded">Volume I</label></label>';
                } else if ($dynamicHeader->volume_no == '2') {
                    return '<label class="badge badge-pill bg-primary rounded">Volume II</label></label>';
                } else {
                    return '<label class="badge badge-pill bg-warning rounded ">Volume III</label></label>';
                }
            })
            ->addColumn('title')
            ->addColumn('table_no')
            ->addColumn('page_no')
            ->addColumn('is_approve', function (DynamicSorHeader $dynamicHeader) {
                if ($dynamicHeader->is_approve === '-11' && $dynamicHeader->is_verified === '-09') {
                    return "<label class='badge badge-pill bg-success cursor-pointer'>Verified</label>";
                } else {
                    return "<label class='badge badge-pill bg-warning cursor-pointer'>Pending</label>";
                }
            });
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
            Column::make('CATEGORY', 'getDeptCategoryName.dept_category_name'),
            Column::make('VOLUME NO', 'volume_no')
                ->sortable()
                ->searchable(),
            Column::make('TITLE', 'title')
                ->sortable()
                ->searchable(),
            Column::make('TABLE NO', 'table_no')
                ->sortable()
                ->searchable(),

            Column::make('PAGE NO', 'page_no')
                ->sortable()
                ->searchable(),
            Column::make('Status', 'is_approve')
                ->sortable(),
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
     * PowerGrid DynamicSorHeader Action Buttons.
     *
     * @return array<int, Button>
     */

    public function actions(): array
    {
        return [
            Button::add('View & Edit')
                ->bladeComponent('view', ['id' => 'id', 'message' => 'View', 'position' => 'top']),
        ];
    }
    public function view($id)
    {
        $this->emit('openEntryForm', ['formType' => 'view', 'id' => $id]);
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid DynamicSorHeader Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($dynamic-sor-header) => $dynamic-sor-header->id === 1)
                ->hide(),
        ];
    }
    */
}
