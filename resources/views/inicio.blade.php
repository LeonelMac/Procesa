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


            <div class="modal fade" id="interactiveEventModal" tabindex="-1" aria-labelledby="interactiveEventModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="interactiveEventModalLabel">Detalles del Evento</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="eventForm">
                                <div class="mb-3">
                                    <label for="eventTitleInput" class="form-label">Título del Evento</label>
                                    <input type="text" class="form-control" id="eventTitleInput" placeholder="Título...">
                                </div>
                                <input type="hidden" id="eventStart">
                                <div class="mb-3">
                                    <label for="eventDetails" class="form-label">Detalles del Evento</label>
                                    <textarea class="form-control" id="eventDetails" rows="3"></textarea>
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
                                <div class="mb-3">
                                    <label for="repetitionSelect" class="form-label">Repetición</label>
                                    <select class="form-select" id="repetitionSelect">
                                        <option value="none" selected>No repetir</option>
                                        <option value="monthly">Cada mes</option>
                                        <option value="weekdays">De Lunes a Viernes</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" id="saveEventBtn">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="viewEventModal" tabindex="-1" aria-labelledby="viewEventModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewEventModalLabel">Detalles del Evento</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="viewEventForm">
                                <div class="mb-3">
                                    <label for="viewEventTitle" class="form-label">Título del Evento</label>
                                    <input type="text" class="form-control" id="viewEventTitle" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="viewEventDetails" class="form-label">Detalles del Evento</label>
                                    <textarea class="form-control" id="viewEventDetails" rows="3" readonly></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="viewEventTime" class="form-label">Fecha y Hora</label>
                                    <input type="text" class="form-control" id="viewEventTime" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="viewRepetition" class="form-label">Repetición</label>
                                    <input type="text" class="form-control" id="viewRepetition" readonly>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="deleteEventBtn">Eliminar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="editEventBtn">Editar</button>
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
