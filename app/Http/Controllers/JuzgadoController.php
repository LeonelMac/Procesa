<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Juzgado;

class JuzgadoController extends Controller
{
    public function index()
    {
        $juzgados = Juzgado::all();
        return view('juzgados', compact('juzgados'));
    }

    public function update(Request $request, $idjuzgados)
    {
        $juzgado = Juzgado::findOrFail($idjuzgados);
        $juzgado->juzgados = $request->juzgados;
        $juzgado->save();

        return redirect()->route('juzgados.index');
    }

    public function destroy($idjuzgados  )
    {
        $juzgado = Juzgado::findOrFail($idjuzgados);
        $juzgado->delete();

        return redirect()->route('juzgados.index');
    }
}
