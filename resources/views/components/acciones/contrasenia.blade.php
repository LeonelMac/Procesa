@props(['value', 'mensaje'])

<div>
    <button id="resetPassword{{ $value }}" class="bg-transparent border-0" data-bs-toggle="modal"
        data-bs-target="#confirmModal{{ $value }}reset" data-bs-toggle="tooltip" data-bs-placement="top"
        title="{{ $mensaje }}">
        <!-- Ícono de restablecer contraseña -->
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 448 512">
            <path
                d="M144 144c0-44.2 35.8-80 80-80c31.9 0 59.4 18.6 72.3 45.7c7.6 16 26.7 22.8 42.6 15.2s22.8-26.7 15.2-42.6C331 33.7 281.5 0 224 0C144.5 0 80 64.5 80 144v48H64c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V256c0-35.3-28.7-64-64-64H144V144z" />
        </svg>
    </button>
</div>

<!-- Modal Confirmación de Restablecimiento de Contraseña -->
<div class="modal fade" id="confirmModal{{ $value }}reset" tabindex="-1"
    aria-labelledby="confirmModalLabel{{ $value }}reset" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel{{ $value }}reset">Confirmar Restablecimiento de
                    Contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas restablecer la contraseña de este usuario?
            </div>
            <div class="modal-footer d-flex justify-content-end">
                <!-- Formulario para restablecer la contraseña -->
                <form method="POST" action="{{ route('usuarios.resetPassword', $value) }}">
                    @csrf
                    <!-- Campo oculto con el ID del usuario -->
                    <input type="hidden" name="id" value="{{ $value }}">
                    <!-- Botón de restablecer contraseña en el modal -->
                    <button type="button" class="btn btn-warning me-2" id="confirmResetPassword{{ $value }}"
                        data-user-id="{{ $value }}">Restablecer Contraseña</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
