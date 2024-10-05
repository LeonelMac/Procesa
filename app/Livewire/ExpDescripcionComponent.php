<?php

namespace App\Livewire;

use Livewire\Component;
use App\Clases\Column;
use App\Models\Expediente;
use Illuminate\Database\Eloquent\Builder;

class ExpDescripcionComponent extends TablaComponent
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
            Column::make('tipoexpediente', 'Tipo'),
            Column::make('numero', 'Número'),
            Column::make('prom', 'Prom.'),
            Column::make('asunto', 'Asunto'),
            Column::make('resolucion', 'Resolución'),
            Column::make('destino', 'Destino'),
            Column::make('fechaexpe', 'Fecha'),
            Column::make('sintesis', 'Síntesis'),
        ];
    }

    public function verExpediente($id)
    {
        $expediente = Expediente::findOrFail($id);
        $pdfUrl = asset("assets/pdf/{$expediente->documentoexpe}");
        return redirect()->to($pdfUrl);
    }
}
