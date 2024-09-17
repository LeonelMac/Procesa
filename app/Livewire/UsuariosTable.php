<?php

namespace App\Livewire;

use App\Clases\Column;
use App\Models\User;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Mail\PasswordResetNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UsuariosTable extends TablaComponent
{
    public $perPage = 10;
    public $sortBy = '';
    public $searchBy = ['nombres', 'apellidoP', 'apellidoM'];
    public $id;
    public $nombres, $apellidoP, $apellidoM, $rol, $municipio, $direccion, $telefono;

    public function mount($id = null)
    {
        if ($id) {
            $usuario = User::find($id);
            if ($usuario) {
                $this->id = $usuario->id;
                $this->nombres = $usuario->nombres;
                $this->apellidoP = $usuario->apellidoP;
                $this->apellidoM = $usuario->apellidoM;
                $this->rol = $usuario->rol;
                $this->municipio = $usuario->municipio;
                $this->direccion = $usuario->direccion;
                $this->telefono = $usuario->telefono;
            }
        }
    }

    public function actualizarUsuario($id)
    {
        $usuario = User::find($id);

        $this->validate([
            'nombres' => 'required|string|max:255',
            'apellidoP' => 'required|string|max:255',
            'apellidoM' => 'required|string|max:255',
            'rol' => 'required|numeric',
            'municipio' => 'required|numeric',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:10',
        ]);

        if ($usuario) {
            $usuario->update([
                'nombres' => $this->nombres,
                'apellidoP' => $this->apellidoP,
                'apellidoM' => $this->apellidoM,
                'rol' => $this->rol,
                'municipio' => $this->municipio,
                'direccion' => $this->direccion,
                'telefono' => $this->telefono,
            ]);

            session()->flash('message', 'Usuario actualizado correctamente.');
            $this->emit('usuarioActualizado');
        }
    }

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
            Column::make('rol_nombre', 'Rol'),
            Column::make('municipio_nombre', 'Municipio'),
            Column::make('direccion', 'Dirección'),
            Column::make('telefono', 'Teléfono'),
            Column::make('id', 'Acciones')->component('columns.accionesUsuarios'),
        ];
    }

    public function generateSecurePassword($length = 12)
    {
        $upper = Str::upper(Str::random(2));
        $lower = Str::lower(Str::random(4));
        $numbers = random_int(10, 99) . random_int(10, 99);
        $specialCharacters = '!@#$%^&*';
        $special = substr(str_shuffle($specialCharacters), 0, 2);
        $password = str_shuffle($upper . $lower . $numbers . $special);
        return substr($password, 0, $length);
    }

    public function resetPassword($id)
    {
        $usuario = User::find($id);
        if ($usuario) {
            $nuevaPassword = $this->generateSecurePassword(12);
            $usuario->password = $nuevaPassword;
            $usuario->password_restaurada = true;
            $usuario->save();
            Mail::to($usuario->email)->send(new PasswordResetNotification($usuario, $nuevaPassword));
            session()->flash('message', 'Contraseña restablecida y correo enviado');
            session()->flash('message_type', 'success');
            return redirect('/usuarios');
        } else {
            session()->flash('message', 'Usuario no encontrado');
            session()->flash('message_type', 'error');
            return redirect('/usuarios');
        }
    }

    public function deleteUser($id)
    {
        $usuario = User::find($id);
        if ($usuario && $usuario != auth()->user()) {
            $usuario->delete();
            session()->flash('message', 'Usuario eliminado');
            session()->flash('message_type', 'success');
            return redirect('/usuarios');
        } else {
            if ($usuario && $usuario == auth()->user()) {
                session()->flash('message', 'No puedes eliminar tu propio usuario');
                session()->flash('message_type', 'error');
                return redirect('/usuarios');
            } else {
                session()->flash('message', 'Usuario no encontrado');
                session()->flash('message_type', 'error');
                return redirect('/usuarios');
            }
        }
    }
}
