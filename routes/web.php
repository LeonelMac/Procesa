<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CiudadController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PerfilController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

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

// Ciudades
Route::get('/ciudades', [CiudadController::class, 'index'])->name('ciudades.index');
Route::put('/ciudades/{id}', [CiudadController::class, 'update'])->name('ciudades.update');
Route::delete('/ciudades/{id}', [CiudadController::class, 'destroy'])->name('ciudades.destroy');

// Clientes
Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
Route::put('/clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');
Route::delete('/clientes/{id}', [ClienteController::class, 'destroy'])->name('clientes.destroy');

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
Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

// Roles
Route::get('/roles', [RolController::class, 'index'])->name('roles.index');
Route::put('/roles/{id}', [RolController::class, 'update'])->name('roles.update');
Route::delete('/roles/{id}', [RolController::class, 'destroy'])->name('roles.destroy');

// Perfil
Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');
Route::put('/perfil', [PerfilController::class, 'update'])->name('perfil.update');
Route::put('/perfil/settings', [PerfilController::class, 'updateSettings'])->name('perfil.settings');
Route::put('/perfil/change-password', [PerfilController::class, 'changePassword'])->name('perfil.change_password');

