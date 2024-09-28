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
            'municipio' => ['required', 'numeric'],
            'direccion' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:10'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }
        $formFields = $validator->validated();
        $id = $formFields['id'];
        $usuario = User::find($id);
        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }
        $usuario->update($formFields);
        return response()->json([
            'success' => true,
            'message' => 'Perfil actualizado correctamente'
        ], 200);
    }

    public function cambiarPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }
        $userId = auth()->id();
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no autenticado o no encontrado.',
            ], 401);
        }
        $usuario = User::find($userId);
        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado en la base de datos.',
            ], 404);
        }
        $currentPassword = trim($request->current_password);
        if (!Hash::check($currentPassword, $usuario->password)) {
            return response()->json([
                'success' => false,
                'message' => 'La contraseña actual no es correcta.',
            ], 422);
        }
        $usuario->password = Hash::make($request->password);
        $usuario->password_restaurada = false;
        $usuario->save();
        return response()->json([
            'success' => true,
            'message' => 'Contraseña actualizada correctamente.',
        ], 200);
    }
}
