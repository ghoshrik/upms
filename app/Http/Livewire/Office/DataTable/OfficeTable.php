<?php

namespace App\Http\Livewire\Office\DataTable;

use App\Models\Office;
use WireUi\Traits\Actions;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class OfficeTable extends PowerGridComponent
{
    use ActionButton, Actions;

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

    public function header(): array
    {
        return [
            Button::add('bulk-demo')
                ->caption('PDF')
                ->class('cursor-pointer btn btn-danger btn-sm')
                ->emit('bulkActionEvent', [])
        ];
    }

    public function bulkActionEvent(): void
    {
        if (count($this->checkboxValues) == 0) {
            // $this->dispatchBrowserEvent('showAlert', ['message' => 'You must select at least one item!']);
            $this->dialog()->error(
                $title = 'Error !!!',
                $description = 'You must select at least one item!'
            );
            return;
        }

        $ids = implode(', ', $this->checkboxValues);

        $this->dispatchBrowserEvent('showAlert', ['message' => 'You have selected IDs: ' . $ids]);
        $this->dialog()->warning(
            // $title = 'Error !!!',
            $description = 'PDF generation under process'
        );
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
     * @return Builder<\App\Models\Office>
     */
    public function datasource(): Builder
    {
        return Office::query()
            ->select(
                'office_name',
                 'department_id',
                  'dist_code',
                  'in_area',
                  'rural_block_code',
                  'gp_code', 'urban_code',
                  'ward_code',
                  'office_address',
                  'level_no',
                  'office_code',DB::raw('ROW_NUMBER() OVER (ORDER BY offices.id) as serial_no'))
            ->where('offices.department_id', Auth::user()->department_id);;
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
            ->addColumn('office_name')

            /** Example of custom column using a closure **/
            ->addColumn('office_name_lower', function (Office $model) {
                return strtolower(e($model->office_name));
            })

            ->addColumn('getDepartmentName.department_name')
            ->addColumn('getDistrictName.district_name')
            // ->addColumn('in_area')
            // ->addColumn('rural_block_code')
            // ->addColumn('gp_code')
            // ->addColumn('urban_code')
            // ->addColumn('ward_code')
            ->addColumn('office_address')
            ->addColumn('level_no', function (Office $model) {
                switch ($model->level_no) {
                    case 1:
                        return '<span class="badge rounded-pill bg-primary text-dark">Level 1 Office </span>';
                        break;
                    case 2:
                        return '<span class="badge rounded-pill bg-secondary">Level 2 Office </span>';
                        break;
                    case 3:
                        return '<span class="badge rounded-pill bg-success">Level 3 Office </span>';
                        break;
                    case 4:
                        return '<span class="badge rounded-pill bg-info">Level 4 Office </span>';
                        break;
                    case 5:
                        return '<span class="badge rounded-pill bg-warning">Level 5 Office </span>';
                        break;
                    default:
                        return '<span class="badge rounded-pill bg-dark">Level 6 Office</span>';
                }
            })
            ->addColumn('office_code');
        // ->addColumn('created_at_formatted', fn (Office $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
        // ->addColumn('updated_at_formatted', fn (Office $model) => Carbon::parse($model->updated_at)->format('d/m/Y H:i:s'));
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
            //     ->makeInputRange(),

            Column::make('OFFICE NAME', 'office_name')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('DEPARTMENT name', 'getDepartmentName.department_name')
                ->makeInputRange(),

            Column::make('DIST name', 'getDistrictName.district_name')
                ->makeInputRange(),

            // Column::make('IN AREA', 'in_area')
            //     ->makeInputRange(),

            // Column::make('RURAL BLOCK CODE', 'rural_block_code')
            //     ->makeInputRange(),

            // Column::make('GP CODE', 'gp_code')
            //     ->makeInputRange(),

            // Column::make('URBAN CODE', 'urban_code')
            //     ->makeInputRange(),

            // Column::make('WARD CODE', 'ward_code')
            //     ->makeInputRange(),

            Column::make('OFFICE ADDRESS', 'office_address')
                ->sortable()
                ->searchable(),

            Column::make('LEVEL NO', 'level_no')
                ->makeInputRange(),

            Column::make('OFFICE CODE', 'office_code')
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
     * PowerGrid Office Action Buttons.
     *
     * @return array<int, Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::make('edit', 'Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('office.edit', ['office' => 'id']),

           Button::make('destroy', 'Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('office.destroy', ['office' => 'id'])
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
     * PowerGrid Office Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($office) => $office->id === 1)
                ->hide(),
        ];
    }
    */
}
