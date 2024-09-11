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

    public function update(Request $request, $iddistrito)
    {
        $distrito = Distrito::findOrFail($iddistrito);
        $distrito->distritos = $request->nombreDistritos;
        $distrito->save();

        return redirect()->route('distritos.index');
    }

    public function destroy($iddistrito )
    {
        $distrito = Distrito::findOrFail($iddistrito);
        $distrito->delete();

        return redirect()->route('distritos.index');
    }
}
