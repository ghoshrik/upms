<?php

namespace App\Http\Livewire\SorBook\DataTable;

use Illuminate\Support\Carbon;
use App\Models\DynamicSorHeader;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class VolumeThreeSorTable extends PowerGridComponent
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
    * @return Builder<\App\Models\DynamicSorHeader>
    */
    public function datasource(): Builder
    {

	if(Auth::user()->id==592)
	{
		return DynamicSorHeader::query()
        ->where('volume_no','=','3')
	->orderBy('page_no_int');
        
	}
	else{
        if(Auth::user()->dept_category_id ==null)
	{
	   $dd = DynamicSorHeader::query()
        ->where('department_id',Auth::user()->department_id)
        ->where('volume_no','=','3')
	->where('created_by',Auth::user()->id)
	->orderBy('page_no_int');
        return $dd;
	}
        else{
	$dd = DynamicSorHeader::query()
        ->where('department_id',Auth::user()->department_id)
        ->where('dept_category_id',Auth::user()->dept_category_id)
        ->where('volume_no','=','3')
	->where('created_by',Auth::user()->id)
	->orderBy('page_no_int');
        return $dd;
	}
	}
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
           
            ->addColumn('table_no', function (DynamicSorHeader $dynamicSorHeader) {
                return '<span class="text-wrap">' . $dynamicSorHeader->table_no. '</span>';
            })
            ->addColumn('title', function (DynamicSorHeader $dynamicSorHeader) {
                return '<span class="text-wrap">' . $dynamicSorHeader->title . '</span>';
            })
            ->addColumn('page_no')
            ->addColumn('effective_date')
	    ->addColumn('effective_to')
	    ->addColumn('corrigenda_name')
	    ->addColumn('is_active',function (DynamicSorHeader $dynamicSorHeader){
		if($dynamicSorHeader->is_active==0)
		{
			return '<label class="badge badge-pill rounded bg-danger">Deactive</label>';
		}
		else
		{
			return '<label class="badge badge-pill rounded bg-success">Active</label>';
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
            // Column::make('ID', 'id')
            //     ->makeInputRange(),

            Column::make('DEPT CATEGORY', 'getDeptCategoryName.dept_category_name')
            	->sortable()
                ->searchable(),
            Column::make('TABLE NO', 'table_no')
                ->sortable()
                ->searchable(),
                // ->makeInputText(),
	     Column::make('TITLE', 'title')
		->sortable()
		->searchable(),
	     Column::make('PAGE NO', 'page_no')
                ->sortable()
                ->searchable(),
             Column::make('Effect Date', 'effective_date'),
	     Column::make('Effect To Date', 'effective_to'),
	     Column::make('Corrigenda & Addenda', 'corrigenda_name'),
	     Column::make('Status', 'is_active')


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
