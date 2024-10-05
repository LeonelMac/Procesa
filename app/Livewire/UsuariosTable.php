<?php

namespace App\Livewire;

use App\Clases\Column;
use App\Models\User;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class UsuariosTable extends TablaComponent
{
    public $perPage = 5;
    public $sortBy = '';
    public $searchBy = ['nombres', 'apellidoP', 'apellidoM'];

    public function query(): Builder
    {
        return User::query()
            ->select(
                'users.*',
                DB::raw("CONCAT(users.nombres, ' ', users.apellidoP, ' ', users.apellidoM) AS nombre_completo"),
                'rolusuarios.rolusuarios AS rol_nombre',
                'municipio.municipio AS municipio_nombre'
            )
            ->leftJoin('rolusuarios', 'users.rol', '=', 'rolusuarios.id_rolusuarios')
            ->leftJoin('municipio', 'users.municipio', '=', 'municipio.idmunicipio');
    }

    public function columns(): array
    {
        return [
            Column::make('nombre_completo', 'Nombre'),
            Column::make('email', 'Correo Electrónico'),
            Column::make('telefono', 'Teléfono'),
            Column::make('direccion', 'Dirección'),
            Column::make('rol_nombre', 'Rol'),
            Column::make('municipio_nombre', 'Municipio'),
        ];
    }
}
