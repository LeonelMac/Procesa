<?php

namespace App\Livewire;

use Livewire\Component;
use App\Clases\Column;
use App\Models\TipoBusqueda;
use Illuminate\Database\Eloquent\Builder;

class TipoBusquedaComponent extends TablaComponent
{
    public $perPage = 10;
    public $sortBy = '';
    public $searchBy = ['tipobusqueda'];

    public function query(): Builder
    {
        return TipoBusqueda::query();
    }

    public function columns(): array
    {
        return [
            Column::make('idtipobusqueda', 'Núm.'),
            Column::make('tipobusqueda', 'Tipo Búsqueda'),
            Column::make('juzgado', 'Juzgado'),
        ];
    }
}
