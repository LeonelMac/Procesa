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
use App\Http\Middleware\ResetPassword;

// Proceso de Login y Logout
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

    // Usuarios
    // Route::middleware('role:Administrador')->group(function () {
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::post('/usuarios/agregar', [UsuarioController::class, 'guardarUsuario'])->name('guardarUsuario');
    Route::post('/usuarios/guardar', [UsuarioController::class, 'cambiosUsuario'])->name('cambiosUsuario');
    // });

    // Perfil
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');
    Route::put('/perfil', [PerfilController::class, 'update'])->name('perfil.update');
    Route::put('/perfil/settings', [PerfilController::class, 'updateSettings'])->name('perfil.settings');
    Route::put('/perfil/change-password', [PerfilController::class, 'changePassword'])->name('perfil.change_password');

    // Distritos
    Route::get('/distritos', [DistritoController::class, 'index'])->name('distritos.index');
    Route::post('/distritos/guardar', [DistritoController::class, 'guardarDistrito'])->name('distritos.guardar');
    Route::post('/distritos/editar/{iddistrito}', [DistritoController::class, 'editarDistrito'])->name('distritos.editar');
    Route::delete('/distritos/eliminar/{iddistrito}', [DistritoController::class, 'eliminarDistrito'])->name('distritos.eliminar');
    Route::get('/distritos/obtener/{iddistrito}', [DistritoController::class, 'obtenerDistrito']);

    // Juzgados
    Route::get('/juzgados', [JuzgadoController::class, 'index'])->name('juzgados.index');
    Route::post('/juzgados/guardar', [JuzgadoController::class, 'guardarJuzgado'])->name('juzgados.guardar');
    Route::post('/juzgados/editar/{idjuzgados}', [JuzgadoController::class, 'editarJuzgado'])->name('juzgados.editar');
    Route::delete('/juzgados/eliminar/{idjuzgados}', [JuzgadoController::class, 'eliminarJuzgado'])->name('juzgados.eliminar');
    Route::get('/juzgados/obtener/{idjuzgados?}', [JuzgadoController::class, 'obtenerJuzgado']);

    // Expedientes
    Route::get('/expedientes', [ExpedienteController::class, 'index'])->name('expedientes.index');
    Route::get('/expedientes/{id_expedientes}', [ExpedienteController::class, 'show'])->name('expedientes.show');
    Route::get('/expedientes/descripcion/{id_expedientes}', [ExpedienteController::class, 'descripcion'])->name('descripcionExpedientes');

    // Tipo Expediente
    Route::get('/tipo/expedientes', [TipoExpedienteController::class, 'index'])->name('tipoExpedientes.index');
    Route::put('/tipo/expedientes/{id}', [TipoExpedienteController::class, 'update'])->name('tipoExpedientes.update');
    Route::delete('/tipo/expedientes/{id}', [TipoExpedienteController::class, 'destroy'])->name('tipoExpedientes.destroy');

    // Estatus Expediente
    Route::get('/estatus/expedientes', [EstatusExpedienteController::class, 'index'])->name('estatusExpediente.index');
    Route::put('/estatus/expedientes/{id}', [EstatusExpedienteController::class, 'update'])->name('estatusExpediente.update');
    Route::delete('/estatus/expedientes/{id}', [EstatusExpedienteController::class, 'destroy'])->name('estatusExpediente.destroy');

    // Tipo Búsqueda
    Route::get('/tipo/busquedas', [TipoBusquedaController::class, 'index'])->name('tipoBusquedas.index');
    Route::post('/tipo/busquedas/guardar', [TipoBusquedaController::class, 'guardarTipoBusqueda'])->name('tipoBusquedas.guardar');
    Route::post('/tipo/busquedas/editar/{idtipobusqueda}', [TipoBusquedaController::class, 'editarTipoBusqueda'])->name('tipoBusquedas.editar');
    Route::delete('/tipo/busquedas/eliminar/{idtipobusqueda}', [TipoBusquedaController::class, 'eliminarTipoBusqueda'])->name('tipoBusquedas.eliminar');
    Route::get('/tipo/busquedas/obtener/{idtipobusqueda?}', [TipoBusquedaController::class, 'obtenerTipoBusqueda']);    
});

// // Rutas sin middleware de autenticación
// Route::get('/usuarios/resetPassword', [UsuarioController::class, 'cambiarPasswordVista'])->name('cambiarPasswordVista')->withoutMiddleware([ResetPassword::class]);
// Route::post('/usuarios/resetPassword', [UsuarioController::class, 'cambiarPassword'])->name('cambiarPassword')->withoutMiddleware([ResetPassword::class]);
