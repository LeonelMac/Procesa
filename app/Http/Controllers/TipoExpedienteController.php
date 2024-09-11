<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoExpediente;

class TipoExpedienteController extends Controller
{
    public function index()
    {
        $tipoExpedientes = TipoExpediente::all();
        return view('tipoExpedientes', compact('tipoExpedientes'));
    }

    public function update(Request $request, $idtipoexpediente)
    {
        $tipoExpediente = TipoExpediente::findOrFail($idtipoexpediente);
        $tipoExpediente->tipoExpedientes = $request->tipoExpedientes;
        $tipoExpediente->save();

        return redirect()->route('tipoExpedientes.index');
    }

    public function destroy($idtipoexpediente)
    {
        $tipoExpediente = TipoExpediente::findOrFail($idtipoexpediente);
        $tipoExpediente->delete();

        return redirect()->route('tipoExpedientes.index');
    }
}
