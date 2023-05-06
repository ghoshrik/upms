<?php

namespace App\Http\Livewire\Aafs\Datatable;

use App\Models\AAFS;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class AafsDatatable extends PowerGridComponent
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
                'rowActionEvent',
                'bulkActionEvent',
            ]
        );
    }

    public function header(): array
    {
        return [
            Button::add('bulk-demo')
                ->caption('PDF')
                ->class('cursor-pointer btn btn-soft-primary btn-sm')
                ->emit('bulkActionEvent', [])
        ];
    }

    public function bulkActionEvent()
    {
        $ModelList = [
            'Project No' => '5%',
            'Department Name' => '5%',
            'Surrent Status' => '5%',
            'Project Cost' => '4%',
            'Tender Cost' => '4%',
            'AAFS Mother ID' => '4%',
            'AAFS Sub ID' => '4%',
            'Project Type' => '5%',
            'Status' => '4%',
            'Complete Period' => '4%',
            'Un No' => '4%',
            'Go No' => '4%',
            'Pre aafs Exp' => '5%',
            'Post aafs Exp' => '5%',
            'Fund cty' => '5%',
            'Exe Authority' => '5%'
        ];
        if (count($this->checkboxValues) == 0) {
            $AAFS = AAFS::where('dept_id', Auth::user()->department_id)->get();
            $i = 1;
            foreach ($AAFS as $key => $list) {
                $dataView[] = [
                    '1' => $i,
                    '2' => $list->project_no,
                    '3' => $list->getDepartmentName->department_name,
                    '4' => $list->statusName->status,
                    '5' => $list->project_cost,
                    '6' => $list->tender_cost,
                    '7' => $list->aafs_mother_id,
                    '8' => $list->aafs_sub_id,
                    '9' => $list->status,
                    '10' => $list->project_type,
                    '11' => $list->completePeriod,
                    '12' => $list->unNo,
                    '13' => $list->goNo,
                    '14' => $list->preaafsExp,
                    '15' => $list->postaafsExp,
                    '16' => $list->Fundcty,
                    '17' => $list->exeAuthority,
                ];
                $i++;
            }
            return generatePDF($ModelList, $dataView, trans('cruds.aafs_project.title_singular'));
        }
        $ids = implode(',', $this->checkboxValues);
        $AAFS = AAFS::whereIn('id', explode(",", $ids))->where('dept_id', Auth::user()->department_id)->get();
        $i = 1;
        foreach ($AAFS as $key => $list) {
            $dataView[] = [
                '1' => $i,
                '2' => $list->project_no,
                '3' => $list->getDepartmentName->department_name,
                '4' => $list->statusName->status,
                '5' => $list->project_cost,
                '6' => $list->tender_cost,
                '7' => $list->aafs_mother_id,
                '8' => $list->aafs_sub_id,
                '9' => $list->status,
                '10' => $list->completePeriod,
                '11' => $list->unNo,
                '12' => $list->goNo,
                '13' => $list->preaafsExp,
                '14' => $list->postaafsExp,
                '15' => $list->Fundcty,
                '16' => $list->exeAuthority,
            ];
            $i++;
        }
        return generatePDF($ModelList, $dataView, trans('cruds.aafs_project.title_singular'));
        $this->resetExcept('checkboxValues', 'dataView');
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
     * @return Builder<\App\Models\AAFS>
     */
    public function datasource(): Builder
    {
        return AAFS::query();
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
            ->addColumn('project_no')
            ->addColumn('getDepartmentName.department_name')
            ->addColumn('statusName.status')

            /** Example of custom column using a closure **/
            ->addColumn('status_id_lower', function (AAFS $model) {
                return strtolower(e($model->status_id));
            })

            ->addColumn('project_cost')
            ->addColumn('tender_cost')
            ->addColumn('aafs_mother_id')
            ->addColumn('aafs_sub_id')
            ->addColumn('project_type')
            ->addColumn('status')
            ->addColumn('complete Period')
            ->addColumn('unNo')
            ->addColumn('goNo')
            ->addColumn('pre aafs Exp')
            ->addColumn('post aafs Exp')
            ->addColumn('Fund cty')
            ->addColumn('Exe Authority');
        // ->addColumn('created_at_formatted', fn (AAFS $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
        // ->addColumn('updated_at_formatted', fn (AAFS $model) => Carbon::parse($model->updated_at)->format('d/m/Y H:i:s'));
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

            Column::make('PROJECT NO', 'project_no')
                ->makeInputRange(),

            Column::make('DEPARTMENT NAME', 'getDepartmentName.department_name')
                ->makeInputRange(),

            Column::make('CURRENT STATUS', 'statusName.status')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('PROJECT COST', 'project_cost')
                ->sortable()
                ->searchable(),

            Column::make('TENDER COST', 'tender_cost')
                ->sortable()
                ->searchable(),

            Column::make('AAFS MOTHER ID', 'aafs_mother_id')
                ->makeInputRange(),

            Column::make('AAFS SUB ID', 'aafs_sub_id')
                ->makeInputRange(),

            Column::make('PROJECT TYPE', 'project_type')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('STATUS', 'status')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('COMPLETEPERIOD', 'completePeriod')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('UN NO', 'unNo')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('GO NO', 'goNo')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('PRE AAFS EXP', 'preaafsExp')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('POST AAFS EXP', 'postaafsExp')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('Fund Released', 'Fundcty')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('EXE AUTHORITY', 'exeAuthority')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            // Column::make('CREATED AT', 'created_at_formatted', 'created_at')
            //     ->searchable()
            //     ->sortable()
            //     ->makeInputDatePicker(),

            // Column::make('UPDATED AT', 'updated_at_formatted', 'updated_at')
            //     ->searchable()
            //     ->sortable()
            //     ->makeInputDatePicker(),

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
     * PowerGrid AAFS Action Buttons.
     *
     * @return array<int, Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::make('edit', 'Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('a-a-f-s.edit', ['a-a-f-s' => 'id']),

           Button::make('destroy', 'Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('a-a-f-s.destroy', ['a-a-f-s' => 'id'])
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
     * PowerGrid AAFS Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($a-a-f-s) => $a-a-f-s->id === 1)
                ->hide(),
        ];
    }
    */
}
