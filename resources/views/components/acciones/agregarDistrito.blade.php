@props(['value'])

<div>
    <button type="button" class="bg-transparent border-0" data-bs-toggle="modal" data-bs-target="#agregarDistritoModal"
        data-toggle="tooltip" data-bs-placement="top" title="Agregar Distrito">
        <div class="icon-container">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 1v6H2a.5.5 0 0 0 0 1h6v6a.5.5 0 0 0 1 0V8h6a.5.5 0 0 0 0-1H9V1a.5.5 0 0 0-1 0z" />
            </svg>
        </div>
    </button>

    <!-- Modal -->
    <div class="modal fade" id="agregarDistritoModal" tabindex="-1" aria-labelledby="agregarDistritoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarDistritoModalLabel">Agregar Distrito</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('distritos.guardar') }}">
                        @csrf
                        <!-- Campo para el distrito -->
                        <div class="mb-3">
                            <label for="distrito" class="form-label">Nombre del Distrito</label>
                            <input type="text" class="form-control" id="distrito" name="distrito" required>
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
