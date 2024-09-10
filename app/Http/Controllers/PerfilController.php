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
    public function index()
    {
        $usuario = auth()->user();
        return view('perfil', compact('usuario'));
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
        return view('auth.perfil', compact('roles', 'municipios'));
    }

    public function cambiosUsuario(Request $request)
    {
        $requestData = request()->all();
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
        unset($formFields['id']);
    
        User::find($id)->update($formFields);
        
        session()->flash('message', 'Usuario editado');
        session()->flash('message_type', 'success');
        return redirect('/usuarios');
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

    public function changePassword(Request $request)
    {
        // $request->validate([
        //     'current_password' => 'required',
        //     'new_password' => 'required|confirmed|min:6',
        // ]);

        // $usuario = auth()->user();

        // if (!Hash::check($request->current_password, $usuario->password)) {
        //     return back()->withErrors(['current_password' => 'La contraseña actual no es correcta']);
        // }

        // $usuario->password = Hash::make($request->new_password);
        // $usuario->save();

        // return redirect()->route('perfil.index')->with('success', 'Contraseña actualizada correctamente');
    }
}
