@props(['value'])

<div>
    <button type="button" class="bg-transparent border-0" data-bs-toggle="modal" data-bs-target="#agregarTipoBusquedaModal"
        data-toggle="tooltip" data-bs-placement="top" title="Agregar Tipo Busqueda">
        <div class="icon-container">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 1v6H2a.5.5 0 0 0 0 1h6v6a.5.5 0 0 0 1 0V8h6a.5.5 0 0 0 0-1H9V1a.5.5 0 0 0-1 0z" />
            </svg>
        </div>
    </button>

    <!-- Modal -->
    <div class="modal fade" id="agregarTipoBusquedaModal" tabindex="-1" aria-labelledby="agregarTipoBusquedaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarTipoBusquedaModalLabel">Agregar Tipo Busqueda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('tipoBusquedas.guardar') }}">
                        @csrf
                        <!-- Campo para Tipo de Búsqueda -->
                        <div class="mb-3">
                            <label for="tipobusqueda" class="form-label">Tipo de Búsqueda</label>
                            <input type="text" class="form-control" id="tipobusqueda" name="tipobusqueda" required>
                        </div>

                        <!-- Select para Juzgado -->
                        <div class="mb-3">
                            <label for="juzgado" class="form-label">Seleccionar Juzgado</label>
                            <select class="form-select" id="juzgado" name="juzgado" required>
                                <option value="">Selecciona un juzgado</option>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .icon-container {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #c1cad4;
        color: #fff;
    }

    .icon-container svg {
        margin: 0;
    }
</style>

<script>
    $('#agregarTipoBusquedaModal').on('show.bs.modal', function() {
        $.ajax({
            url: '/tipo/busquedas/obtener',
            type: 'GET',
            success: function(data) {
                let selectJuzgado = $('#juzgado');
                selectJuzgado.empty();
                selectJuzgado.append('<option value="">Selecciona un juzgado</option>');
                data.juzgados.forEach(function(juzgado) {
                    selectJuzgado.append('<option value="' + juzgado.idjuzgados + '">' +
                        juzgado.juzgados + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los juzgados:', error);
            }
        });
    });
</script>
