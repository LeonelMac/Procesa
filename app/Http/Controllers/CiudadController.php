<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ciudad;

class CiudadController extends Controller
{
    public function index()
    {
        $ciudades = Ciudad::all();
        return view('ciudades', compact('ciudades'));
    }

    public function update(Request $request, $id)
    {
        $ciudad = Ciudad::findOrFail($id);
        $ciudad->nombre = $request->nombreCiudad;
        $ciudad->save();

        return redirect()->route('ciudades.index');
    }

    public function destroy($id)
    {
        $ciudad = Ciudad::findOrFail($id);
        $ciudad->delete();

        return redirect()->route('ciudades.index');
    }
}
