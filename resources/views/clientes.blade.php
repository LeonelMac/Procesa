@extends('layouts.main')

@section('content')
    <main id="main" class="main">
        <!-- Page Title -->
        <div class="pagetitle">
            <h1>CLIENTES</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Clientes</li>
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
                                    <h5 class="card-title">Clientes</h5>

                                    <!-- Table with stripped rows -->
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th>Nombre Completo</th>
                                                <th>Correo Electrónico</th>
                                                <th>Teléfono</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Aquí es donde debes hacer un bucle sobre los clientes desde el controlador -->
                                            @foreach ($clientes as $cliente)
                                                <tr>
                                                    <td>{{ $cliente->nombre_completo }}</td>
                                                    <td>{{ $cliente->email }}</td>
                                                    <td>{{ $cliente->telefono }}</td>
                                                    <td>
                                                        <div class="btn-group" role="group" aria-label="Basic example">
                                                            <button type="button" class="btn btn-sm btn-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editar-{{ $cliente->id }}">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </button>

                                                            <!-- Modal de edición -->
                                                            <div class="modal fade" id="editar-{{ $cliente->id }}"
                                                                tabindex="-1">
                                                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Editar Cliente</h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <form
                                                                            action="{{ route('clientes.update', $cliente->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <div class="modal-body">
                                                                                <!-- General Form Elements -->
                                                                                <div class="row mb-3">
                                                                                    <label for="nombre"
                                                                                        class="col-sm-2 col-form-label">Nombre</label>
                                                                                    <div class="col-sm-10">
                                                                                        <input type="text" id="nombre"
                                                                                            name="nombre"
                                                                                            class="form-control"
                                                                                            value="{{ $cliente->nombre_completo }}">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label for="email"
                                                                                        class="col-sm-2 col-form-label">Correo
                                                                                        Electrónico</label>
                                                                                    <div class="col-sm-10">
                                                                                        <input type="email" id="email"
                                                                                            name="email"
                                                                                            class="form-control"
                                                                                            value="{{ $cliente->email }}">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label for="telefono"
                                                                                        class="col-sm-2 col-form-label">Teléfono</label>
                                                                                    <div class="col-sm-10">
                                                                                        <input type="tel" id="telefono"
                                                                                            name="telefono"
                                                                                            class="form-control"
                                                                                            value="{{ $cliente->telefono }}">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label for="password"
                                                                                        class="col-sm-2 col-form-label">Password</label>
                                                                                    <div class="col-sm-10">
                                                                                        <input type="password"
                                                                                            id="password" name="password"
                                                                                            class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <!-- End General Form Elements -->
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">Cerrar</button>
                                                                                <button class="btn btn-primary"
                                                                                    type="submit">Guardar</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Formulario de eliminación -->
                                                            <form action="{{ route('clientes.destroy', $cliente->id) }}"
                                                                method="POST" id="deleteForm-{{ $cliente->id }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm btn-danger" type="submit"><i
                                                                        class="bi bi-trash"></i></button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- End Table with stripped rows -->

                                </div>
                            </div>

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

    <!-- Incluir Flatpickr JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Incluir SweetAlert2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/clientes.js') }}"></script>
@endsection
