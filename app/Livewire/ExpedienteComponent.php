<?php

namespace App\Livewire;

use Livewire\Component;
use App\Clases\Column;
use App\Models\Expediente;
use Illuminate\Database\Eloquent\Builder;

class ExpedienteComponent extends TablaComponent
{
    public $perPage = 10;
    public $sortBy = '';
    public $searchBy = ['numero'];

    public function query(): Builder
    {
        return Expediente::query();
    }

    public function columns(): array
    {
        return [
            Column::make('numero', 'Número'),
            Column::make('estatusexpediente', 'Estatus'),
            Column::make('fechaexpe', 'Fecha'),
        ];
    }

    public function verExpediente($value)
    {
        return redirect('/expedientes/descripcion/' . $value);
    }
}
