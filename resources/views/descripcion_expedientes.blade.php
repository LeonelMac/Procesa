{{-- @extends('layouts.main')

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
@endsection --}}
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

    <!-- expediente1 -->
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center"><strong>XALAPA - JUZGADO DÉCIMO SEGUNDO DE PRIMERA INSTANCIA ESPECIALIZADO EN MATERIA FAMILIAR</strong></h5>
                    <span class="text-muted small">Tipo - EXPEDIENTE</span><br>
                    <span class="text-muted small">Número - 1350/2023</span><br>
                    <span class="text-muted small">Prom. - S/P</span><br>
                    <span class="text-muted small">Asunto - ORDINARIO CIVIL</span><br>
                    <span class="text-muted small">Resolución - AUTO</span><br>
                    <span class="text-muted small">Destino - ARCHIVO</span><br>
                    <span class="text-muted small">Fecha - 8 de abril del 2024</span><br>
                </div>
                <div class="card-footer text-muted">
                    <div class="d-grid gap-2">
                        <!-- para que funcione el colapse el data-bs-target="#collapseExample1" debe de tener
                          un identificador unico que debe de ir ligado al  id="collapseExample1" 
                          es decir que debe de tener el mismo identificador -->
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample1" aria-expanded="false" aria-controls="collapseExample">SINTESIS</button>
                        <button type="button" class="btn btn-danger">PDF</button>
                    </div>
                    <div class="collapse" id="collapseExample1">
                        <div class="card card-body mt-2">
                            MESA III.- SE TIENE POR PRESENTADO AL DEMANDADO INTERPONIENDO RECURSO DE REVOCION Y SE DEJA A VISTA POR EL TERMINO DE 3 DÍAS.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- expediente2 -->
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center"><strong>XALAPA - JUZGADO DÉCIMO SEGUNDO DE PRIMERA INSTANCIA ESPECIALIZADO EN MATERIA FAMILIAR</strong></h5>
                    <span class="text-muted small">Tipo - EXPEDIENTE</span><br>
                    <span class="text-muted small">Número - 1350/2023</span><br>
                    <span class="text-muted small">Prom. - 58</span><br>
                    <span class="text-muted small">Asunto - ORDINARIO CIVIL</span><br>
                    <span class="text-muted small">Resolución - AUTO</span><br>
                    <span class="text-muted small">Destino - MESA</span><br>
                    <span class="text-muted small">Fecha - 13 de marzo del 2024</span><br>
                </div>
                <div class="card-footer text-muted">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample">SINTESIS</button>
                        <button type="button" class="btn btn-danger">PDF</button>
                    </div>
                    <div class="collapse" id="collapseExample2">
                        <div class="card card-body mt-2">
                            MESA III.- AUTO ACLARATORIO.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- expediente3 -->
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center"><strong>XALAPA - JUZGADO DÉCIMO SEGUNDO DE PRIMERA INSTANCIA ESPECIALIZADO EN MATERIA FAMILIAR</strong></h5>
                    <span class="text-muted small">Tipo - EXPEDIENTE</span><br>
                    <span class="text-muted small">Número - 1350/2023</span><br>
                    <span class="text-muted small">Prom. - 47</span><br>
                    <span class="text-muted small">Asunto - ORDINARIO CIVIL</span><br>
                    <span class="text-muted small">Resolución - AUTO</span><br>
                    <span class="text-muted small">Destino - MESA</span><br>
                    <span class="text-muted small">Fecha - 28 de febrero del 2024</span><br>
                </div>
                <div class="card-footer text-muted">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample3" aria-expanded="false" aria-controls="collapseExample">SINTESIS</button>
                        <button type="button" class="btn btn-danger">PDF</button>
                    </div>
                    <div class="collapse" id="collapseExample3">
                        <div class="card card-body mt-2">
                            MESA III.- NOTIFICAR PERSONALMENTE.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- expediente4 -->
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center"><strong>XALAPA - JUZGADO DÉCIMO SEGUNDO DE PRIMERA INSTANCIA ESPECIALIZADO EN MATERIA FAMILIAR</strong></h5>
                    <span class="text-muted small">Tipo - EXPEDIENTE</span><br>
                    <span class="text-muted small">Número - 1350/2023</span><br>
                    <span class="text-muted small">Prom. - 1</span><br>
                    <span class="text-muted small">Asunto - ORDINARIO CIVIL</span><br>
                    <span class="text-muted small">Resolución - AUTO</span><br>
                    <span class="text-muted small">Destino - ARCHIVO</span><br>
                    <span class="text-muted small">Fecha - 21 de febrero del 2024</span><br>
                </div>
                <div class="card-footer text-muted">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample4" aria-expanded="false" aria-controls="collapseExample">SINTESIS</button>
                        <button type="button" class="btn btn-danger">PDF</button>
                    </div>
                    <div class="collapse" id="collapseExample4">
                        <div class="card card-body mt-2">
                            MESA III.- SE TIENE POR DESAHOGADO VISTA QUE SE DIERA POR AUTO DE FECHA 8 DEL DICIEMBRE 2023 TENIÉNDOSE POR HECHAS SUS MANIFESTACIONES, LAS CUALES DE CONFORMIDAD POR LO DISPUESTO EN EL NUMERAL 48 FRAC. V, C.P.C. Y SE DEJA A VISTA POR LA PARTE ACORTA POR EL TERMINO DE TRES DÍAS.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- expediente5 -->
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center"><strong>XALAPA - JUZGADO DÉCIMO SEGUNDO DE PRIMERA INSTANCIA ESPECIALIZADO EN MATERIA FAMILIAR</strong></h5>
                    <span class="text-muted small">Tipo - EXPEDIENTE</span><br>
                    <span class="text-muted small">Número - 1350/2023</span><br>
                    <span class="text-muted small">Prom. - 102, 57 Y 59</span><br>
                    <span class="text-muted small">Asunto - ORDINARIO CIVIL</span><br>
                    <span class="text-muted small">Resolución - AUTO</span><br>
                    <span class="text-muted small">Destino - MESA</span><br>
                    <span class="text-muted small">Fecha - 8 de abril del 2024</span><br>
                </div>
                <div class="card-footer text-muted">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample5" aria-expanded="false" aria-controls="collapseExample">SINTESIS</button>
                        <button type="button" class="btn btn-danger">PDF</button>
                    </div>
                    <div class="collapse" id="collapseExample5">
                        <div class="card card-body mt-2">
                            MESA III.- SE RADICA INICIO.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection