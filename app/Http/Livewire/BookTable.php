<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class BookTable extends DataTableComponent
{

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setReorderStatus(true);
    }

    public function columns(): array
    {
        return [
            Column::make("id")
                ->collapseOnTablet(),

            Column::make('author', 'user.name')
                ->sortable()
                ->searchable(),

            Column::make('title')
                ->sortable()
                ->searchable(),

            Column::make('isbn')
                ->sortable()
                ->searchable(),

            BooleanColumn::make('is_available')
                ->sortable()
                ->searchable(),

            Column::make('Fecha de creación', 'created_at')
                ->sortable()
                ->format(fn ($value) => $value->format('d/m/Y')),

            Column::make('My one off column')
                ->label(
                    fn ($row) => view('books.datatable.actions', ['book' => $row])
                )
        ];
    }

    public function builder(): Builder
    {
        return Book::query()
            ->with('user');
    }

    public function reorder($items): void
    {
        foreach ($items as $item) {
            Book::find((int)$item['value'])->update(['sort' => (int)$item['order']]);
        }
    }
}
