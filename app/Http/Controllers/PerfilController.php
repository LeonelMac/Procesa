<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function index()
    {
        $usuario = auth()->user();
        return view('perfil', compact('usuario'));
    }

    public function update(Request $request)
    {
        $usuario = auth()->user();
        $usuario->update($request->only('nombre', 'descripcion', 'compania', 'rol', 'ciudad', 'direccion', 'telefono', 'email', 'twitter', 'facebook', 'instagram'));
        return redirect()->route('perfil.index')->with('success', 'Perfil actualizado correctamente');
    }

    public function updateSettings(Request $request)
    {
        $usuario = auth()->user();
        $usuario->notificaciones_email = $request->has('emailNotifications');
        $usuario->notificaciones_whatsapp = $request->has('whatsappNotifications');
        $usuario->notificaciones_sms = $request->has('smsNotifications');
        $usuario->save();

        return redirect()->route('perfil.index')->with('success', 'Configuraciones actualizadas correctamente');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:6',
        ]);

        $usuario = auth()->user();

        if (!Hash::check($request->current_password, $usuario->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta']);
        }

        $usuario->password = Hash::make($request->new_password);
        $usuario->save();

        return redirect()->route('perfil.index')->with('success', 'Contraseña actualizada correctamente');
    }
}
