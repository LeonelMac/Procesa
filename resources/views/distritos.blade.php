@extends('layouts.main')

@section('content')
    <main id="main" class="main">
        <!-- Page Title -->
        <div class="pagetitle">
            <h1>Distritos</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Inicio</a></li>
                    <li class="breadcrumb-item">Configuración</li>
                    <li class="breadcrumb-item active">Distritos</li>
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
                                    <livewire:distrito-component></livewire:distrito-component>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </section>
    </main>
@endsection