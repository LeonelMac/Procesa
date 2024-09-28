<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rol;
use App\Models\Municipio;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\WelcomeEmail;
use App\Mail\PasswordResetNotification;

class UsuarioController extends Controller
{
    // Middleware para verificar la autenticación
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Mostrar listado de usuarios
    public function index()
    {
        $usuarios = User::with('rol', 'municipio')->get();
        $roles = Rol::all();
        $municipios = Municipio::all();
        return view('usuarios', compact('usuarios', 'roles', 'municipios'));
    }

    // Obtener usuario específico o listado de roles y municipios
    public function obtenerUsuario($id = null)
    {
        $roles = Rol::all();
        $municipios = Municipio::all();

        if ($id) {
            $usuario = User::with('rol', 'municipio')->findOrFail($id);
            return response()->json([
                'usuario' => $usuario,
                'roles' => $roles,
                'municipios' => $municipios,
            ]);
        }

        return response()->json([
            'roles' => $roles,
            'municipios' => $municipios,
        ]);
    }

    // Guardar un nuevo usuario
    public function guardarUsuario(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidoP' => 'required|string|max:255',
            'apellidoM' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'rol' => 'required|exists:rolusuarios,id_rolusuarios',
            'municipio' => 'required|exists:municipio,idmunicipio',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:10|unique:users,telefono',
        ]);

        // Generación de contraseña segura
        $password = $this->generateSecurePassword();

        // Creación del usuario
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

        // Envío de correo de bienvenida con la contraseña generada
        Mail::to($usuario->email)->send(new WelcomeEmail($usuario, $password));

        session()->flash('message', 'Usuario creado correctamente.');
        return redirect()->route('usuarios.index');
    }

    // Editar un usuario existente
    public function editarUsuario(Request $request, $id)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidoP' => 'required|string|max:255',
            'apellidoM' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'rol' => 'required|exists:rolusuarios,id_rolusuarios',
            'municipio' => 'required|exists:municipio,idmunicipio',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:10|unique:users,telefono,' . $id,
        ]);

        $usuario = User::findOrFail($id);
        $usuario->update([
            'nombres' => $request->nombres,
            'apellidoP' => $request->apellidoP,
            'apellidoM' => $request->apellidoM,
            'email' => $request->email,
            'rol' => $request->rol,
            'municipio' => $request->municipio,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
        ]);

        return redirect()->route('usuarios.index');
    }

    // Eliminar un usuario
    public function eliminarUsuario($id)
    {
        $usuario = User::findOrFail($id);
        if (auth()->user()->id == $usuario->id) {
            return redirect()->route('usuarios.index')->with('error', 'No puedes eliminar tu propio usuario.');
        }
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
    
    // Restablecer contraseña de un usuario
    public function resetPassword($id)
    {
        $usuario = User::findOrFail($id);

        // Generación de nueva contraseña segura
        $nuevaPassword = $this->generateSecurePassword();

        // Actualización de la contraseña
        $usuario->password = Hash::make($nuevaPassword);
        $usuario->password_restaurada = true;
        $usuario->save();

        // Envío de correo de notificación de restablecimiento de contraseña
        Mail::to($usuario->email)->send(new PasswordResetNotification($usuario, $nuevaPassword));

        return response()->json(['success' => true, 'message' => 'Contraseña restablecida correctamente y correo enviado.']);
    }

    // Cambiar la contraseña del usuario autenticado
    public function cambiarPassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    
        $usuario = User::find(auth()->id());
    
        // Verificar que la contraseña actual sea correcta
        if (!$usuario || !Hash::check($request->current_password, $usuario->password)) {
            return response()->json(['success' => false, 'message' => 'La contraseña actual no es correcta.'], 400);
        }
    
        // Actualizar la nueva contraseña
        $usuario->password = Hash::make($request->password);
        $usuario->password_restaurada = false;
        $usuario->save();
    
        return response()->json(['success' => true, 'message' => 'Contraseña actualizada correctamente.']);
    }
    

    // Vista para cambiar la contraseña
    public function cambiarPasswordVista()
    {
        return view('auth.resetPassword');
    }

    // Genera una contraseña segura de 12 caracteres
    private function generateSecurePassword($length = 12)
    {
        $upper = Str::upper(Str::random(2));
        $lower = Str::lower(Str::random(4));
        $numbers = random_int(10, 99) . random_int(10, 99);
        $specialCharacters = '!@#$%^&*';
        $special = substr(str_shuffle($specialCharacters), 0, 2);
        $password = str_shuffle($upper . $lower . $numbers . $special);
        return substr($password, 0, $length);
    }

    public function verificarEmail(Request $request)
    {
        $query = User::where('email', $request->email);
    
        // Excluir al usuario actual en el caso de edición
        if ($request->user_id) {
            $query->where('id', '!=', $request->user_id);
        }
    
        $existe = $query->exists();
        return response()->json(['exists' => $existe]);
    }
    
    public function verificarTelefono(Request $request)
    {
        $query = User::where('telefono', $request->telefono);
    
        // Excluir al usuario actual en el caso de edición
        if ($request->user_id) {
            $query->where('id', '!=', $request->user_id);
        }
    
        $existe = $query->exists();
        return response()->json(['exists' => $existe]);
    }
    
}
