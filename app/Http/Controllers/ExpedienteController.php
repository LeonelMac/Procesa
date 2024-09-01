<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expediente;

class ExpedienteController extends Controller
{
    public function index()
    {
        $expedientes = Expediente::all();
        return view('expedientes', compact('expedientes'));
    }

    public function indexUser()
    {
        $expedientes = Expediente::where('user_id', auth()->id())->get(); 
        return view('expedientes_user', compact('expedientes'));
    }

    public function show($id)
    {
        $expediente = Expediente::findOrFail($id);
        return view('expedientes_show', compact('expediente'));
    }

    public function descripcion($id)
    {
        $expediente = Expediente::findOrFail($id);
        return view('descripcion_expedientes', compact('expediente'));
    }

    public function descripcionCopy($id)
    {
        $expediente = Expediente::findOrFail($id);
        return view('descripcion_expedientes_copy', compact('expediente'));
    }

    public function descripcionUser($id)
    {
        $expediente = Expediente::findOrFail($id);
        return view('descripcion_expedientes_user', compact('expediente'));
    }

    public function descripcionUserCopy($id)
    {
        $expediente = Expediente::findOrFail($id);
        return view('descripcion_expedientes_user_copy', compact('expediente'));
    }
}
