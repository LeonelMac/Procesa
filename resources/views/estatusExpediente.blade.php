@extends('layouts.main')

@section('content')
    <main id="main2" class="main2">
        <!-- Page Title -->
        <div class="pagetitle">
            <h1>Estatus Expedientes</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Inicio</a></li>
                    <li class="breadcrumb-item">Configuración</li>
                    <li class="breadcrumb-item active">Estatus Expedientes</li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="offset-end">
                                    <x-acciones.agregarEstatusExpediente mensaje="Agregar Tipo Expediente" />
                                </div>
                                <div class="card-body">
                                    <livewire:estatus-expediente-component></livewire:estatus-expediente-component>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </section>
    </main>

    <style>
        .offset-end {
            position: absolute;
            right: 25px; 
            top: 15px;
        }
    </style>
@endsection