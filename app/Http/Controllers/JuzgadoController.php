<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Juzgado;
use App\Models\Distrito;

class JuzgadoController extends Controller
{

    public function index()
    {
        $juzgados = Juzgado::all();
        $distritos = Distrito::all();
        return view('juzgados', compact('juzgados', 'distritos'));
    }

    public function obtenerJuzgado($idjuzgados = null)
    {
        if ($idjuzgados) {
            $juzgado = Juzgado::with('distrito')->findOrFail($idjuzgados);
            $distritos = Distrito::all();
            return response()->json([
                'juzgado' => $juzgado,
                'distritos' => $distritos
            ]);
        }
        $distritos = Distrito::all();
        return response()->json($distritos);
    }

    public function guardarJuzgado(Request $request)
    {
        $request->validate([
            'juzgados' => 'required|string|max:255',
            'distrito' => 'required|exists:distrito,iddistrito',
        ]);

        Juzgado::create([
            'juzgados' => $request->juzgados,
            'distrito' => $request->distrito,
        ]);

        session()->flash('message', 'Juzgado agregado correctamente');
        return redirect()->route('juzgados.index');
    }

    public function editarJuzgado(Request $request, $idjuzgados)
    {
        $request->validate([
            'juzgados' => 'required|string|max:255',
            'distrito' => 'required|exists:distrito,iddistrito',
        ]);

        $juzgado = Juzgado::findOrFail($idjuzgados);
        $juzgado->update([
            'juzgados' => $request->juzgados,
            'distrito' => $request->distrito,
        ]);

        session()->flash('message', 'Juzgado actualizado correctamente');
        return redirect()->route('juzgados.index');
    }

    public function eliminarJuzgado($idjuzgados)
    {
        $juzgado = Juzgado::findOrFail($idjuzgados);
        $juzgado->delete();

        session()->flash('message', 'Juzgado eliminado correctamente');
        return redirect()->route('juzgados.index');
    }

    public function verificarJuzgado(Request $request)
    {
        $existe = Juzgado::where('juzgados', $request->juzgados)->exists();
        return response()->json(['exists' => $existe]);
    }
}
