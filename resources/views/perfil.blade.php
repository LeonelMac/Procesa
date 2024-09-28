@extends('layouts.main')

@section('content')
    <main id="main2" class="main2">
        <div class="pagetitle">
            <h1>Perfil</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Perfil</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
                            <h2>{{ Auth::user()->nombres }} {{ Auth::user()->apellidoP }} {{ Auth::user()->apellidoM }}</h2>
                            <h3> 
                                <span>
                                    @php
                                        $rolUsuario = $roles->firstWhere('id_rolusuarios', $usuario->rol);
                                    @endphp
                                    <p class="form-control-plaintext">
                                        {{ $rolUsuario ? $rolUsuario->rolusuarios : 'Rol no asignado' }}</p>
                                </span>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">
                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#profile-overview">Descripción General</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Editar
                                        Perfil</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#profile-change-password">Cambiar la Contraseña</button>
                                </li>
                            </ul>
                            <div class="tab-content pt-2">
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title">Detalles del perfil</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Nombre completo</div>
                                        <div class="col-lg-9 col-md-8">{{ $usuario->nombres }} {{ $usuario->apellidoP }}
                                            {{ $usuario->apellidoM }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Correo Electrónico</div>
                                        <div class="col-lg-9 col-md-8">{{ $usuario->email }}</div>
                                    </div>

                                    <div class="row">
                                        <label for="rol" class="col-lg-3 col-md-4 label">{{ __('Rol') }}</label>
                                        <div class="col-lg-9 col-md-8">
                                            @php
                                                $rolUsuario = $roles->firstWhere('id_rolusuarios', $usuario->rol);
                                            @endphp
                                            <p class="form-control-plaintext">
                                                {{ $rolUsuario ? $rolUsuario->rolusuarios : 'Rol no asignado' }}</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <label for="municipio"
                                            class="col-lg-3 col-md-4 label">{{ __('Municipio') }}</label>
                                        <div class="col-lg-9 col-md-8">
                                            @php
                                                $municipioUsuario = $municipios->firstWhere(
                                                    'idmunicipio',
                                                    $usuario->municipio,
                                                );
                                            @endphp
                                            <p class="form-control-plaintext">
                                                {{ $municipioUsuario ? $municipioUsuario->municipio : 'Municipio no asignado' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Dirección</div>
                                        <div class="col-lg-9 col-md-8">{{ $usuario->direccion }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Teléfono</div>
                                        <div class="col-lg-9 col-md-8">{{ $usuario->telefono }}</div>
                                    </div>
                                </div>

                                <div class="tab-pane fade profile-edit" id="profile-edit">
                                    <!-- Profile Edit Form -->
                                    <form id="profileForm" method="POST" action="{{ route('perfil.cambios') }}" novalidate>
                                        <h5 class="card-title">Detalles del perfil</h5>
                                        @csrf
                                        <!-- Campo oculto para el ID -->
                                        <input id="id" type="number" hidden name="id"
                                            value="{{ $usuario->id }}" required>
                                        <!-- Nombres -->
                                        <div class="row mb-3">
                                            <label for="nombres"
                                                class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>
                                            <div class="col-md-6">
                                                <input id="nombres" type="text"
                                                    class="form-control @error('nombres') is-invalid @enderror"
                                                    name="nombres" value="{{ $usuario->nombres }}" required>
                                                @error('nombres')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Apellido Paterno -->
                                        <div class="row mb-3">
                                            <label for="apellidoP"
                                                class="col-md-4 col-form-label text-md-end">{{ __('Apellido Paterno') }}</label>
                                            <div class="col-md-6">
                                                <input id="apellidoP" type="text"
                                                    class="form-control @error('apellidoP') is-invalid @enderror"
                                                    name="apellidoP" value="{{ $usuario->apellidoP }}" required>
                                                @error('apellidoP')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Apellido Materno -->
                                        <div class="row mb-3">
                                            <label for="apellidoM"
                                                class="col-md-4 col-form-label text-md-end">{{ __('Apellido Materno') }}</label>
                                            <div class="col-md-6">
                                                <input id="apellidoM" type="text"
                                                    class="form-control @error('apellidoM') is-invalid @enderror"
                                                    name="apellidoM" value="{{ $usuario->apellidoM }}" required>
                                                @error('apellidoM')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Municipio -->
                                        <div class="row mb-3">
                                            <label for="municipio"
                                                class="col-md-4 col-form-label text-md-end">{{ __('Municipio') }}</label>
                                            <div class="col-md-6">
                                                <select id="municipio"
                                                    class="form-control @error('municipio') is-invalid @enderror"
                                                    name="municipio" required>
                                                    <option value="">Seleccione un municipio</option>
                                                    @foreach ($municipios as $municipio)
                                                        <option value="{{ $municipio->idmunicipio }}"
                                                            {{ $usuario->municipio == $municipio->idmunicipio ? 'selected' : '' }}>
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
                                            <label for="direccion"
                                                class="col-md-4 col-form-label text-md-end">{{ __('Dirección') }}</label>
                                            <div class="col-md-6">
                                                <input id="direccion" type="text"
                                                    class="form-control @error('direccion') is-invalid @enderror"
                                                    name="direccion" value="{{ $usuario->direccion }}" required>
                                                @error('direccion')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Teléfono -->
                                        <div class="row mb-3">
                                            <label for="telefono"
                                                class="col-md-4 col-form-label text-md-end">{{ __('Teléfono') }}</label>
                                            <div class="col-md-6">
                                                <input id="telefono" type="text"
                                                    class="form-control @error('telefono') is-invalid @enderror"
                                                    name="telefono" value="{{ $usuario->telefono }}" required>
                                                @error('telefono')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Botón de Guardar -->
                                        <div class="row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit"
                                                    class="btn btn-success">{{ __('Guardar') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <!-- Change Password Form -->
                                    <form id="passwordForm" action="{{ route('cambiarPassword') }}" novalidate>
                                        @csrf
                                        <div class="row mb-3">
                                            <label for="current-password" class="col-md-4 col-form-label text-md-end">{{ __('Contraseña actual') }}</label>
                                    
                                            <div class="col-md-6">
                                                <input id="current-password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required>
                                    
                                                @error('current_password')
                                                    <script>
                                                        toastr.error('Contraseña actual inválida', '', {
                                                            timeOut: 5000
                                                        });
                                                    </script>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    
                                        <div class="row mb-3">
                                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Nueva contraseña') }}</label>
                                    
                                            <div class="col-md-6">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    
                                                @error('password')
                                                    <script>
                                                        toastr.error('Contraseña inválida', '', {
                                                            timeOut: 5000
                                                        });
                                                    </script>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    
                                        <div class="row mb-3">
                                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmar nueva contraseña') }}</label>
                                    
                                            <div class="col-md-6">
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                            </div>
                                        </div>
                                    
                                        <div class="row mb-0">
                                            <div class="d-flex col-md-6 offset-md-4">
                                                <button type="submit" class="btn btn-success ms-auto">
                                                    {{ __('Cambiar contraseña') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>                 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/perfil.js') }}"></script>
@endsection
