<?php

namespace App\Http\Livewire\Sor\DataTable;

use App\Models\SOR;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class SorDataTable extends PowerGridComponent
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
     * @return Builder<\App\Models\SOR>
     */
    public function datasource(): Builder
    {
        return SOR::query()
            ->where('s_o_r_s.department_id', Auth::user()->department_id)
            ->where('s_o_r_s.created_by', Auth::user()->id)
            ->select(
                'id',
                'Item_details',
                // 'department_id',
                'dept_category_id',
                'description',
                'unit_id',
                'unit',
                'cost',
                'version',
                'effect_from',
                'effect_to',
                'is_active',
                'created_by',
                'is_approved',
                DB::raw('ROW_NUMBER() OVER (ORDER BY s_o_r_s.id) as serial_no')
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
            ->addColumn('Item_details')

            /** Example of custom column using a closure **/
            ->addColumn('Item_details', function (SOR $model) {
                return strtolower(e($model->Item_details));
            })

            // ->addColumn('getDepartmentName.department_name')
            ->addColumn('getDeptCategoryName.dept_category_name')
            ->addColumn('description', function (SOR $model) {
                return '<span class="text-wrap">' . $model->description . '</span>';
            })
            ->addColumn('getUnitsName.unit_name')
            ->addColumn('quantity')
            ->addColumn('cost')
            ->addColumn('version')
            ->addColumn('effect_from_formatted', fn (SOR $model) => Carbon::parse($model->effect_from)->format('d/m/Y'))
            // ->addColumn('effect_to_formatted', fn (SOR $model) => Carbon::parse($model->effect_to)->format('d/m/Y'))
            ->addColumn('effect_to_formatted', function (SOR $model) {
                return $model->effect_to ? Carbon::parse($model->effect_from)->format('d/m/Y') : '';
            })
            // ->addColumn('is_active')
            ->addColumn('created_by')
            ->addColumn('is_approved', function (SOR $model) {
                if ($model->is_approved == 1) {
                    return '<span class="badge badge-pill rounded bg-success">Approved</span>';
                } else {
                    return '<span class="badge badge-pill rounded bg-warning">Pending</span>';
                }
                // return "<span class='badge badge-pill rounded" . ($model->is_approved == 0) ? 'bg-success' : 'bg-danger' . ">" . ($model->is_approved == 1) ? 'Approved' : 'Pending' . "</span>";
            });
        // ->addColumn('created_at_formatted', fn (SOR $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'))
        // ->addColumn('updated_at_formatted', fn (SOR $model) => Carbon::parse($model->updated_at)->format('d/m/Y H:i:s'));
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

            Column::make('ITEM NUMBER', 'Item_details')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            /*Column::make('DEPARTMENT NAME', 'getDepartmentName.department_name')
                // ->sortable()
                ->searchable(),*/

            Column::make('DEPT CATEGORY', 'getDeptCategoryName.dept_category_name')
                // ->sortable()
                ->searchable(),

            Column::make('DESCRIPTION', 'description')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('UNIT', 'getUnitsName.unit_name')
                ->searchable(),

            Column::make('quantity', 'unit')
                ->makeInputRange(),

            Column::make('COST', 'cost')
                ->sortable()
                ->searchable(),

            Column::make('VERSION', 'version')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::make('EFFECT FROM', 'effect_from_formatted', 'effect_from')
                ->searchable()
                ->sortable(),

            Column::make('EFFECT TO', 'effect_to_formatted', 'effect_to')
                ->searchable()
                ->sortable(),

            // Column::make('IS ACTIVE', 'is_active')
            //     ->sortable()
            //     ->searchable(),

            Column::make('CREATED BY', 'created_by'),

            Column::make('status', 'is_approved')
                ->sortable()
                ->searchable(),

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
     * PowerGrid SOR Action Buttons.
     *
     * @return array<int, Button>
     */


    public function actions(): array
    {
        return [

            Button::add('download')
                ->caption('Download')
                ->class('btn-soft-primary btn-sm cursor-pointer text-dark px-3 py-2.5 m-1 rounded text-sm')
                ->emit('sorFileDownload', ['value' => 'id']),
            /*
            Button::add('edit')
                ->caption('Edit')
                ->class('btn-soft-warning btn-sm cursor-pointer text-dark px-3 py-2.5 m-1 rounded text-sm')
                ->emit('openEntryForm', ['formType' => 'edit', 'id' => 'id']),
            */
            Button::add('Download')
            ->bladeComponent('download-button', ['id' => 'id','iconName'=>'download']),

            Button::add('Edit')
            ->bladeComponent('edit-button', ['id' => 'id']),
            // ->route('s-o-r.edit', ['s-o-r' => 'id']),



            /*Button::make('destroy', 'Delete')
                ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
                ->route('s-o-r.destroy', ['s-o-r' => 'id'])
                ->method('delete')*/
        ];
    }


    public function edit($id)
    {
        $this->emit('openEntryForm', ['formType' => 'edit', 'id' => $id]);
    }
    public function generatePdf($value)
    {
        $this->emit('sorFileDownload', $value);
    }
    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid SOR Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($s-o-r) => $s-o-r->id === 1)
                ->hide(),
        ];
    }
    */
}
