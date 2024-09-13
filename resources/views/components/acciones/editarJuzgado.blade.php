<div>
    <button type="button" class="bg-transparent border-0" data-bs-toggle="modal"
    data-bs-target="#editarJuzgadoModal-{{ $value }}" data-toggle="tooltip" data-bs-placement="top"
    title="Editar Juzgado" onclick="cargarDatosJuzgado({{ $value }})">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
            class="bi bi-pencil-square" viewBox="0 0 16 16">
            <path
                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
            <path fill-rule="evenodd"
                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5.5 1.5 0 0 0 1 2.5v11z" />
        </svg>
    </button>

    <!-- Modal -->
    <div class="modal fade" id="editarJuzgadoModal-{{ $value }}" tabindex="-1"
        aria-labelledby="editarJuzgadoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarJuzgadoModalLabel">Editar Distrito</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('juzgados.editar', ['idjuzgados' => $value]) }}">
                        @csrf
                        <!-- Campo para el juzgado -->
                        <div class="mb-3">
                            <label for="juzgado" class="form-label">Nombre del Juzgado</label>
                            <input type="text" class="form-control" id="editar-juzgado-{{ $value }}" 
                            name="juzgados" value="" required>                        
                        </div>
                        <!-- Campo para el distrito -->
                        <div class="mb-3">
                            <label for="distrito" class="form-label">Seleccionar Distrito</label>
                            <select class="form-select" id="editar-distrito-{{ $value }}" name="distrito" required>
                                <option value="">Selecciona un distrito</option>
                            </select>
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

<script>
    function cargarDatosJuzgado(idjuzgados) {
        $.ajax({
            url: '/juzgados/obtener/' + idjuzgados,
            type: 'GET',
            success: function(data) {
                $('#editar-juzgado-' + idjuzgados).val(data.juzgado.juzgados);
                let selectDistrito = $('#editar-distrito-' + idjuzgados);
                selectDistrito.empty();
                selectDistrito.append('<option value="">Selecciona un distrito</option>');
                data.distritos.forEach(function(distrito) {
                    selectDistrito.append('<option value="' + distrito.iddistrito + '">' + distrito.distrito + '</option>');
                });
                selectDistrito.val(data.juzgado.distrito.iddistrito);
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los datos del juzgado:', error);
            }
        });
    }
</script>



