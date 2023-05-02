<?php

namespace App\Http\Livewire\Designation\Powergrid;

use App\Models\Designation;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class DesignationDatatable extends PowerGridComponent
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
                ->type(Exportable::TYPE_XLS),
            // ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
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
    public $dataView = [];
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
        $ModelList = [trans('cruds.designation.fields.designation_name') => '22%'];
        if (count($this->checkboxValues) == 0) {
            $designation = Designation::get();

            $i = 1;
            foreach ($designation as $key => $offices) {
                $this->dataView[] = [
                    'id' => $i,
                    'title' => $offices->designation_name
                ];
                $i++;
            }
            return generatePDF($ModelList, $this->dataView, trans('cruds.designation.title_singulars'));
        } else {

            $ids = implode(',', $this->checkboxValues);
            $offices = Designation::whereIn('id', explode(",", $ids))->get();
            $i = 1;
            foreach ($offices as $key => $office) {
                $dataView[] = [
                    'id' => $i,
                    'title' => $office->designation_name,
                ];
                $i++;
            }

            return generatePDF($ModelList, $dataView, trans('cruds.designation.title'));
            $this->resetExcept('checkboxValues', 'dataView');
        }
    }



    /**
     * PowerGrid datasource.
     *
     * @return Builder<\App\Models\Designation>
     */
    public function datasource(): Builder
    {
        return Designation::query()
            ->select(
                'id',
                'designation_name',
                DB::raw('ROW_NUMBER() OVER (ORDER BY designations.id) as serial_no')
            );
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
            ->addColumn('serial_no')
            ->addColumn('designation_name')

            /** Example of custom column using a closure **/
            ->addColumn('designation_name_lower', function (Designation $model) {
                return strtolower(e($model->designation_name));
            });

        // ->addColumn('created_at_formatted', fn (Designation $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
        // ->addColumn('updated_at_formatted', fn (Designation $model) => Carbon::parse($model->updated_at)->format('d/m/Y H:i:s'));
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
            Column::make('SL. No.', 'serial_no'),
            // ->makeInputRange(),

            Column::make('DESIGNATION NAME', 'designation_name')
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
     * PowerGrid Designation Action Buttons.
     *
     * @return array<int, Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::make('edit', 'Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('designation.edit', ['designation' => 'id']),

           Button::make('destroy', 'Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('designation.destroy', ['designation' => 'id'])
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
     * PowerGrid Designation Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($designation) => $designation->id === 1)
                ->hide(),
        ];
    }
    */
}
