<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema Procesa')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- JQuery and Toastr -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://kit.fontawesome.com/5a7f009297.js" crossorigin="anonymous"></script>

    {{-- Fontawesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    @livewireStyles
    @yield('styles')

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
                <img src="{{ asset('assets/img/procesa_blanco.png') }}" alt="">
            </a>
            <i class="bi bi-list toggle-sidebar-btn text-light"></i>
        </div>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0 text-light" href="#"
                        data-bs-toggle="dropdown">
                        <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Perfil" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->nombres }}
                            {{ Auth::user()->apellidoP }}
                            {{ Auth::user()->apellidoM }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ Auth::user()->nombres }} {{ Auth::user()->apellidoP }}
                                {{ Auth::user()->apellidoM }}</h6>
                            <span>
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
                            </span>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item d-flex align-items-center" href="{{ route('perfil.index') }}"><i
                                    class="bi bi-person"></i><span>Mi Perfil</span></a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item d-flex align-items-center" href="#"><i
                                    class="bi bi-gear"></i><span>Configuraciones de la cuenta</span></a></li>
                        <li>
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
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('inicio') }}"><i
                        class="bi bi-house"></i><span>Inicio</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('expedientes.index') }}"><i
                        class="bi bi-book"></i><span>Expedientes</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse"
                    href="#"><i class="bi bi-menu-button-wide"></i><span>Configuración</span><i
                        class="bi bi-books"></i></a>
                <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li><a href="{{ route('usuarios.index') }}"><i class="bi bi-circle"></i><span>Usuarios</span></a>
                    </li>
                    <li><a href="{{ route('distritos.index') }}"><i class="bi bi-circle"></i><span>Distritos</span></a>
                    </li>
                    <li><a href="{{ route('juzgados.index') }}"><i class="bi bi-circle"></i><span>Juzgados</span></a>
                    </li>
                    <li><a href="{{ route('tipoExpedientes.index') }}"><i class="bi bi-circle"></i><span>Tipo Expediente</span></a>
                    </li>
                    <li><a href="{{ route('estatusExpediente.index') }}"><i class="bi bi-circle"></i><span>Estatus Expediente</span></a>
                    </li>
                    <li><a href="{{ route('tipoBusquedas.index') }}"><i class="bi bi-circle"></i><span>Tipo Búsqueda</span></a>
                    </li>
                </ul>
            </li>
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

    <!-- Flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/calendario.js') }}"></script>
    @livewireScripts
    @yield('scripts')

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</body>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</html>
