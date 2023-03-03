<?php

namespace App\Http\Livewire\Designation;

use App\Models\Designation;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Illuminate\Database\Eloquent\Builder;

class DesignationTable extends DataTableComponent
{
    // protected $model = Designation::class;
    // public string $value;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
            ->sortable(),
            // ->setSortingPillTitle('Key')
            // ->setSortingPillDirections('0-9', '9-0'),
            Column::make("Designation", "designation_name")
                ->sortable()
                ->searchable()
                ->collapseOnMobile(),
            // Column::make("Actions", "id")->view('components.data-table-components.buttons.edit'),
        ];
    }
    // public function reorder($items): void
    // {
    //     foreach ($items as $item) {
    //         Designation::find((int)$item['id'])->update(['sort' => (int)$item['id']]);
    //     }
    // }
    public function edit($id)
    {
        $this->emit('openForm',true,$id);
    }
    // public function rowView(): string
    // {
    //     return 'location.to.my.row.view';
    // }
    public function builder(): builder
    {
        return Designation::query()
            ->orderBy('id');
        // ->groupBy('estimate_id.estimate_id');
    }
}
