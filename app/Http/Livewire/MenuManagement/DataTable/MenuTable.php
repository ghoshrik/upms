<?php

namespace App\Http\Livewire\MenuManagement\DataTable;

use App\Models\Menu;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class MenuTable extends PowerGridComponent
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
     * @return Builder<\App\Models\Menu>
     */
    public function datasource(): Builder
    {
        return Menu::query();
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
            ->addColumn('title')

            /** Example of custom column using a closure **/
            ->addColumn('title_lower', function (Menu $model) {
                return strtolower(e($model->title));
            })

            ->addColumn('parent_id')
            ->addColumn('icon')
            ->addColumn('link')
            ->addColumn('link_type')
            ->addColumn('permissions_roles')
            ->addColumn('permission_or_role');
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

            Column::make('TITLE', 'title')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('PARENT ID', 'parent_id')
                ->makeInputRange(),

            Column::make('ICON', 'icon')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('LINK', 'link')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('LINK TYPE', 'link_type')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('PERMISSIONS ROLES', 'permissions_roles')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('PERMISSION OR ROLE', 'permission_or_role')
                ->sortable()
                ->searchable()
                ->makeInputText(),

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
     * PowerGrid Menu Action Buttons.
     *
     * @return array<int, Button>
     */

    public function actions(): array
    {
        return [
            Button::add('edit')
                ->caption('Edit')
                ->class('btn btn-soft-primary btn-sm')
                ->emit('openEntryForm', ['id' => 'id','formType'=>'edit']),
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
     * PowerGrid Menu Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($menu) => $menu->id === 1)
                ->hide(),
        ];
    }
    */
}
