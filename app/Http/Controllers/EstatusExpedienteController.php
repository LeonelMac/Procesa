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

    public function update(Request $request, $idestatusexpediente)
    {
        $estatusExpedientes = EstatusExpediente::findOrFail($idestatusexpediente);
        $estatusExpedientes->estatusExpediente = $request->estatusExpediente;
        $estatusExpedientes->save();

        return redirect()->route('estatusExpediente.index');
    }

    public function destroy($idestatusexpediente)
    {
        $estatusExpedientes = EstatusExpediente::findOrFail($idestatusexpediente);
        $estatusExpedientes->delete();

        return redirect()->route('estatusExpediente.index');
    }
}
