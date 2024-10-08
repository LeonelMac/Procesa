@extends('layouts.main')

@section('title', 'Inicio - Sistema Procesa')

@section('content')
    <!-- Page Title -->
    <div class="pagetitle">
        <h1>Bienvenido</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="#">Inicio</a></li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <!-- Tarjetas superiores: Sin Revisar, Revisados, y Avisos -->
            <div class="col-xxl-4 col-md-4">
                <!-- Sin Revisar Card -->
                <div class="card info-card sales-card">
                    <div class="card-body">
                        <h5 class="card-title">Sin Revisar <span>| Expedientes</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-book"></i>
                            </div>
                            <div class="ps-3">
                                <h6>2</h6>
                                <span class="text-muted small pt-2 ps-1">Expedientes</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Sin Revisar Card -->

            <div class="col-xxl-4 col-md-4">
                <!-- Revisados Card -->
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Revisados <span>| Expedientes</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-book"></i>
                            </div>
                            <div class="ps-3">
                                <h6>4</h6>
                                <span class="text-muted small pt-2 ps-1">Expedientes</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Revisados Card -->

            <div class="col-xxl-4 col-md-4">
                <div class="card info-card customers-card">
                    <div class="card-body">
                        <h5 class="card-title">Avisos <span>| Hoy</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-bell"></i>
                            </div>
                            <div class="ps-3">
                                <h6 id="eventCount">0</h6>
                                <span class="text-muted small pt-2 ps-1">Avisos</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xxl-8 col-xl-8 col-lg-8">
                <div class="card info-card revenue-card shadow-sm rounded">
                    <div id="calendar" style="max-width: 100%; height: auto;"></div>
                </div>
            </div>

            <div class="col-xxl-4 col-xl-4 col-lg-4">
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">Avisos Generales</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar3"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6 id="generalEventCount">0</h6>
                                        <span class="text-muted small pt-2 ps-1">Eventos futuros</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actividad recientes Card (col-12 dentro de col-4 para apilar verticalmente) -->
                    <div class="col-12">
                        <div class="card">
                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filtro</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Hoy</a></li>
                                    <li><a class="dropdown-item" href="#">Este Mes</a></li>
                                    <li><a class="dropdown-item" href="#">Este Año</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Actividad recientes</h5>
                                <div class="activity">
                                    <div class="activity-item d-flex">
                                        <div class="activite-label">32 min</div>
                                        <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                        <div class="activity-content">
                                            Expediente número 12 Liberado
                                        </div>
                                    </div><!-- End activity item-->
                                    <div class="activity-item d-flex">
                                        <div class="activite-label">56 min</div>
                                        <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                                        <div class="activity-content">
                                            Expediente número 2 Cerrado
                                        </div>
                                    </div><!-- End activity item-->
                                    <div class="activity-item d-flex">
                                        <div class="activite-label">2 days</div>
                                        <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                                        <div class="activity-content">
                                            Expediente número 14 En proceso
                                        </div>
                                    </div><!-- End activity item-->
                                    <div class="activity-item d-flex">
                                        <div class="activite-label">4 weeks</div>
                                        <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                                        <div class="activity-content">
                                            Expediente número 4 Cancelado
                                        </div>
                                    </div><!-- End activity item-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- End Columna para las tarjetas -->
        </div>
    </section>

@endsection