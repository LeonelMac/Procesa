<?php

namespace App\Livewire;

use Livewire\Component;
use App\Clases\Column;
use App\Models\Distrito;
use Illuminate\Database\Eloquent\Builder;

class DistritoComponent extends TablaComponent
{
    public $perPage = 10;
    public $sortBy = '';
    public $searchBy = ['distrito'];

    public function query(): Builder
    {
        return Distrito::query();
    }

    public function columns(): array
    {
        return [
            Column::make('distrito', 'Distrito'),
        ];
    }
}
