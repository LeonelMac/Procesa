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
        return TipoBusqueda::query()
            ->select('tipobusqueda.*', 'juzgados.juzgados AS juzgado_nombre')
            ->leftJoin('juzgados', 'tipobusqueda.juzgado', '=', 'juzgados.idjuzgados');
    }

    public function columns(): array
    {
        return [
            Column::make('tipobusqueda', 'Tipo Búsqueda'),
            Column::make('juzgado_nombre', 'Juzgado'),
        ];
    }
}
