<?php

namespace App\Livewire;

use Livewire\Component;
use App\Clases\Column;
use App\Models\EstatusExpediente;
use Illuminate\Database\Eloquent\Builder;

class EstatusExpedienteComponent extends TablaComponent
{
    public $perPage = 10;
    public $sortBy = '';
    public $searchBy = ['estatusexpediente'];

    public function query(): Builder
    {
        return EstatusExpediente::query();
    }

    public function columns(): array
    {
        return [
            Column::make('estatusexpediente', 'Estatus Expediente'),
        ];
    }
}
