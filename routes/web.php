<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DistritoController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PerfilController;
use App\Http\Middleware\ResetPassword;

// Formulario de login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Proceso de login
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//Inicio
Route::get('/inicio', function () {
    return view('inicio'); 
})->middleware('auth')->name('inicio');

Route::get('/inicio_user', function () {
    return view('inicio_user'); 
})->middleware('auth')->name('inicio_user');

// Distritos
Route::get('/distritos', [DistritoController::class, 'index'])->name('distritos.index');
Route::put('/distritos/{id}', [DistritoController::class, 'update'])->name('distritos.update');
Route::delete('/distritos/{id}', [DistritoController::class, 'destroy'])->name('distritos.destroy');

// Expedientes
Route::get('/expedientes', [ExpedienteController::class, 'index'])->name('expedientes.index'); 
Route::get('/expedientes_user', [ExpedienteController::class, 'indexUser'])->name('expedientes_user.index'); 
Route::get('/expedientes/{id}', [ExpedienteController::class, 'show'])->name('expedientes.show');
Route::get('/expedientes/{id}/descripcion', [ExpedienteController::class, 'descripcion'])->name('expedientes.descripcion');
Route::get('/expedientes/{id}/descripcion-copy', [ExpedienteController::class, 'descripcionCopy'])->name('expedientes.descripcion.copy');
Route::get('/expedientes_user/{id}/descripcion', [ExpedienteController::class, 'descripcionUser'])->name('expedientes.user.descripcion');
Route::get('/expedientes_user/{id}/descripcion-copy', [ExpedienteController::class, 'descripcionUserCopy'])->name('expedientes.user.descripcion.copy');

// Usuarios
Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
// Route::get('/usuarios', [UsuariosController::class, 'listaDeUsuarios'])->name('listaDeUsuarios')->middleware('role:Administrador');
Route::get('/usuarios/editar/{id}', [UsuarioController::class, 'editarUsuario'])->name('editarUsuario');
Route::post('/usuarios/guardar', [UsuarioController::class, 'cambiosUsuario'])->name('cambiosUsuario');
Route::get('/usuarios/resetPassword', [UsuarioController::class, 'cambiarPasswordVista'])->name('cambiarPasswordVista')->withoutMiddleware([ResetPassword::class]);
Route::post('/usuarios/resetPassword', [UsuarioController::class, 'cambiarPassword'])->name('cambiarPassword')->withoutMiddleware([ResetPassword::class]);

// Perfil
Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');
Route::put('/perfil', [PerfilController::class, 'update'])->name('perfil.update');
Route::put('/perfil/settings', [PerfilController::class, 'updateSettings'])->name('perfil.settings');
Route::put('/perfil/change-password', [PerfilController::class, 'changePassword'])->name('perfil.change_password');

