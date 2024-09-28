<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expediente;

class ExpedienteController extends Controller
{
    public function index(Request $request)
    {
        $term = $request->input('search');
        $columns = ['numero', 'asunto', 'destino'];

        $expedientes = Expediente::when($term, function ($query, $term) use ($columns) {
            return $query->search($columns, $term);
        })->paginate(10);

        return view('expedientes', compact('expedientes'));
    }

    public function show($id_expedientes)
    {
        $expediente = Expediente::findOrFail($id_expedientes);
        return view('expedientes_show', compact('expediente'));
    }

    public function descripcion($id_expedientes)
    {
        $expediente = Expediente::findOrFail($id_expedientes);
        return view('descripcion_expedientes', compact('expediente'));
    }
}
