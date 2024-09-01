@extends('layouts.main')

@section('content')
    <main id="main" class="main">
        <!-- Page Title -->
        <div class="pagetitle">
            <h1>TABLA DE MOVIMIENTOS</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('expedientes.index') }}">Expedientes</a></li>
                    <li class="breadcrumb-item active">Tabla de Movimientos</li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th scope="col">Tipo</th>
                            <th scope="col">Número</th>
                            <th scope="col">Prom.</th>
                            <th scope="col">Asunto</th>
                            <th scope="col">Resolución</th>
                            <th scope="col">Destino</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Síntesis</th>
                            <th scope="col">Archivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Expediente</th>
                            <td>{{ $expediente->numero }}</td>
                            <td>{{ $expediente->prom }}</td>
                            <td>{{ $expediente->asunto }}</td>
                            <td>{{ $expediente->resolucion }}</td>
                            <td>{{ $expediente->destino }}</td>
                            <td>{{ $expediente->fecha }}</td>
                            <td>{{ $expediente->sintesis }}</td>
                            <td>
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
