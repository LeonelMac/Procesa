@extends('layouts.app')

@section('content')
    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="card mb-3">

                                <div class="card-body">
                                    <div class="d-flex justify-content-center pt-4">
                                        <img src="{{ asset('assets/img/procesa.png') }}" alt=""
                                            style="width: 100%; height: auto;">
                                    </div>
                                    <!-- End Logo -->
                                    <div class="card-title text-center">
                                        <h5 class="card-title text-center pb-0 fs-4">Inicie sesión</h5>
                                    </div>
                                    <form id="loginForm" class="row g-3 needs-validation" method="POST"
                                        action="{{ route('login') }}" novalidate>
                                        @csrf

                                        <div class="col-12">
                                            <label for="email" class="form-label">Correo Electrónico</label>
                                            <input type="email" id="email" name="email" class="form-control"
                                                required>
                                            <div class="invalid-feedback">¡Por favor, introduzca su correo electrónico!
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="password" class="form-label">Contraseña</label>
                                            <input type="password" id="password" name="password" class="form-control"
                                                required>
                                            <div class="invalid-feedback">¡Por favor, introduzca su contraseña!</div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Acceder</button>
                                        </div>

                                        <div class="col-12">
                                            @if (Route::has('register'))
                                                <p class="small mb-0">¿No tienes cuenta? <a
                                                        href="{{ route('register') }}">Crear una cuenta</a></p>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
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

    <!-- Incluir SweetAlert2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Este es el archivo login.js -->
    <script src="{{ asset('assets/js/login.js') }}"></script>
@endsection
