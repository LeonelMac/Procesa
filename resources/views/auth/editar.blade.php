@extends('layouts.main')

@section('titulo', 'Editar Usuario')

@section('content')
    <x-mensaje />
    <main id="main" class="main">
        <!-- Page Title -->
        <div class="pagetitle">
            <h1>Usuarios</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Inicio</a></li>
                    <li class="breadcrumb-item">Configuración</li>
                    <li class="breadcrumb-item active">Usuarios</li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->

        <section class="section dashboard">
            <div class="shadow rounded">
                <div class="card shadow border-0 rounded">
                    <div class="card-body bg-white p-5">
                        <div class="d-flex flex-row mb-3">
                            <a href="{{ route('usuarios.index') }}" class="d-inline-block mt-1">
                                <i class="fa-solid fa-circle-left" style="color: #198754; font-size: 1.5rem;"></i>
                            </a>
                            <h2 class="mx-4">Editar usuario</h2>
                        </div>
                        <form method="POST" action="{{ route('cambiosUsuario') }}">
                            @csrf
                            <input id="id" type="number" hidden name="id" value="{{ Session::get('usuario')->id }}" required>

                            <!-- Nombres -->
                            <div class="row mb-3">
                                <label for="nombres" class="col-md-4 col-form-label text-md-end">{{ __('Nombres') }}</label>
                                <div class="col-md-6">
                                    <input id="nombres" type="text" 
                                           class="form-control @error('nombres') is-invalid @enderror"
                                           name="nombres" 
                                           value="{{ Session::get('usuario')->nombres }}" 
                                           required autocomplete="nombres">
                                    @error('nombres')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Correo Electrónico -->
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Correo Electrónico') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" 
                                           class="form-control @error('email') is-invalid @enderror"
                                           name="email" 
                                           value="{{ Session::get('usuario')->email }}" 
                                           required autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Apellido Paterno -->
                            <div class="row mb-3">
                                <label for="apellidoP" class="col-md-4 col-form-label text-md-end">{{ __('Apellido Paterno') }}</label>
                                <div class="col-md-6">
                                    <input id="apellidoP" type="text" 
                                           class="form-control @error('apellidoP') is-invalid @enderror"
                                           name="apellidoP" 
                                           value="{{ Session::get('usuario')->apellidoP }}" 
                                           required autocomplete="apellidoP">
                                    @error('apellidoP')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Apellido Materno -->
                            <div class="row mb-3">
                                <label for="apellidoM" class="col-md-4 col-form-label text-md-end">{{ __('Apellido Materno') }}</label>
                                <div class="col-md-6">
                                    <input id="apellidoM" type="text" 
                                           class="form-control @error('apellidoM') is-invalid @enderror"
                                           name="apellidoM" 
                                           value="{{ Session::get('usuario')->apellidoM }}" 
                                           required autocomplete="apellidoM">
                                    @error('apellidoM')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Rol -->
                            <div class="row mb-3">
                                <label for="rol" class="col-md-4 col-form-label text-md-end">{{ __('Rol') }}</label>
                                <div class="col-md-6">
                                    <select id="rol" 
                                            class="form-control @error('rol') is-invalid @enderror" 
                                            name="rol" 
                                            required>
                                        <option value="">Seleccione un rol</option>
                                        @foreach($roles as $rol)
                                            <option value="{{ $rol->id_rolusuarios }}" 
                                                {{ Session::get('usuario')->rol == $rol->id_rolusuarios ? 'selected' : '' }}>
                                                {{ $rol->rolusuarios }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('rol')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Municipio -->
                            <div class="row mb-3">
                                <label for="municipio" class="col-md-4 col-form-label text-md-end">{{ __('Municipio') }}</label>
                                <div class="col-md-6">
                                    <select id="municipio" 
                                            class="form-control @error('municipio') is-invalid @enderror" 
                                            name="municipio" 
                                            required>
                                        <option value="">Seleccione un municipio</option>
                                        @foreach($municipios as $municipio)
                                            <option value="{{ $municipio->idmunicipio }}" 
                                                {{ Session::get('usuario')->municipio == $municipio->idmunicipio ? 'selected' : '' }}>
                                                {{ $municipio->municipio }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('municipio')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Dirección -->
                            <div class="row mb-3">
                                <label for="direccion" class="col-md-4 col-form-label text-md-end">{{ __('Dirección') }}</label>
                                <div class="col-md-6">
                                    <input id="direccion" type="text" 
                                           class="form-control @error('direccion') is-invalid @enderror"
                                           name="direccion" 
                                           value="{{ Session::get('usuario')->direccion }}" 
                                           required autocomplete="direccion">
                                    @error('direccion')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Teléfono -->
                            <div class="row mb-3">
                                <label for="telefono" class="col-md-4 col-form-label text-md-end">{{ __('Teléfono') }}</label>
                                <div class="col-md-6">
                                    <input id="telefono" type="text" 
                                           class="form-control @error('telefono') is-invalid @enderror"
                                           name="telefono" 
                                           value="{{ Session::get('usuario')->telefono }}" 
                                           required autocomplete="telefono">
                                    @error('telefono')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Guardar -->
                            <div class="row mb-0">
                                <div class="d-flex col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-success ms-auto">
                                        {{ __('Guardar') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
