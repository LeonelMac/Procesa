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
                            {{-- <h2>{{ $usuario->nombres }}</h2> --}}
                            <h2>{{ Auth::user()->nombres }} {{ Auth::user()->apellidoP }}
                                {{ Auth::user()->apellidoM }}</h2>
                            <h3> <span>
                                    @php
                                        $role = Auth::user()->rol;
                                        $roleName = '';
                                        switch ($role) {
                                            case 1:
                                                $roleName = 'Administrador';
                                                break;
                                            case 2:
                                                $roleName = 'Juzgados';
                                                break;
                                            case 3:
                                                $roleName = 'Abogado';
                                                break;
                                            case 4:
                                                $roleName = 'Usuario';
                                                break;
                                            default:
                                                $roleName = 'Rol desconocido';
                                                break;
                                        }
                                    @endphp
                                    {{ $roleName }}
                                </span></h3>
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

                                {{-- <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab"
                                        data-bs-target="#profile-settings">Ajustes</button>
                                </li> --}}

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
                                        <div class="col-lg-3 col-md-4 label">Rol</div>
                                        <div class="col-lg-9 col-md-8">Administrador</div>
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

                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                    <!-- Profile Edit Form -->
                                    <form method="POST" action="{{ route('cambiosUsuario') }}">
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

                                        <!-- Rol -->
                                        {{-- <div class="row mb-3">
                                            <label for="rol" class="col-md-4 col-form-label text-md-end">{{ __('Rol') }}</label>
                                            <div class="col-md-6">
                                                <select id="rol" class="form-control @error('rol') is-invalid @enderror" name="rol" required>
                                                    <option value="">Seleccione un rol</option>
                                                    @foreach ($roles as $rol)
                                                        <option value="{{ $rol->id_rolusuarios }}"
                                                            {{ $usuario->rol == $rol->id_rolusuarios ? 'selected' : '' }}>
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
                                                <select id="municipio" class="form-control @error('municipio') is-invalid @enderror" name="municipio"
                                                    required>
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
                                        </div> --}}

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
                                                <button type="submit" class="btn btn-success">
                                                    {{ __('Guardar') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade pt-3" id="profile-settings">

                                    <!-- Settings Form -->
                                    <form action="{{ route('perfil.settings') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row mb-3">
                                            <label for="notificationSettings"
                                                class="col-md-4 col-lg-3 col-form-label">Configuración de
                                                Notificaciones</label>
                                            <div class="col-md-8 col-lg-9">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="emailNotifications" name="emailNotifications"
                                                        {{ $usuario->notificaciones_email ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="emailNotifications">
                                                        Correo Electrónico
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="whatsappNotifications" name="whatsappNotifications"
                                                        {{ $usuario->notificaciones_whatsapp ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="whatsappNotifications">
                                                        Whatsapp
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="smsNotifications"
                                                        name="smsNotifications"
                                                        {{ $usuario->notificaciones_sms ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="smsNotifications">
                                                        SMS
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                        </div>
                                    </form><!-- End settings Form -->

                                </div>

                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <!-- Change Password Form -->
                                    <form action="{{ route('perfil.change_password') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row mb-3">
                                            <label for="currentPassword"
                                                class="col-md-4 col-lg-3 col-form-label">Contraseña actual</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="current_password" type="password" class="form-control"
                                                    id="currentPassword">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Nueva
                                                contraseña</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="new_password" type="password" class="form-control"
                                                    id="newPassword">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Vuelva a
                                                ingresar la nueva contraseña</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="new_password_confirmation" type="password"
                                                    class="form-control" id="renewPassword">
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Cambiar la contraseña</button>
                                        </div>
                                    </form><!-- End Change Password Form -->

                                </div>

                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection

@section('scripts')
    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Incluir Flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Incluir SweetAlert2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
