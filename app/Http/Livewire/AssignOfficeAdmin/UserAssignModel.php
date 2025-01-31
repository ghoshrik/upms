<?php

namespace App\Http\Livewire\AssignOfficeAdmin;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use WireUi\Traits\Actions;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class UserAssignModel extends PowerGridComponent
{
    use ActionButton,Actions;

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
     * @return Builder<\App\Models\User>
     */

    public $openAssignAdminId, $openFormModel,$modelOpen;
    public function assignuser($office_id,$dist_code,$level_no)
    {
        // dd($office_id,$dist_code,$level_no);
        $this->openAssignAdminId = $office_id;
    }

    protected function getListeners(): array
    {
        return array_merge(
            parent::getListeners(),
            ['assignuser',]
        );
    }

    public function datasource(): Builder
    {
        return User::query()
            // ->select(
            //     'users.id',
            //     'users.emp_name',
            //     'users.designation_id',
            //     'users.mobile',
            //     'users.email',
            //     'users.office_id',
                // 'designations.id as designationId',
                // 'designations.designation_name',
            //     'offices.id as officeId'
            // )
            // ->join('designations', 'users.designation_id', '=', 'designations.id',)
            // ->join('offices', 'users.office_id', '=', 'offices.id')
            ->where('users.user_type',4)
            ->where('users.is_active',1)
            ->where('users.department_id',Auth::user()->department_id)
            ->where('users.office_id', '=', 0);
        // dd($res);
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
            ->addColumn('NAME OF THE HOO')
            ->addColumn('getDesignationName.designation_name')
            ->addColumn('MOBILE NO')
            ->addColumn('email')
            ->addColumn('Action', function (User $user) {

                // if ($user->is_active == 0) {
                //     return '<label wire:click="toggleSelectedActive(' . $user->id . ')" class="badge badge-pill bg-danger cursor-pointer">Inactive</label>';
                // } else {
                //     return '<label wire:click="toggleSelectedInactive(' . $user->id . ')" class="badge badge-pill bg-success cursor-pointer">Active</label>';
                // }
                // return '<label wire:click="SelectedActive(' . $user->id . ',' . $user->office_id . ')" class="badge badge-pill bg-danger cursor-pointer">Inactive</label>';
                // if ($user->office_id == null) {
                //     return '<button class="btn btn-primary cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm btn-sm" type="button" wire:click="SelectedActive(' . $user->id . ',' . $user->officeId . ')">Save</button>';
                // } else {
                //     return '<label wire:click="SelectedModify(' . $user->id . ',' . $user->officeId . ')" class="badge badge-pill bg-danger cursor-pointer">Modify</label>';
                //     // return '<label wire:click="$emit(openModal)" class="badge badge-pill bg-danger cursor-pointer">Modify</label>';
                //     // return
                // }
                // if($user)
                // {

                // }

            //     return view('livewire.assign-office-admin.assign-office-list',['userId'=>$user->id,'officeId'=>$user->officeId,'userOffice'=>$user->office_id]);
                    return '<button type="button" class="btn btn-primary cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm btn-sm" wire:click="SaveUser('.$user->id.')">Save</button>';
            });
            // ->addColumn('Action');
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
                ->searchable()
                ->sortable(),

            Column::make('NAME OF THE HOO', 'emp_name')
                ->searchable()
                ->sortable(),
            Column::make('DESIGNATION', 'getDesignationName.designation_name')
                ->searchable()
                ->sortable()
                ->makeInputText(),
            Column::make('MOBILE', 'mobile')
                ->searchable()
                ->sortable()
                ->makeInputText(),
            Column::make('EMAIL', 'email')
                ->searchable()
                ->sortable(),
            Column::make('Action', 'Action')
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
     * PowerGrid User Action Buttons.
     *
     * @return array<int, Button>
     */

    /*
    public function actions(): array
    {
        // $this->showCheckBox();
        return [

            Button::add('View')
                ->caption('View')
                ->class('btn btn-primary cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm btn-sm')
                ->emit('openModal', ['id']),
            // Button::make('save', 'Save')
            //     ->class('btn btn-primary cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm btn-sm'),

            // Button::make('modify', 'Modify')
            //     ->class('cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm btn btn-warning btn-sm')
            //    ->route('user.destroy', ['user' => 'id'])
            //    ->method('delete')
        ];
    }*/


    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid User Action Rules.
     *
     * @return array<int, RuleActions>
     */
    public function SaveUser($id)
    {
        // dd($id);
        User::where('id',$id)->update(['office_id'=>$this->openAssignAdminId]);
        $this->notification()->success(
            $title = "user assign successfully"
        );
        return;
    }
    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($user) => $user->id === 1)
                ->hide(),
        ];
    }
    */
}
