<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoBusqueda;

class TipoBusquedaController extends Controller
{
    public function index()
    {
        $tipoBusqueda = TipoBusqueda::all();
        return view('tipoBusqueda', compact('tipoBusqueda'));
    }

    public function update(Request $request, $idtipobusqueda)
    {
        $tipoBusquedas = TipoBusqueda::findOrFail($idtipobusqueda);
        $tipoBusquedas->tipoBusqueda = $request->tipoBusqueda;
        $tipoBusquedas->save();

        return redirect()->route('tipoBusqueda.index');
    }

    public function destroy($idtipobusqueda)
    {
        $tipoBusquedas = TipoBusqueda::findOrFail($idtipobusqueda);
        $tipoBusquedas->delete();

        return redirect()->route('tipoBusqueda.index');
    }
}

