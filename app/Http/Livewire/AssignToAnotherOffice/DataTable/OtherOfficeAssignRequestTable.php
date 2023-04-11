<?php

namespace App\Http\Livewire\AssignToAnotherOffice\DataTable;

use App\Models\Designation;
use App\Models\OtherOfficeAssignRequest;
use App\Models\Role;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class OtherOfficeAssignRequestTable extends PowerGridComponent
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
        // $this->showCheckBox();

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
    * @return Builder<\App\Models\OtherOfficeAssignRequest>
    */
    public function datasource(): Builder
    {
        return OtherOfficeAssignRequest::query()
        ->select(
            'other_office_assign_requests.id as id',
            'other_office_assign_requests.roles as roles',
            'other_office_assign_requests.status as status',
            'other_office_assign_requests.office_id as office_id',
            'users.emp_name as emp_name',
            'users.ehrms_id as ehrms_id',
            'users.designation_id as designation_id',
            'users.mobile as mobile_no',
            'offices.office_code as office_code',
        )
        ->join('users','users.id','=','other_office_assign_requests.user_id')
        ->join('offices','offices.id','=','other_office_assign_requests.office_id')
        ->where(function($query){
            $query->where('other_office_assign_requests.office_id',Auth::user()->office_id)
            ->orWhere('other_office_assign_requests.request_from',Auth::user()->id);
        })
        ;
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
            // ->addColumn('request_from')
            ->addColumn('emp_name')
            ->addColumn('ehrms_id')
            ->addColumn('office_code')
            ->addColumn('mobile_no')
            ->addColumn('designation_id', function (OtherOfficeAssignRequest $model) {
                $designationName = Designation::select('designation_name')->where('id',$model->designation_id)->first();
                return strtoupper(e($designationName->designation_name));
            })
           /** Example of custom column using a closure **/
            ->addColumn('roles', function (OtherOfficeAssignRequest $model) {
                $roles= explode(',',$model->roles);
                $roleName = '';
                foreach ($roles as $key => $role) {
                    $role = Role::select('name')->where('id',$role)->first();
                    $roleName .=$role->name.',';
                }
                return strtoupper(e($roleName));
            })

            ->addColumn('status', function (OtherOfficeAssignRequest $model) {
                $currentStatus = '';
                switch ($model->status) {
                    case 0:
                        $currentStatus = 'Pending for acceptance.';
                        break;
                    case 1:
                        $currentStatus = 'Accepted.';
                        break;
                    default:
                        # code...
                        break;
                }
                return e($currentStatus);
            })
            // ->addColumn('remarks')
            ->addColumn('created_at_formatted', fn (OtherOfficeAssignRequest $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
            // ->addColumn('updated_at_formatted', fn (OtherOfficeAssignRequest $model) => Carbon::parse($model->updated_at)->format('d/m/Y H:i:s'));
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
            Column::make('ID', 'id'),
                // ->makeInputRange(),

            // Column::make('REQUEST FROM', 'request_from')
            //     ->makeInputRange(),

            Column::make('OFFICE CODE', 'office_code'),
                // ->makeInputRange(),

            Column::make('EMPLOY CODE', 'ehrms_id'),
                // ->makeInputRange(),

            Column::make('EMPLOY NAME', 'emp_name'),
                // ->makeInputRange(),

            Column::make('DESIGNATION', 'designation_id'),
                // ->makeInputRange(),

            Column::make('MOBILE', 'mobile_no'),
            // ->makeInputRange(),

            Column::make('ROLES', 'roles')
                ->sortable(),

            Column::make('STATUS', 'status'),

            // Column::make('REMARKS', 'remarks')
            //     ->sortable(),

            Column::make('CREATED AT', 'created_at_formatted', 'created_at')
                ->searchable(),

            // Column::make('UPDATED AT', 'updated_at_formatted', 'updated_at')
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
     * PowerGrid OtherOfficeAssignRequest Action Buttons.
     *
     * @return array<int, Button>
     */

    public function actions(): array
    {
       return [
           Button::make('accept', 'Accept')
               ->class('btn btn-soft-primary btn-sm'),

           Button::make('reject', 'Reject')
               ->class('btn btn-soft-danger btn-sm'),
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
     * PowerGrid OtherOfficeAssignRequest Action Rules.
     *
     * @return array<int, RuleActions>
     */
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('accept')
                ->when(function($model){
                    return $model->office_id!=Auth::user()->office_id;
                })
                ->hide(),
            Rule::button('reject')
            ->when(function($model){
                return $model->office_id!=Auth::user()->office_id;
            })
            ->hide(),
        ];
    }
}
