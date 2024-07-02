<?php

namespace App\Http\Livewire\AssignOfficeAdmin;

use App\Models\Menu;
use App\Models\Office;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class OfficeAssignModel extends PowerGridComponent
{
    use ActionButton;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(),
            [
                'filterOfficeAssign',
                'bulkActionEvent',
            ]
        );
    }
    // public $searchCondition;
    public function filterOfficeAssign($levelNo)
    {
        dd($levelNo);
        // $this->searchCondition = $levelNo;
        // dd($this->searchCondition);
    }


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
        dd($this->searchCondition);
        $office = Office::leftJoin('users', function ($join) {
            $join->on('offices.id', '=', 'users.office_id')
                ->where('users.user_type', 4);
        })
            ->where($this->searchCondition)
            ->where('offices.department_id', Auth::user()->department_id)
            ->select('offices.id as id', 'offices.office_name', 'offices.office_address', 'offices.office_code', 'offices.level_no', 'offices.dist_code', 'users.id as user_id')
            ->orderBy('users.id', 'asc')
            ->get();
        return dd($office);
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
            ->addColumn('office_name')
            ->addColumn('office_address')
            ->addColumn('level_no')
            ->addColumn('dist_code')
            ->addColumn('user_id');
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

            Column::make('TITLE', 'office_name')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('PARENT ID', 'office_address')
                ->makeInputRange(),

            Column::make('ICON', 'level_no')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('LINK', 'dist_code')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('LINK TYPE', 'user_id')
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

    /*
    public function actions(): array
    {
       return [
           Button::make('edit', 'Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('menu.edit', ['menu' => 'id']),

           Button::make('destroy', 'Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('menu.destroy', ['menu' => 'id'])
               ->method('delete')
        ];
    }
    */

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
