@extends('layouts.main')

@section('content')
    <main id="main2" class="main2">
        <!-- Page Title -->
        <div class="pagetitle">
            <h1>Tabla de Movimientos</h1>
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
                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <livewire:exp-descripcion-component></livewire:exp-descripcion-component>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </section>
    </main>
@endsection