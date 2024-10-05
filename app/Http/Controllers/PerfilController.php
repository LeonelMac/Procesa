<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use App\Models\Municipio;

class PerfilController extends Controller
{
    public function index($id)
    {
        $usuario = User::with('rol', 'municipio')->find(auth()->id());
        $roles = Rol::all();
        $municipios = Municipio::all();
        if (!$usuario) {
            return redirect('/perfil')->with('error', 'Usuario no encontrado');
        }
        return view('perfil', compact('usuario', 'roles', 'municipios'));
    }
}
