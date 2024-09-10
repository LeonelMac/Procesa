<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use \Illuminate\Validation\Rule;
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
        
        session()->flash('usuario', $usuario);
        return view('auth.editar', compact('roles', 'municipios'));
    }
    

    public function cambiarPasswordVista(){
        return view('auth.resetPassword');
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

    public function cambiarPassword(Request $request){
        $requestData = request()->all();
        $validator =  Validator::make($requestData, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $validator->validate();
        $id = auth()->user()->id;
        $user = User::find($id);
        $user->password = bcrypt($validator->getData()['password']);
        $user->password_restaurada = false;
        $user->save();
        $usuariosController = new UsuarioController();
        $usuariosController->usuario('cambiarPassword', 'actualizó o intentó actualizar su contraseña', $request);
        return redirect('/');
    }

}
