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
                <!-- Avisos Card -->
                <div class="card info-card customers-card">
                    <div class="card-body">
                        <h5 class="card-title">Avisos <span>| Hoy</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-bell"></i>
                            </div>
                            <div class="ps-3">
                                <h6>12</h6>
                                <span class="text-muted small pt-2 ps-1">Avisos</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Avisos Card -->
        </div><!-- End Row for Top Cards -->

        <div class="row">
            <!-- Calendario -->
            <div class="col-xxl-8 col-xl-8 col-lg-8">
                <div class="card info-card revenue-card">
                    <div id="calendar" style="max-width: 100%; height: auto;"></div>
                </div>
            </div><!-- End Calendario -->

            <!-- Modal interactivo para agregar/editar/eliminar evento -->
            <div class="modal fade" id="interactiveEventModal" tabindex="-1" role="dialog"
                aria-labelledby="interactiveEventModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h5 class="modal-title" id="interactiveEventModalLabel">
                                <i class="fas fa-calendar-alt"></i> Detalles del Evento
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                style="position: absolute; right: 10px; top: 10px;"></button>
                        </div>
                        <div class="modal-body">
                            <div id="eventInfo" class="d-none">
                                <h6 id="eventTitle" class="font-weight-bold"></h6>
                                <p id="eventDateTime" class="text-muted"></p>
                                <p id="eventDetails" class="text-muted"></p>
                                <div class="text-right">
                                    <button id="editEventBtn" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                    <button id="deleteEventBtn" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </div>
                            </div>
                            <form id="eventForm" class="d-none">
                                <div class="mb-3">
                                    <label for="eventTitleInput" class="form-label">Título del Evento</label>
                                    <input type="text" class="form-control" id="eventTitleInput" name="title"
                                        placeholder="Título...">
                                </div>
                                <input type="hidden" id="eventId">
                                <input type="hidden" id="eventStart">
                                <input type="hidden" id="eventEnd">
                                <div class="mb-3" id="repetitionOptions">
                                    <label for="repetitionSelect" class="form-label">Repetir</label>
                                    <select id="repetitionSelect" class="form-select">
                                        <option value="none" selected>No se repite</option>
                                        <option value="daily">Cada día</option>
                                        <option value="weekdays">Todos los días laborales (lunes a viernes)</option>
                                    </select>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="allDayCheckbox" checked>
                                    <label class="form-check-label" for="allDayCheckbox">Todo el día</label>
                                </div>
                                <div class="mb-3 d-none" id="timeSelectors">
                                    <label for="startTime" class="form-label">Hora de inicio</label>
                                    <input type="time" class="form-control" id="startTime">
                                    <label for="endTime" class="form-label mt-2">Hora de fin</label>
                                    <input type="time" class="form-control" id="endTime">
                                </div>
                                <div class="text-right">
                                    <button type="button" id="saveEventBtn" class="btn btn-success">
                                        <i class="fas fa-save"></i> Guardar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Actividad recientes -->
            <div class="col-xxl-4 col-xl-4 col-lg-4">
                <div class="card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
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
            </div><!-- End Actividad recientes -->
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/calendario.js') }}"></script>
@endsection
