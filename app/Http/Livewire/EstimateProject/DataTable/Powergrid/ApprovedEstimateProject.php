<?php

namespace App\Http\Livewire\EstimateProject\DataTable\Powergrid;

use App\Models\SorMaster;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};
use Spatie\Permission\Models\Role;

final class ApprovedEstimateProject extends PowerGridComponent
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
    * @return Builder<\App\Models\SorMaster>
    */
    public function datasource(): Builder
    {
        return SorMaster::select(
            'sor_masters.estimate_id',
            'sor_masters.sorMasterDesc',
            'sor_masters.id',
            'estimate_prepares.total_amount',
            'estimate_flows.sequence_no',
            'estimate_statuses.status',
            'sor_masters.associated_with'
        )
            ->distinct('sor_masters.estimate_id')
            ->leftJoin('estimate_prepares', 'estimate_prepares.estimate_id', '=', 'sor_masters.estimate_id')
            ->leftJoin('estimate_flows', 'sor_masters.estimate_id', '=', 'estimate_flows.estimate_id')
            ->leftJoin('estimate_statuses', 'estimate_statuses.id', '=', 'sor_masters.status')
            ->where('estimate_prepares.operation','=','Total')
            ->where('sor_masters.associated_with',Auth::user()->id)
            ->where('estimate_flows.user_id',Auth::user()->id)
            ->where('sor_masters.is_verified',1)
            ->groupBy(
                'sor_masters.estimate_id',
                'sor_masters.id',
                'estimate_flows.estimate_id',
                'estimate_flows.sequence_no',
                'estimate_statuses.status',
                'estimate_prepares.total_amount',
                'sor_masters.associated_with'
            )
            ->orderBy('sor_masters.estimate_id')
            ->orderBy('estimate_flows.sequence_no');

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
            ->addColumn('estimate_id')
            ->addColumn('sorMasterDesc')
            ->addColumn('sor_masters.associated_with',function ($row){
                $user = User::find($row->associated_with);

                return "<strong>".$user->getOfficeName->office_name ."</strong>";
            })
            ->addColumn('associated_with',function($row)
            {
                $role= Role::findById($row->associated_with);
                return "<span class='badge badge-pill bg-primary'>".$role->name."</span>";
            })
            ->addColumn('total_amount',function($row)
            {
                return number_format($row->total_amount,2);
            })
            ->addColumn('approved_at_formatted', fn (SorMaster $model) => Carbon::parse($model->approved_at)->format('d/m/Y H:i:s'))
            ->addColumn('created_by');
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

            Column::make('ESTIMATE', 'estimate_id')
            ->searchable(),
            Column::make('PROJECT DESCRIPTION ', 'sorMasterDesc')
                ->sortable()
                ->searchable(),
            Column::make('Office', 'sor_masters.associated_with')
            ->searchable(),
            Column::make('APPROVE NAME  ', 'associated_with'),

            Column::make('Total Amount','total_amount')
            ->searchable(),
            Column::make('APPROVED', 'approved_at_formatted', 'approved_at')
                ->sortable(),

            Column::make('Created','created_by')
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
     * PowerGrid SorMaster Action Buttons.
     *
     * @return array<int, Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::make('edit', 'Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('s-o-r-master.edit', ['s-o-r-master' => 'id']),

           Button::make('destroy', 'Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('s-o-r-master.destroy', ['s-o-r-master' => 'id'])
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
     * PowerGrid SorMaster Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($s-o-r-master) => $s-o-r-master->id === 1)
                ->hide(),
        ];
    }
    */
}
