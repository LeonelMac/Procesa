<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $usuarios = User::all();
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

        User::create([
            'nombres' => $request->nombres,
            'apellidoP' => $request->apellidoP,
            'apellidoM' => $request->apellidoM,
            'email' => $request->email,
            'rol' => $request->rol,
            'municipio' => $request->municipio,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'password' => bcrypt('123456'),
        ]);

        session()->flash('message', 'Usuario creado correctamente.');
        return redirect()->route('usuarios.index');
    }


    public function editarUsuario($id)
    {
        $usuario = User::find($id);
        if (!$usuario) {
            session()->flash('message', 'Usuario no encontrado');
            session()->flash('message_type', 'error');
            return redirect('/usuarios');
        }

        $roles = Rol::all();
        $municipios = Municipio::all();

        session()->put('usuario', $usuario);
        session()->put('roles', $roles);
        session()->put('municipios', $municipios);

        return view('auth.editar-modal', compact('roles', 'municipios'));
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
