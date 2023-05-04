<?php

namespace App\Http\Livewire\UserManagement\Datatable;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;

class UsersDatatable extends DataTableComponent
{
    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id"),
            // ->sortable(),
            // ->format(function ($value, $column, $row) {
            //     return $value;
            // }),
            // Column::make("Name", "name")
            //     ->sortable(),
            Column::make("Username", "username")
                ->sortable()
                ->searchable(),
            Column::make("Email", "email")
                ->sortable(),
            Column::make("eHrms id", "ehrms_id")
                ->sortable(),
            Column::make("Emp name", "emp_name")
                ->sortable(),

            Column::make("Designation Name", "getDesignationName.designation_name")
                ->sortable()
                // ->hideIf(auth()->user()->user_type = 3),
                ->hideIf(auth()->user()->user_type = 3 && auth()->user()->user_type = 2),
            // ->hideIf(Auth::user()->user_type=2),

            Column::make("Department Name", "getDepartmentName.department_name")
                ->sortable(),
            Column::make("Office Name", "getOfficeName.office_name")
                ->sortable()
                ->hideIf(auth()->user()->user_type = 2),
            Column::make("User type", "getUserType.type")
                ->sortable()
                ->searchable(),
            // Column::make("status", "status")
            //     ->format(function ($value, $column, $row) {
            //         return $column;
            //     })
            // $isChecked = ($column->status == "1") ? 'checked' : '';
            // return $row->id . ': ' . $value;

            // if ($column->status == 1) {
            //     return '<span class="badge bg-success">' . $row["id"] . 'Active</span>';
            // } else {
            //     return '<span class="badge bg-danger">Inactive</span>';
            // }

            // if ($value) {
            //     $isChecked = 'checked';
            //     $showCheckbox = true;
            // } else {
            //     $isChecked = '';
            //     $showCheckbox = false;
            // }



            // return view(
            //     'livewire.table.checkbox',
            //     [
            //         'model' => $column,
            //         'field' => 'status',
            //         'id' => $row
            //     ]
            // );

            // })
            // ->sortable(),
            Column::make("Actions", "status")
                ->format(
                    fn ($value, $row, Column $column) => view('livewire.table.checkbox', ['status' => $row])->withValue($value)
                )

            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
        ];
    }


    public function toggleSelected($id, $status)
    {
        $model = User::find($id);
        // $this->emit('openModal', $id);
        User::where('id', $model->id)->update(['status' => $status]);
        // $this->emit('confirmAlert', $model);
        // $confirmMessage = $model->status ? 'Are you sure you want to deactivate this row?' : 'Are you sure you want to activate this row?';


        // dd($model);
    }

    public function builder(): Builder
    {
        if (Auth::user()->department_id) {
            if (Auth::user()->office_id) {
                return User::query()
                    ->join('user_types', 'users.user_type', '=', 'user_types.id')
                    ->where('user_types.parent_id', '=', Auth::user()->user_type)
                    ->where('users.department_id', Auth::user()->department_id)
                    ->where('users.office_id', Auth::user()->office_id);
            } else {
                return User::query()
                    ->join('user_types', 'users.user_type', '=', 'user_types.id')
                    ->where('user_types.parent_id', '=', Auth::user()->user_type)
                    ->where('users.department_id', Auth::user()->department_id);
            }
        } else {
            return User::query()
                ->join('user_types', 'users.user_type', '=', 'user_types.id')
                ->where('user_types.parent_id', '=', Auth::user()->user_type);
        }
    }
}
