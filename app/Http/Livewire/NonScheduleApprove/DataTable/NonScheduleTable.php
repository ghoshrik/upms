<?php

namespace App\Http\Livewire\NonScheduleApprove\DataTable;

use App\Models\NonSor;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};
use WireUi\Traits\Actions;

final class NonScheduleTable extends PowerGridComponent
{
    use ActionButton,Actions;

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
    protected function getListeners()
    {
        return array_merge(
            parent::getListeners(), [
            'approveNonSor',
            'bulkActionEvent'
        ]);
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
    * @return Builder<\App\Models\NonSor>
    */
    public function datasource(): Builder
    {
        return NonSor::query()
            ->where('associated_at',Auth::user()->id)
            ->with('units');
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

            Column::make('ITEM NAME', 'item_name')
                ->sortable()
                ->searchable(),

            Column::make('UNIT', 'units.unit_name')
                ->searchable(),
            Column::make('PRICE', 'price')
                ->sortable()
                ->searchable(),

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
           Button::make('approve', 'Approved')
               ->class('btn-sm btn-soft-success px-3 py-2.5 rounded-pill ')
                ->emit('approveNonSor',['project_id'=>'id']),
//               ->route('non-sor.edit', ['non-sor' => 'id']),

//           Button::make('destroy', 'Delete')
//               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
//               ->route('non-sor.destroy', ['non-sor' => 'id'])
//               ->method('delete')
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


    public function actionRules(): array
    {
       return [
            Rule::button('approve')
                ->when(fn($row) => $row->approved_at !='')
                ->hide(),
        ];
    }

    public function approveNonSor($id)
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure want to Approved Estimate ?',
            'icon' => 'warning',
            'accept' => [
                'label' => 'Yes,Approved',
                'method' => 'ApprovedNonsor',
                'params' => $id,
            ],
            'reject' => [
                'label' => 'No, Reject',
                // 'method' => 'cancel',
            ]
        ]);
    }

    public function ApprovedNonsor($id)
    {
        NonSor::where('id',$id)->update(['approved_by'=>Auth::user()->id,'approved_at'=>Carbon::now()]);
        $this->notification()->success(
            $description = 'Non Schedule Rate Item Approved'
        );
    }
}
