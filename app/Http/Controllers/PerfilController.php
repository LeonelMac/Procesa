<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rol;
use App\Models\Municipio;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PerfilController extends Controller
{
    public function index($id)
    {
        $usuario = User::with('rol', 'municipio')->find(auth()->id());
        $roles = Rol::all();
        $municipios = Municipio::all();
        if (!$usuario) {
            return redirect('/perfil')->with('error', 'Usuario no encontrado');
        }
        return view('perfil', compact('usuario', 'roles', 'municipios'));
    }
    

    public function editarUsuario($id)
    {
        $usuario = User::find($id);
        if (!$usuario) {
            session()->flash('message', 'Usuario no encontrado');
            session()->flash('message_type', 'error');
            return redirect('/perfil');
        }
    
        $roles = Rol::all();
        $municipios = Municipio::all();
        
        session()->flash('usuario', $usuario);
        return view('perfil', compact('roles', 'municipios'));
    }

    public function cambiosUsuario(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'id' => ['required', 'numeric'],
            'nombres' => ['required', 'string', 'max:255'],
            'apellidoP' => ['required', 'string', 'max:255'],
            'apellidoM' => ['required', 'string', 'max:255'],
            'rol' => ['required', 'numeric'],
            'municipio' => ['required', 'numeric'],
            'direccion' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:10']
        ]);
        if ($validator->fails()) {
            session()->flash('message', $validator->errors()->first());
            session()->flash('message_type', 'error');
            return back();
        }
        $formFields = $validator->validated();
        $id = $formFields['id'];
        $usuario = User::find($id);
        if (!$usuario) {
            session()->flash('message', 'Usuario no encontrado');
            session()->flash('message_type', 'error');
            return redirect()->route('perfil.index', ['id' => $id]);
        }
        $usuario->update($formFields);
        return redirect()->route('perfil.index', ['id' => $usuario->id])->with('success', 'Perfil actualizado correctamente');
    }
    

    public function updateSettings(Request $request)
    {
        // $usuario = auth()->user();
        // $usuario->notificaciones_email = $request->has('emailNotifications');
        // $usuario->notificaciones_whatsapp = $request->has('whatsappNotifications');
        // $usuario->notificaciones_sms = $request->has('smsNotifications');
        // $usuario->save();

        // return redirect()->route('perfil.index')->with('success', 'Configuraciones actualizadas correctamente');
    }

    public function cambiarPassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    
        $userId = auth()->id(); 
        if (!$userId) {
            return redirect()->back()->withErrors(['error' => 'Usuario no autenticado o no encontrado.']);
        }
        $usuario = User::find($userId); 
        if (!$usuario) {
            return redirect()->back()->withErrors(['error' => 'Usuario no encontrado en la base de datos.']);
        }
        $currentPassword = trim($request->current_password);
        if (!Hash::check($currentPassword, $usuario->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
        }
        $usuario->password = Hash::make($request->password);
        $usuario->password_restaurada = false;
        $usuario->save();
        return redirect()->route('perfil.index')->with('success', 'Configuraciones actualizadas correctamente');
    }
}
