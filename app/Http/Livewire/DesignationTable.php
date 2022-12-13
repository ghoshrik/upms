<?php

namespace App\Http\Livewire;

use App\Models\Designation;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;

class DesignationTable extends DataTableComponent
{
    protected $model = Designation::class;
    public string $value;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
            ->sortable()
            ->setSortingPillTitle('Key')
            ->setSortingPillDirections('0-9', '9-0'),
            Column::make("Designation", "designation_name")
                ->sortable()
                ->searchable()
                ->collapseOnMobile(),
            // Column::blank(),
            ButtonGroupColumn::make('Actions')
                ->attributes(function ($row) {
                    return [
                        'class' => 'space-x-2',
                    ];
                })
                ->buttons([
                    LinkColumn::make('Edit') // make() has no effect in this case but needs to be set anyway
                        ->title(fn ($row) => 'Edit ' . $row->name)
                        ->location(fn ($row) => route('designation', $row))
                        ->attributes(function ($row) {
                            return [
                                'target' => '_blank',
                                'class' => 'btn btn-soft-warning'
                            ];
                        }),
                ]),

        ];
    }
    public function reorder($items): void
    {
        foreach ($items as $item) {
            Designation::find((int)$item['id'])->update(['sort' => (int)$item['id']]);
        }
    }
    public function rowView(): string
    {
        return 'location.to.my.row.view';
    }
}
