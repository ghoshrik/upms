<?php

namespace App\Http\Livewire\SorBook\DataTable;

use App\Models\DynamicSorHeader;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
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

final class SorHeaderTable extends PowerGridComponent
{
    use ActionButton;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
     */
    public $selectVolume;
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
     * @return Builder<\App\Models\DynamicSorHeader>
     */
    public function datasource(): Builder
    {
        $query = DynamicSorHeader::query()
            ->where('department_id', Auth::user()->department_id)
            ->where('volume_no', $this->selectVolume)
            ->where('created_by', Auth::user()->id);
        return $query;
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
        //->addColumn('id')
            ->addColumn('getDeptCategoryName.dept_category_name')
            ->addColumn('volume_no')
            ->addColumn('table_no')

        /** Example of custom column using a closure **/
            ->addColumn('table_no_lower', function (DynamicSorHeader $model) {
                return strtolower(e($model->table_no));
            })

            ->addColumn('page_no')
            ->addColumn('header_data');
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
            //Column::make('ID', 'id')
            //->makeInputRange(),
            Column::make('DEPT CATEGORY', 'getDeptCategoryName.dept_category_name')
            // ->sortable()
                ->searchable(),
            Column::make('VOLUME NO', 'volume_no')
                ->sortable()
                ->searchable()
                ->makeInputText(),
            Column::make('TABLE NO', 'table_no')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('PAGE NO', 'page_no')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            // Column::make('HEADER DATA', 'header_data')
            //     ->sortable()
            //     ->searchable(),

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
     * PowerGrid DynamicSorHeader Action Buttons.
     *
     * @return array<int, Button>
     */

    public function actions(): array
    {
        return [
            Button::add('View')
                ->bladeComponent('view', ['id' => 'id']),
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
