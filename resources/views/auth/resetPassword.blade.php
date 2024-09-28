@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border mt-5 border-0">
                    <div class="card-body bg-white p-5">
                        <div class="d-flex flex-row mb-3">
                            <h2 class="mx-4">Cambiar contraseña</h2>
                        </div>
                        <form id="changePasswordForm" method="POST" action="{{ route('cambiarPassword') }}" novalidate>
                            @csrf
                            <div class="row mb-3">
                                <label for="current-password" class="col-md-4 col-form-label text-md-end">Contraseña
                                    Actual</label>

                                <div class="col-md-6">
                                    <input id="current-password" type="password" class="form-control"
                                        name="current_password" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Nueva Contraseña</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required
                                        autocomplete="new-password">
                                    <small id="passwordHelpBlock" class="form-text text-muted">
                                    </small>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirmar nueva
                                    contraseña</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="d-flex col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-success ms-auto">
                                        Cambiar Contraseña
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/resetPassword.js') }}"></script>
@endsection
