<?php

namespace App\Livewire;

use Livewire\Component;
use App\Clases\Column;
use App\Models\TipoExpediente;
use Illuminate\Database\Eloquent\Builder;

class TipoExpedienteComponent extends TablaComponent
{
    public $perPage = 10;
    public $sortBy = '';
    public $searchBy = ['tipoexpediente'];

    public function query(): Builder
    {
        return TipoExpediente::query();
    }

    public function columns(): array
    {
        return [
            Column::make('tipoexpediente', 'Tipo Expediente'),
            Column::make('idtipoexpediente', 'Acciones')->component('columns.accionesTipoExpediente'),
        ];
    }
}
