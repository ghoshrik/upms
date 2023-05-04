<?php

namespace App\Http\Livewire\Permission;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class PermissionTable extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        return view('livewire.permission.permission-table',[
            'permisssions' => Permission::paginate(5),
        ]);
    }
}
