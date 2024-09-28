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
use App\Http\Controllers\EventController;

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
        Route::post('/usuarios/guardar', [UsuarioController::class, 'guardarUsuario'])->name('usuarios.guardar');
        Route::post('/usuarios/editar/{id}', [UsuarioController::class, 'editarUsuario'])->name('usuarios.editar');
        Route::delete('/usuarios/eliminar/{id}', [UsuarioController::class, 'eliminarUsuario'])->name('usuarios.eliminar');
        Route::get('/usuarios/obtener/{id?}', [UsuarioController::class, 'obtenerUsuario'])->name('usuarios.obtener');
        Route::post('/usuarios/verificar/email', [UsuarioController::class, 'verificarEmail'])->name('usuarios.verificar.email');
        Route::post('/usuarios/verificar/telefono', [UsuarioController::class, 'verificarTelefono'])->name('usuarios.verificar.telefono');
        Route::post('/usuarios/resetPassword/{id}', [UsuarioController::class, 'resetPassword'])->name('usuarios.resetPassword');
    });

    // Perfil (todos los roles)
    Route::get('/perfil/{id}', [PerfilController::class, 'index'])->name('perfil.index');
    Route::post('/perfil/agregar', [PerfilController::class, 'guardarUsuario'])->name('perfil.guardar');
    Route::post('/perfil/guardar', [PerfilController::class, 'cambiosUsuario'])->name('perfil.cambios');
    Route::put('/perfil/settings', [PerfilController::class, 'updateSettings'])->name('perfil.settings');
    Route::put('/perfil/cambiarPassword', [PerfilController::class, 'cambiarPassword'])->name('perfil.cambiarPassword');

    // Distritos (solo para Administrador)
    Route::middleware('role:1')->group(function () {
        Route::get('/distritos', [DistritoController::class, 'index'])->name('distritos.index');
        Route::post('/distritos/guardar', [DistritoController::class, 'guardarDistrito'])->name('distritos.guardar');
        Route::post('/distritos/editar/{iddistrito}', [DistritoController::class, 'editarDistrito'])->name('distritos.editar');
        Route::delete('/distritos/eliminar/{iddistrito}', [DistritoController::class, 'eliminarDistrito'])->name('distritos.eliminar');
        Route::get('/distritos/obtener/{iddistrito}', [DistritoController::class, 'obtenerDistrito']);
        Route::post('/distritos/verificar-duplicado', [DistritoController::class, 'verificarDuplicado']);
    });

    // Juzgados (solo para Administrador)
    Route::middleware('role:1')->group(function () {
        Route::get('/juzgados', [JuzgadoController::class, 'index'])->name('juzgados.index');
        Route::post('/juzgados/guardar', [JuzgadoController::class, 'guardarJuzgado'])->name('juzgados.guardar');
        Route::post('/juzgados/editar/{idjuzgados}', [JuzgadoController::class, 'editarJuzgado'])->name('juzgados.editar');
        Route::delete('/juzgados/eliminar/{idjuzgados}', [JuzgadoController::class, 'eliminarJuzgado'])->name('juzgados.eliminar');
        Route::get('/juzgados/obtener/{idjuzgados?}', [JuzgadoController::class, 'obtenerJuzgado']);
        Route::post('/juzgados/verificar', [JuzgadoController::class, 'verificarJuzgado'])->name('juzgados.verificar');
    });

    // Expedientes (para Administrador, Juzgados, Consultor, Usuario)
    Route::middleware('role:1,2,3,4')->group(function () {
        Route::get('/expedientes', [ExpedienteController::class, 'index'])->name('expedientes.index');
        Route::get('/expedientes/{id_expedientes}', [ExpedienteController::class, 'show'])->name('expedientes.show');
        Route::get('/expedientes/descripcion/{id_expedientes}', [ExpedienteController::class, 'descripcion'])->name('descripcionExpedientes');
    });

    // Tipo Expediente (solo para Administrador)
    Route::middleware('role:1')->group(function () {
        Route::get('/tipoExpedientes', [TipoExpedienteController::class, 'index'])->name('tipoExpedientes.index');
        Route::post('/tipoExpedientes/guardar', [TipoExpedienteController::class, 'guardarTipoExpediente'])->name('tipoExpedientes.guardar');
        Route::post('/tipoExpedientes/editar/{idtipoexpediente}', [TipoExpedienteController::class, 'editarTipoExpediente'])->name('tipoExpedientes.editar');
        Route::delete('/tipoExpedientes/eliminar/{idtipoexpediente}', [TipoExpedienteController::class, 'eliminarTipoExpediente'])->name('tipoExpedientes.eliminar');
        Route::get('/tipoExpedientes/obtener/{idtipoexpediente}', [TipoExpedienteController::class, 'obtenerTipoExpediente']);
        Route::post('/tipoExpedientes/verificar', [TipoExpedienteController::class, 'verificarDuplicado']);
    });

    // Estatus Expediente (solo para Administrador)
    Route::middleware('role:1')->group(function () {
        Route::get('/estatus/expedientes', [EstatusExpedienteController::class, 'index'])->name('estatusExpediente.index');
        Route::post('/estatus/expedientes/guardar', [EstatusExpedienteController::class, 'guardarEstatusExpediente'])->name('estatusExpediente.guardar');
        Route::post('/estatus/expedientes/editar/{idestatusexpediente}', [EstatusExpedienteController::class, 'editarEstatusExpediente'])->name('estatusExpediente.editar');
        Route::delete('/estatus/expedientes/eliminar/{idestatusexpediente}', [EstatusExpedienteController::class, 'eliminarEstatusExpediente'])->name('estatusExpediente.eliminar');
        Route::get('/estatus/expedientes/obtener/{idestatusexpediente}', [EstatusExpedienteController::class, 'obtenerEstatusExpediente']);
        Route::post('/estatus/expedientes/verificar', [EstatusExpedienteController::class, 'verificarDuplicado']);
    });

    // Tipo Búsqueda (para Consultor y Administrador)
    Route::middleware('role:1,3')->group(function () {
        Route::get('/tipo/busquedas', [TipoBusquedaController::class, 'index'])->name('tipoBusquedas.index');
        Route::post('/tipo/busquedas/guardar', [TipoBusquedaController::class, 'guardarTipoBusqueda'])->name('tipoBusquedas.guardar');
        Route::post('/tipo/busquedas/editar/{idtipobusqueda}', [TipoBusquedaController::class, 'editarTipoBusqueda'])->name('tipoBusquedas.editar');
        Route::delete('/tipo/busquedas/eliminar/{idtipobusqueda}', [TipoBusquedaController::class, 'eliminarTipoBusqueda'])->name('tipoBusquedas.eliminar');
        Route::get('/tipo/busquedas/obtener/{idtipobusqueda?}', [TipoBusquedaController::class, 'obtenerTipoBusqueda']);
        Route::post('/tipo/busquedas/verificar', [TipoBusquedaController::class, 'verificarDuplicado']);
    });

    // Eventos Calendario (todos los roles)
    Route::get('/events', [EventController::class, 'index']);
    Route::post('/events', [EventController::class, 'store']);
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);
    Route::get('/events/check-repetition/{id}', [EventController::class, 'checkRepetition']);
    Route::get('/events/today/count', [EventController::class, 'getTodayEventsCount']);
    Route::get('/events/upcoming/count', [EventController::class, 'countUpcomingEvents']);
});

// Rutas sin middleware de autenticación
Route::get('/usuarios/resetPassword', [UsuarioController::class, 'cambiarPasswordVista'])->name('cambiarPasswordVista')->withoutMiddleware([ResetPassword::class]);
Route::post('/usuarios/resetPassword', [UsuarioController::class, 'cambiarPassword'])->name('cambiarPassword')->withoutMiddleware([ResetPassword::class]);
