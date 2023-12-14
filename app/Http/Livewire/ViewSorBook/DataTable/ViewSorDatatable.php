<?php

namespace App\Http\Livewire\ViewSorBook\DataTable;

use App\Models\DynamicSorHeader;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class ViewSorDatatable extends PowerGridComponent
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
           /* Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),*/
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
		->orderBy('page_no_int');
        
	}
	else
	{
		if(Auth::user()->dept_category_id == null)
		{
			return DynamicSorHeader::query()
	 		->where('department_id','=',Auth::user()->department_id)
			->orderBy('page_no_int');
		}
		else
		{
			return DynamicSorHeader::query()
	 		->where('department_id','=',Auth::user()->department_id)
         		->where('dept_category_id','=',Auth::user()->dept_category_id)
	 		->orderBy('page_no_int');
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
             ->addColumn('getDeptCategoryName.dept_category_name')
            ->addColumn('table_no',function(DynamicSorHeader $dynamicSorHeader)
	     {
		return '<span class="text-wrap">'.$dynamicSorHeader->table_no.'</span>';
	     })

           
            ->addColumn('page_no')
            ->addColumn('title',function(DynamicSorHeader $dynamicSorHeader)
	    {
		return '<span class="text-wrap">'.$dynamicSorHeader->title.'</span>';
	    })
            ->addColumn('volume_no',function (DynamicSorHeader $dynamicSorHeader) {
                if($dynamicSorHeader->volume_no=='1')
                {
                    return 'Volume I';
                }
                else if($dynamicSorHeader->volume_no=='2')
                {
                    return 'Volume II';
                }
                else
                {
                    return 'Volume III';
                }
            })
	    ->addColumn('effective_date')
	    ->addColumn('effective_to')
	    ->addColumn('corrigenda_name');
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
            Column::make('DEPT CATEGORY', 'getDeptCategoryName.dept_category_name'),

            Column::make('TABLE NO', 'table_no')
                ->sortable()
                ->searchable(),
            Column::make('PAGE NO', 'page_no')
            	->sortable()
                ->searchable(),

            Column::make('TITLE', 'title')
                ->sortable()
                ->searchable(),

            Column::make('VOLUME NO', 'volume_no')
                ->sortable()
                ->searchable(),
	    
	    Column::make('Start Date', 'effective_date'),
	    Column::make('End Date', 'effective_to'),
	    Column::make('Corrigenda & Addenda', 'corrigenda_name')

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
            Button::add('View')->bladeComponent('view', ['id' => 'id']),
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
