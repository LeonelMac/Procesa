<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DistritoController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PerfilController;
use App\Http\Middleware\ResetPassword;

// Proceso de Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas autenticadas
Route::middleware('auth')->group(function () {
    // Inicio
    Route::get('/inicio', function () {
        return view('inicio'); 
    })->name('inicio');

    Route::get('/inicio_user', function () {
        return view('inicio_user'); 
    })->name('inicio_user');

    // Distritos
    Route::get('/distritos', [DistritoController::class, 'index'])->name('distritos.index');
    Route::put('/distritos/{id}', [DistritoController::class, 'update'])->name('distritos.update');
    Route::delete('/distritos/{id}', [DistritoController::class, 'destroy'])->name('distritos.destroy');

    // Expedientes
    Route::get('/expedientes', [ExpedienteController::class, 'index'])->name('expedientes.index'); 
    Route::get('/expedientes/{id_expedientes}', [ExpedienteController::class, 'show'])->name('expedientes.show');
    Route::get('/expedientes/{id_expedientes}/descripcion', [ExpedienteController::class, 'descripcion'])->name('expedientes.descripcion');
    // Usuarios
    // Route::middleware('role:Administrador')->group(function () {
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/editar/{id}', [UsuarioController::class, 'editarUsuario'])->name('editarUsuario');
        Route::post('/usuarios/guardar', [UsuarioController::class, 'cambiosUsuario'])->name('cambiosUsuario');
    // });

    // Perfil
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');
    Route::put('/perfil', [PerfilController::class, 'update'])->name('perfil.update');
    Route::put('/perfil/settings', [PerfilController::class, 'updateSettings'])->name('perfil.settings');
    Route::put('/perfil/change-password', [PerfilController::class, 'changePassword'])->name('perfil.change_password');
});

// Rutas sin middleware de autenticación
Route::get('/usuarios/resetPassword', [UsuarioController::class, 'cambiarPasswordVista'])->name('cambiarPasswordVista')->withoutMiddleware([ResetPassword::class]);
Route::post('/usuarios/resetPassword', [UsuarioController::class, 'cambiarPassword'])->name('cambiarPassword')->withoutMiddleware([ResetPassword::class]);
