<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distrito;

class DistritoController extends Controller
{
    public function index()
    {
        $distritos = Distrito::all();
        return view('distritos', compact('distritos'));
    }

    public function obtenerDistrito($iddistrito)
    {
        $distrito = Distrito::findOrFail($iddistrito);
        return response()->json($distrito);
    }

    public function guardarDistrito(Request $request)
    {
        $request->validate([
            'distrito' => 'required|string|max:255'
        ]);

        Distrito::create([
            'distrito' => $request->distrito
        ]);

        session()->flash('message', 'Distrito agregado correctamente');
        return redirect()->route('distritos.index');
    }

    public function editarDistrito(Request $request, $iddistrito)
    {
        $request->validate([
            'distrito' => 'required|string|max:255'
        ]);

        $distrito = Distrito::findOrFail($iddistrito);
        $distrito->update([
            'distrito' => $request->distrito
        ]);

        session()->flash('message', 'Distrito actualizado correctamente');
        return redirect()->route('distritos.index');
    }

    public function eliminarDistrito($iddistrito)
    {
        $distrito = Distrito::findOrFail($iddistrito);
        $distrito->delete();

        session()->flash('message', 'Distrito eliminado correctamente');
        return redirect()->route('distritos.index');
    }
}
