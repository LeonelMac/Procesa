@props(['value'])

<div>
    <button type="button" class="bg-transparent border-0" data-bs-toggle="modal" data-bs-target="#agregarUsuarioModal"
        data-toggle="tooltip" data-bs-placement="top" title="Agregar Usuario">
        <div class="icon-container">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 1v6H2a.5.5 0 0 0 0 1h6v6a.5.5 0 0 0 1 0V8h6a.5.5 0 0 0 0-1H9V1a.5.5 0 0 0-1 0z" />
            </svg>
        </div>
    </button>
    <!-- Modal -->
    <div class="modal fade" id="agregarUsuarioModal" tabindex="-1" aria-labelledby="agregarUsuarioModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarUsuarioModalLabel">Agregar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @php
                        $roles = App\Models\Rol::all();
                        $municipios = App\Models\Municipio::all();
                    @endphp
                    @include('auth.agregar-modal', ['roles' => $roles, 'municipios' => $municipios])
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
