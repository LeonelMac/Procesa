<div>
    <button type="button" class="bg-transparent border-0" data-bs-toggle="modal"
        data-bs-target="#editarTipoExpedienteModal-{{ $value }}" data-toggle="tooltip" data-bs-placement="top"
        title="Editar Distrito" onclick="cargarDatosDistrito({{ $value }})">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
            class="bi bi-pencil-square" viewBox="0 0 16 16">
            <path
                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
            <path fill-rule="evenodd"
                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5.5 1.5 0 0 0 1 2.5v11z" />
        </svg>
    </button>

    <!-- Modal -->
    <div class="modal fade" id="editarTipoExpedienteModal-{{ $value }}" tabindex="-1"
        aria-labelledby="editarTipoExpedienteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarTipoExpedienteModalLabel">Editar Tipo Expediente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('tipoExpedientes.editar', ['idtipoexpediente' => $value]) }}">
                        @csrf
                        <!-- Campo para el tipo expediente -->
                        <div class="mb-3">
                            <label for="tipoexpediente" class="form-label">Nombre del Tipo Expediente</label>
                            <input type="text" class="form-control" id="editar-tipoexpediente-{{ $value }}" name="tipoexpediente" value="" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para cargar datos en el modal -->
<script>
    function cargarDatosDistrito(idtipoexpediente) {
        $.ajax({
            url: '/tipoExpedientes/obtener/' + idtipoexpediente,  
            type: 'GET',
            success: function (data) {
                $('#editar-tipoexpediente-' + idtipoexpediente).val(data.tipoexpediente);
            }
        });
    }
</script>
