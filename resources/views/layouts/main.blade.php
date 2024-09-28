<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->user()->id }}">
    <meta name="change-password-url" content="{{ route('cambiarPassword') }}">
    <title>@yield('title', 'Sistema Procesa')</title>

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Nunito|Poppins" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <!-- Flatpickr -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    {{-- Flatpickr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @livewireStyles
    @yield('additional-styles')

    <style>
        .highlight {
            background-color: #ffeb3b !important;
            color: #000 !important;
        }
    </style>
</head>

<body>

    <header id="header" class="header fixed-top d-flex align-items-center"
        style="background: url('{{ asset('assets/img/Azul.svg') }}'); background-size: cover; background-position: center;">
        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('inicio') }}" class="logo d-flex align-items-center">
                <img src="{{ asset('assets/img/procesa_blanco.png') }}" alt="Logo de Sistema Procesa">
            </a>
            <i class="bi bi-list toggle-sidebar-btn text-light"></i>
        </div>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0 text-light" href="#"
                        data-bs-toggle="dropdown">
                        <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Imagen de perfil del usuario"
                            class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->nombres }}
                            {{ Auth::user()->apellidoP }}
                            {{ Auth::user()->apellidoM }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ Auth::user()->nombres }} {{ Auth::user()->apellidoP }}
                                {{ Auth::user()->apellidoM }}</h6>
                            <span>
                                {{ Auth::user()->rol == 1 ? 'Administrador' : (Auth::user()->rol == 2 ? 'Juzgados' : (Auth::user()->rol == 3 ? 'Abogado' : 'Usuario')) }}
                            </span>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item d-flex align-items-center"
                                href="{{ route('perfil.index', ['id' => Auth::user()->id]) }}"><i
                                    class="bi bi-person"></i><span>Mi Perfil</span></a></li>

                        <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item d-flex align-items-center" href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="bi bi-box-arrow-right"></i><span>Salir</span></a></li>
            </ul>
            </li>
            </ul>
        </nav>
    </header>

    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">

            <!-- Inicio accesible por todos los roles -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('inicio') }}">
                    <i class="bi bi-house"></i><span>Inicio</span>
                </a>
            </li>

            <!-- Expedientes accesible por todos los roles -->
            @if (in_array(Auth::user()->rol, [1, 2, 3, 4]))
                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('expedientes.index') }}">
                        <i class="bi bi-book"></i><span>Expedientes</span>
                    </a>
                </li>
            @endif

            <!-- Búsquedas accesible solo para Consultores (rol 3) -->
            @if (Auth::user()->rol == 3)
                <li class="nav-item">
                    <a class="nav-link collapsed" href="{{ route('tipoBusquedas.index') }}">
                        <i class="bi bi-search"></i><span>Búsquedas</span>
                    </a>
                </li>
            @endif

            <!-- Configuración accesible solo para Administradores (rol 1) -->
            @if (Auth::user()->rol == 1)
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse"
                        href="#">
                        <i class="bi bi-menu-button-wide"></i><span>Configuración</span><i class="bi bi-books"></i>
                    </a>
                    <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                        <li><a href="{{ route('usuarios.index') }}"><i
                                    class="bi bi-circle"></i><span>Usuarios</span></a></li>
                        <li><a href="{{ route('distritos.index') }}"><i
                                    class="bi bi-circle"></i><span>Distritos</span></a></li>
                        <li><a href="{{ route('juzgados.index') }}"><i
                                    class="bi bi-circle"></i><span>Juzgados</span></a></li>
                        <li><a href="{{ route('tipoExpedientes.index') }}"><i class="bi bi-circle"></i><span>Tipo
                                    Expediente</span></a></li>
                        <li><a href="{{ route('estatusExpediente.index') }}"><i
                                    class="bi bi-circle"></i><span>Estatus Expediente</span></a></li>
                        <li><a href="{{ route('tipoBusquedas.index') }}"><i class="bi bi-circle"></i><span>Tipo
                                    Búsqueda</span></a></li>
                    </ul>
                </li>
            @endif
        </ul>
    </aside>


    <main id="main" class="main">
        @yield('content')
    </main>

    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Sistema Procesa</span></strong>. Todos los derechos reservados
        </div>
    </footer>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/main.js') }}" defer></script>
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    {{-- Flatpickr --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @vite(['resources/js/app.js'])


    @livewireScripts
    @yield('scripts')

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</body>

</html>
