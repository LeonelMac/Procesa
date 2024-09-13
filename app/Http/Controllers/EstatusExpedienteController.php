<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EstatusExpediente;

class EstatusExpedienteController extends Controller
{
    public function index()
    {
        $estatusExpediente = EstatusExpediente::all();
        return view('estatusExpediente', compact('estatusExpediente'));
    }

    public function obtenerEstatusExpediente($idestatusexpediente)
    {
        $idestatusexpediente = EstatusExpediente::findOrFail($idestatusexpediente);
        return response()->json($idestatusexpediente);
    }

    public function guardarEstatusExpediente(Request $request)
    {
        $request->validate([
            'estatusexpediente' => 'required|string|max:255'
        ]);

        EstatusExpediente::create([
            'estatusexpediente' => $request->estatusexpediente
        ]);

        session()->flash('message', 'Estatus de Expediente agregado correctamente');
        return redirect()->route('estatusExpediente.index');
    }

    public function editarEstatusExpediente(Request $request, $idestatusexpediente)
    {
        $request->validate([
            'estatusexpediente' => 'required|string|max:255'
        ]);

        $idestatusexpediente = EstatusExpediente::findOrFail($idestatusexpediente);
        $idestatusexpediente->update([
            'estatusexpediente' => $request->estatusexpediente
        ]);

        session()->flash('message', 'Estatus de Expediente actualizado correctamente');
        return redirect()->route('estatusExpediente.index');
    }

    public function eliminarEstatusExpediente($idestatusexpediente)
    {
        $idestatusexpediente = EstatusExpediente::findOrFail($idestatusexpediente);
        $idestatusexpediente->delete();

        session()->flash('message', 'Estatus de Expediente eliminado correctamente');
        return redirect()->route('estatusExpediente.index');
    }
}
