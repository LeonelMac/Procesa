<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rol;

class RolController extends Controller
{
    public function index()
    {
        $roles = Rol::all();
        return view('roles', compact('roles'));
    }

    public function update(Request $request, $id)
    {
        $rol = Rol::findOrFail($id);
        $rol->nombre = $request->nombre;
        $rol->save();

        return redirect()->route('roles.index');
    }

    public function destroy($id)
    {
        $rol = Rol::findOrFail($id);
        $rol->delete();

        return redirect()->route('roles.index');
    }
}
