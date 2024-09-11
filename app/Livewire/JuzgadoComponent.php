<?php

namespace App\Livewire;

use Livewire\Component;
use App\Clases\Column;
use App\Models\Juzgado;
use Illuminate\Database\Eloquent\Builder;

class JuzgadoComponent extends TablaComponent
{
    public $perPage = 10;
    public $sortBy = '';
    public $searchBy = ['juzgados'];

    public function query(): Builder
    {
        return Juzgado::query();
    }

    public function columns(): array
    {
        return [
            Column::make('idjuzgados', 'Núm.'),
            Column::make('juzgados', 'Juzgado'),
            Column::make('distrito', 'Distrito'),
        ];
    }
}
