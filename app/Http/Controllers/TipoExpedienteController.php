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

    public function obtenerTipoExpediente($idtipoexpediente)
    {
        $idtipoexpediente = TipoExpediente::findOrFail($idtipoexpediente);
        return response()->json($idtipoexpediente);
    }

    public function guardarTipoExpediente(Request $request)
    {
        $request->validate([
            'tipoexpediente' => 'required|string|max:255'
        ]);

        TipoExpediente::create([
            'tipoexpediente' => $request->tipoexpediente
        ]);

        session()->flash('message', 'Tipo de Expediente agregado correctamente');
        return redirect()->route('tipoExpedientes.index');
    }

    public function editarTipoExpediente(Request $request, $idtipoexpediente)
    {
        $request->validate([
            'tipoexpediente' => 'required|string|max:255'
        ]);

        $idtipoexpediente = TipoExpediente::findOrFail($idtipoexpediente);
        $idtipoexpediente->update([
            'tipoexpediente' => $request->tipoexpediente
        ]);

        session()->flash('message', 'Tipo de Expediente actualizado correctamente');
        return redirect()->route('tipoExpedientes.index');
    }

    public function eliminarTipoExpediente($idtipoexpediente)
    {
        $idtipoexpediente = TipoExpediente::findOrFail($idtipoexpediente);
        $idtipoexpediente->delete();

        session()->flash('message', 'Tipo de Expediente eliminado correctamente');
        return redirect()->route('tipoExpedientes.index');
    }
}
