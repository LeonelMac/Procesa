{{-- @extends('layouts.main')

@section('content')
    <main id="main2" class="main2">
        <!-- Page Title -->
        <div class="pagetitle">
            <h1>Expedientes</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Expedientes</li>
                </ol>
            </nav>
        </div>
        <section class="section dashboard">
            <div class="row">
                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <livewire:expediente-component></livewire:expediente-component>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </section>
    </main>
@endsection --}}
@extends('layouts.main')

@section('content')
<main>
    <!-- Page Title -->
    <div class="pagetitle">
        <h1>Expedientes</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Inicio</a></li>
                <li class="breadcrumb-item active">Expedientes</li>
            </ol>
        </nav>
    </div>

    <div class="card text-center">
        <div class="card-header">
            <h4>BUSQUEDA DE EXPEDIENTES</h4>
            <p>
                <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#busqueda1" aria-expanded="false" aria-controls="collapseExample">
                    Búsqueda Rápida
                </button>
                <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#busqueda2" aria-expanded="false" aria-controls="collapseExample">
                    Búsqueda Especializada
                </button>
            </p>
        </div>
        <div class="card-body">
            <!-- Acordeón principal que contiene las búsquedas -->
            <div id="accordionBusqueda">
                <div class="collapse my-2" id="busqueda1" data-bs-parent="#accordionBusqueda">
                    <!-- Contenido de Búsqueda Rápida -->
                    <div class="container py-4">
                        <form>
                            <div class="row g-3 align-items-center">
                                <div class="col">
                                    <i class="fas fa-university"></i> Seleccione el Distrito
                                    <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                                        <option selected>Selecciona un distrito</option>
                                        <option value="1">Xalapa</option>
                                        <option value="2">Córdoba</option>
                                        <option value="3">Veracruz</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <i class="fas fa-university"></i> Seleccione el Juzgado
                                    <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                                        <option selected>Selecciona un juzgado</option>
                                        <option value="1">JUZGADO PRIMERO DE PRIMERA INSTANCIA CON RESIDENCIA EN LA CIUDAD JUDICIAL DE NAOLINCO</option>
                                        <option value="2">JUZGADO SEGUNDO DE PRIMERA INSTANCIA</option>
                                        <option value="3">JUZGADO CUARTO DE PRIMERA INSTANCIA</option>
                                        <option value="4">JUZGADO SEXTO DE PRIMERA INSTANCIA ESPECIALIZADO EN MATERIA FAMILIAR</option>
                                        <option value="5">JUZGADO SEXTO DE PRIMERA INSTANCIA ESPECIALIZADO EN MATERIA FAMILIAR</option>
                                        <option value="6">JUZGADO DÉCIMO DE PRIMERA INSTANCIA ESPECIALIZADO EN MATERIA FAMILIAR</option>
                                        <option value="7">JUZGADO DÉCIMO SEGUNDO DE PRIMERA INSTANCIA ESPECIALIZADO EN MATERIA FAMILIAR</option>
                                        <option value="8">JUZGADO DÉCIMO SEXTO DE PRIMERA INSTANCIA</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <i class="fas fa-file-alt"></i> Seleccione el Tipo
                                    <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                                        <option selected>Selecione el tipo</option>
                                        <option value="1">EXPEDIENTE</option>
                                        <option value="2">CUADERNILLO DE REQUISITORIA</option>
                                        <option value="3">TOCA</option>
                                        <option value="1">C.AMPARO</option>
                                        <option value="2">EXHORTO</option>
                                        <option value="3">CUADERNILLO ADMINISTRATIVO</option>
                                        <option value="1">SECRETO</option>
                                        <option value="2">C.AMPARO INDIRECTO</option>
                                        <option value="3">EXCUSA</option>
                                        <option value="1">INCIDENTE</option>
                                        <option value="2">DESPACHO</option>
                                        <option value="3">C.AMPARO DIRECTO</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <i class="fas fa-folder"></i> número/año (125/2022)
                                    <input class="form-control form-control-sm" type="text" placeholder="número/año (125/2022)">
                                </div>
                                <div class="col">
                                    <br>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-sm btn-primary" type="button"><i class="fas fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="collapse my-2" id="busqueda2" data-bs-parent="#accordionBusqueda">
                    <!-- Contenido de Búsqueda Especializada -->
                    <div class="container py-4">
                        <form>
                            <div class="row g-3 align-items-center">
                                <div class="col-md-4">
                                    <label for="distrito" class="form-label">
                                        <i class="fas fa-university"></i> Seleccione el Distrito
                                    </label>
                                    <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                                        <option selected>Selecciona un distrito</option>
                                        <option value="1">Xalapa</option>
                                        <option value="2">Córdoba</option>
                                        <option value="3">Veracruz</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="juzgado" class="form-label">
                                        <i class="fas fa-landmark"></i> Seleccione el Juzgado
                                    </label>
                                    <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                                        <option selected>Selecciona un juzgado</option>
                                        <option value="1">JUZGADO PRIMERO...</option>
                                        <option value="2">JUZGADO SEGUNDO...</option>
                                        <!-- Más opciones -->
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="tipo" class="form-label">
                                        <i class="fas fa-file-alt"></i> Seleccione el Tipo
                                    </label>
                                    <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                                        <option selected>Selecione el tipo</option>
                                        <option value="1">EXPEDIENTE</option>
                                        <option value="2">CUADERNILLO DE REQUISITORIA</option>
                                        <option value="3">TOCA</option>
                                        <option value="1">C.AMPARO</option>
                                        <option value="2">EXHORTO</option>
                                        <option value="3">CUADERNILLO ADMINISTRATIVO</option>
                                        <option value="1">SECRETO</option>
                                        <option value="2">C.AMPARO INDIRECTO</option>
                                        <option value="3">EXCUSA</option>
                                        <option value="1">INCIDENTE</option>
                                        <option value="2">DESPACHO</option>
                                        <option value="3">C.AMPARO DIRECTO</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row g-3 align-items-center mt-3">
                                <div class="col-md-4">
                                    <label for="numero" class="form-label">
                                        <i class="fas fa-folder"></i> número/año (125/2022)
                                    </label>
                                    <input type="text" class="form-control form-control-sm" id="numero" placeholder="Número/año (125/2022)">
                                </div>

                                <div class="col-md-4">
                                    <label for="fecha" class="form-label">
                                        <i class="fas fa-calendar-alt"></i> Fecha (dd/mm/aaaa)
                                    </label>
                                    <input type="text" class="form-control form-control-sm" id="fecha" placeholder="dd/mm/aaaa">
                                </div>

                                <div class="col-md-4">
                                    <label for="nombre" class="form-label">
                                        <i class="fas fa-user"></i> Nombre(s)
                                    </label>
                                    <input type="text" class="form-control form-control-sm" id="nombre" placeholder="Nombre(s)">
                                </div>
                            </div>

                            <div class="row g-3 align-items-center mt-3">
                                <div class="col-md-4">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rol" id="actor" value="actor">
                                        <label class="form-check-label" for="actor">Actor</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rol" id="demandado" value="demandado">
                                        <label class="form-check-label" for="demandado">Demandado</label>
                                    </div>
                                </div>

                                <div class="col-md-8 text-end">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <table class="table">
        <tbody>
            <tr>
                <!-- fila 1 -->
                <th>
                    <div class="d-flex align-items-center py-2">
                        <img src="{{ asset('assets/img/archivocircular.png') }}" class="rounded-circle mx-3" alt="avatar">
                        <div class="me-auto">
                            <!-- AQUI VA TIPO DE BUSQUEDA DE LA BD -->
                            <strong>IDENTIFICADOR DEL EXPEDIENTE </strong> - 1350/2023<br>
                            <!-- AQUI VA EL DISTRITO Y EL JUZGADO DE LA BD -->
                            <span class="text-muted small">XALAPA - JUZGADO DÉCIMO SEGUNDO DE PRIMERA INSTANCIA ESPECIALIZADO EN MATERIA FAMILIAR</span><br>
                            <small class="text-muted">Última revisión: 10/09/2024 a las 22:27 PM</small>
                            <div>
                                <span class="badge bg-success text-dark me-3">Estatus: Revisado</span>
                            </div>
                        </div>
                        <a href="" class="link-dark pe-3">Ver expediente...</a>
                    </div>
                </th>
            </tr>
            <!-- fila 2 -->
            <tr>
                <th>
                    <div class="d-flex align-items-center py-2">
                        <img src="{{ asset('assets/img/archivocircular.png') }}" class="rounded-circle mx-3" alt="avatar">
                        <div class="me-auto">
                            <!-- AQUI VA TIPO DE BUSQUEDA DE LA BD -->
                            <strong>IDENTIFICADOR DEL EXPEDIENTE </strong> - 4563/2023<br>
                            <!-- AQUI VA EL DISTRITO Y EL JUZGADO DE LA BD -->
                            <span class="text-muted small">XALAPA - JUZGADO OCTAVO DE PRIMERA INSTANCIA ESPECIALIZADO EN MATERIA FAMILIAR</span><br>
                            <small class="text-muted">Última revisión: 10/09/2024 a las 22:27 PM</small>
                            <div>
                                <span class="badge bg-warning text-dark me-3">Estatus: Pendiente</span>
                            </div>
                        </div>
                        <a href="" class="link-dark pe-3">Ver expediente...</a>
                    </div>
                </th>
            </tr>
            <!-- fila 3 -->
            <tr>
                <th>
                    <div class="d-flex align-items-center py-2">
                        <img src="{{ asset('assets/img/archivocircular.png') }}" class="rounded-circle mx-3" alt="avatar">
                        <div class="me-auto">
                            <!-- AQUI VA TIPO DE BUSQUEDA DE LA BD -->
                            <strong>IDENTIFICADOR DEL EXPEDIENTE </strong> - 5432/2023<br>
                            <!-- AQUI VA EL DISTRITO Y EL JUZGADO DE LA BD -->
                            <span class="text-muted small">XALAPA - JUZGADO SEGUNDO DE PRIMERA INSTANCIA</span><br>
                            <small class="text-muted">Última revisión: 10/09/2024 a las 22:27 PM</small>
                            <div>
                                <span class="badge bg-danger text-dark me-3">Estatus: Sin Revisar</span>
                            </div>
                        </div>
                        {{-- <a href="{{ route('descripcionExpedientes', ['id_expedientes' => $expediente->id]) }}" class="link-dark pe-3">Ver expediente...</a> --}}
                        <a href="" class="link-dark pe-3">Ver expediente...</a>
                    </div>
                </th>
            </tr>
        </tbody>
    </table>
</main>
@endsection