@extends('layouts.main')

@section('content')
    <main id="main" class="main">
        <!-- Page Title -->
        <div class="pagetitle">
            <h1>TABLA DE MOVIMIENTOS</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('expedientes_user.index') }}">Expedientes</a></li>
                    <li class="breadcrumb-item active">Tabla de Movimientos</li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <div class="col-md-4 d-flex justify-content-center align-items-center">
                                        <img src="{{ asset('assets/img/archivo2.png') }}" class="img-fluid rounded-start"
                                            alt="..." />
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">Tipo: Expediente</h5>
                                            <p class="card-text m-0">Número: {{ $expediente->numero }}</p>
                                            <p class="card-text m-0">Prom. {{ $expediente->prom }}</p>
                                            <p class="card-text m-0">Asunto: {{ $expediente->asunto }}</p>
                                            <p class="card-text m-0">Resolución: {{ $expediente->resolucion }}</p>
                                            <p class="card-text m-0">Destino: {{ $expediente->destino }}</p>
                                            <p class="card-text m-0">Fecha: {{ $expediente->fecha }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p class="card-text m-2">
                                        <small class="text-muted">Síntesis: {{ $expediente->sintesis }}</small>
                                    </p>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-sm btn-danger">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Repetir estructura para otros expedientes -->
                        </div>
                    </div>
                </section>
            </div>
        </section>
    </main>
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
@endsection
