<?php

namespace App\Http\Livewire\AccessManager\Datatable;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\AccessMaster;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class AccessManagerDatatable extends DataTableComponent
{
    protected $model = AccessMaster::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            // Column::make("Id", "id")
            //     ->sortable(),
            Column::make("Department", "getDepartmentName.department_name")
                ->sortable(),
            Column::make("Designation", "getDesignationName.designation_name")
                ->sortable(),
            Column::make("Access type", "getAccessTypeName.access_name")
                ->sortable(),
            Column::make("Office", "getOfficeName.office_name")
                ->sortable(),
            Column::make("User", "getUserName.emp_name")
                ->sortable(),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
        ];
    }
    public function builder(): Builder
    {
        return AccessMaster::query()
        ->where('access_masters.department_id',Auth::user()->department_id)
        ->where('access_masters.office_id','=',Auth::user()->office_id);
        // ->where('');
    }
}
