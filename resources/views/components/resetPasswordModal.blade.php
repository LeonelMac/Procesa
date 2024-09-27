@props(['value', 'mensajeBoton', 'titulo'])

<!-- Modal para Restablecer Contraseña -->
<div class="modal fade" id="resetPasswordModal{{ $value }}" tabindex="-1" aria-labelledby="resetPasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetPasswordModalLabel">{{ $titulo }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas restablecer la contraseña de este usuario?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmResetPassword{{ $value }}"
                    data-user-id="{{ $value }}">
                    {{ $mensajeBoton }}
                </button>
            </div>
        </div>
    </div>
</div>
