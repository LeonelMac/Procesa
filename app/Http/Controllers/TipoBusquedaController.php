<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoBusqueda;
use App\Models\Juzgado;

class TipoBusquedaController extends Controller
{
    public function index()
    {
        $tipoBusquedas = TipoBusqueda::all();
        $juzgados = Juzgado::all();
        return view('tipoBusquedas', compact('tipoBusquedas', 'juzgados'));
    }    

    public function obtenerTipoBusqueda($idtipobusqueda = null)
    {
        if ($idtipobusqueda) {
            $tipoBusqueda = TipoBusqueda::with('juzgado')->findOrFail($idtipobusqueda);
            $juzgados = Juzgado::all();
            return response()->json([
                'tipobusqueda' => $tipoBusqueda,
                'juzgados' => $juzgados 
            ]);
        }
        $juzgados = Juzgado::all();
        return response()->json([
            'juzgados' => $juzgados
        ]);
    }

    public function guardarTipoBusqueda(Request $request)
    {
        $request->validate([
            'tipobusqueda' => 'required|string|max:255',
            'juzgado' => 'required|exists:juzgados,idjuzgados', 
        ]);

        TipoBusqueda::create([
            'tipobusqueda' => $request->tipobusqueda,
            'juzgado' => $request->juzgado, 
        ]);

        return redirect()->route('tipoBusquedas.index');
    }

    public function editarTipoBusqueda(Request $request, $idtipobusqueda)
    {
        $request->validate([
            'tipobusqueda' => 'required|string|max:255',
            'juzgado' => 'required|exists:juzgados,idjuzgados', 
        ]);

        $tipoBusqueda = TipoBusqueda::findOrFail($idtipobusqueda);
        $tipoBusqueda->update([
            'tipobusqueda' => $request->tipobusqueda,
            'juzgado' => $request->juzgado,
        ]);
    
        session()->flash('message', 'Tipo Búsqueda actualizado correctamente');
        return redirect()->route('tipoBusquedas.index');
    }

    public function eliminarTipoBusqueda($idtipobusqueda)
    {
        $tipoBusqueda = TipoBusqueda::findOrFail($idtipobusqueda);
        $tipoBusqueda->delete();
    
        session()->flash('message', 'Tipo Búsqueda eliminado correctamente');
        return redirect()->route('tipoBusquedas.index');
    }
}
