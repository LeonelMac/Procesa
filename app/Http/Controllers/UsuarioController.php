<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\PasswordResetNotification;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $usuarios = User::with('rol', 'municipio')->get(); // Asegúrate de que las relaciones estén definidas en el modelo User
        return view('usuarios', compact('usuarios'));
    }

    public function guardarUsuario(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidoP' => 'required|string|max:255',
            'apellidoM' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'rol' => 'required|numeric',
            'municipio' => 'required|numeric',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:10',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $password = $this->generateSecurePassword(12);
        $usuario = User::create([
            'nombres' => $request->nombres,
            'apellidoP' => $request->apellidoP,
            'apellidoM' => $request->apellidoM,
            'email' => $request->email,
            'rol' => $request->rol,
            'municipio' => $request->municipio,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'password' => Hash::make($password),
        ]);
        Mail::to($usuario->email)->send(new WelcomeEmail($usuario, $password));
        session()->flash('message', 'Usuario creado correctamente.');
        return redirect()->route('usuarios.index');
    }

    public function cambiosUsuario(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'nombres' => 'required|string|max:255',
            'apellidoP' => 'required|string|max:255',
            'apellidoM' => 'required|string|max:255',
            'rol' => 'required|numeric',
            'municipio' => 'required|numeric',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:10',
        ]);

        if ($validator->fails()) {
            session()->flash('message', $validator->errors()->first());
            session()->flash('message_type', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $usuario = User::find($request->id);

        if (!$usuario) {
            session()->flash('message', 'Usuario no encontrado.');
            return redirect()->route('usuarios.index');
        }

        $usuario->update([
            'nombres' => $request->nombres,
            'apellidoP' => $request->apellidoP,
            'apellidoM' => $request->apellidoM,
            'rol' => $request->rol,
            'municipio' => $request->municipio,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
        ]);

        session()->flash('message', 'Usuario actualizado correctamente.');
        return redirect()->route('usuarios.index');
    }

    public function eliminarUsuario($id)
    {
        $usuario = User::find($id);
        if (!$usuario) {
            return response()->json(['success' => false, 'message' => 'Usuario no encontrado.'], 404);
        }
        if ($usuario->id == auth()->user()->id) {
            return response()->json(['success' => false, 'message' => 'No puedes eliminar tu propio usuario.'], 403);
        }
        $usuario->delete();
        return response()->json(['success' => true, 'message' => 'Usuario eliminado correctamente.']);
    }
    
    public function resetPassword($id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json(['success' => false, 'message' => 'Usuario no encontrado'], 404);
        }

        $nuevaPassword = $this->generateSecurePassword(12);
        $usuario->password = Hash::make($nuevaPassword);
        $usuario->password_restaurada = true;
        $usuario->save();

        Mail::to($usuario->email)->send(new PasswordResetNotification($usuario, $nuevaPassword));

        return response()->json(['success' => true, 'message' => 'Contraseña restablecida correctamente y correo enviado.']);
    }

    public function generateSecurePassword($length = 12)
    {
        $upper = Str::upper(Str::random(2));
        $lower = Str::lower(Str::random(4));
        $numbers = random_int(10, 99) . random_int(10, 99);
        $specialCharacters = '!@#$%^&*';
        $special = substr(str_shuffle($specialCharacters), 0, 2);
        $password = str_shuffle($upper . $lower . $numbers . $special);
        return substr($password, 0, $length);
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
        $usuario->setRememberToken(Str::random(60));
        $usuario->save();
        return redirect('/inicio')->with('message', 'Contraseña actualizada correctamente.');
    }

    public function cambiarPasswordVista()
    {
        return view('auth.resetPassword');
    }
}
