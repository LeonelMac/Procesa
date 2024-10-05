<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DistritoController;
use App\Http\Controllers\JuzgadoController;
use App\Http\Controllers\TipoExpedienteController;
use App\Http\Controllers\TipoBusquedaController;
use App\Http\Controllers\EstatusExpedienteController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PerfilController;

// Proceso de Login y Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas autenticadas
Route::middleware('auth')->group(function () {
    // Inicio para todos los roles
    Route::get('/inicio', function () {
        return view('inicio');
    })->name('inicio');

    Route::get('/inicio_user', function () {
        return view('inicio_user');
    })->name('inicio_user');

    // Usuarios (solo para Administrador)
    Route::middleware('role:1')->group(function () {
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    });

    // Perfil (todos los roles)
    Route::get('/perfil/{id}', [PerfilController::class, 'index'])->name('perfil.index');

    // Distritos (solo para Administrador)
    Route::middleware('role:1')->group(function () {
        Route::get('/distritos', [DistritoController::class, 'index'])->name('distritos.index');
    });

    // Juzgados (solo para Administrador)
    Route::middleware('role:1')->group(function () {
        Route::get('/juzgados', [JuzgadoController::class, 'index'])->name('juzgados.index');
    });

    // Expedientes (para Administrador, Juzgados, Consultor, Usuario)
    Route::middleware('role:1,2,3,4')->group(function () {
        Route::get('/expedientes', [ExpedienteController::class, 'index'])->name('expedientes.index');
    });

    // Tipo Expediente (solo para Administrador)
    Route::middleware('role:1')->group(function () {
        Route::get('/tipoExpedientes', [TipoExpedienteController::class, 'index'])->name('tipoExpedientes.index');
    });

    // Estatus Expediente (solo para Administrador)
    Route::middleware('role:1')->group(function () {
        Route::get('/estatus/expedientes', [EstatusExpedienteController::class, 'index'])->name('estatusExpediente.index');
    });

    // Tipo Búsqueda (para Consultor y Administrador)
    Route::middleware('role:1,3')->group(function () {
        Route::get('/tipo/busquedas', [TipoBusquedaController::class, 'index'])->name('tipoBusquedas.index');
    });
});