<?php

namespace App\Http\Livewire\NonSchedule\DataTable;

use App\Models\NonSor;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class NonScheduleList extends PowerGridComponent
{
    use ActionButton;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function header(): array
    {
        return [
            Button::add('bulk-demo')
                ->caption('Bulk Forward')
                ->class('cursor-pointer btn btn-soft-primary btn-sm')
//                ->disabled(count($this->checkboxValues) == 0)
                ->emit('bulkActionEvent', [])
        ];
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
    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(), [
            'edit',
            'forward',
            'bulkActionEvent'
        ]);
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
    * @return Builder<\App\Models\NonSor>
    */
    public function datasource(): Builder
    {
        return NonSor::query()
            ->where('associated_at',Auth::user()->id);

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
        return [
            'units'=>['unit_name']
        ];
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
            ->addColumn('item_name',function($row){
                return strip_tags($row->item_name);
            })
            ->addColumn('units.unit_name')
            ->addColumn('price');
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
            Column::make('Item Name', 'item_name')
            ->searchable()
                ->sortable(),
            Column::make('Unit', 'units.unit_name')
            ->searchable()
                ->sortable(),
            Column::make('Price', 'price')
            ->searchable()
                ->sortable(),
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
     * PowerGrid NonSor Action Buttons.
     *
     * @return array<int, Button>
     */

    public function actions(): array
    {
       return [
           Button::add('edit')
               ->caption('Edit')
               ->class('btn-sm btn-soft-warning px-3 py-2.5 rounded-pill')
               ->emit('edit',['id'=>'id']),
           Button::add('forward')
               ->caption('Forward')
               ->class('btn-sm btn-soft-success px-3 py-2.5 rounded-pill')
               ->emit('openNonScheduleList',['project_id'=>'id']),
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
     * PowerGrid NonSor Action Rules.
     *
     * @return array<int, RuleActions>
     */

     public function edit($id)
     {
        dd($id);
     }
     public function bulkActionEvent():void
     {
        if (count($this->checkboxValues) == 0) {
            $this->dispatchBrowserEvent('showAlert', ['message' => 'You must select at least one item!']);

            return;
        }
        dd(count($this->checkboxValues));
     }
    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($non-sor) => $non-sor->id === 1)
                ->hide(),
        ];
    }
    */
}
