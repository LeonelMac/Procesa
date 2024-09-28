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

    <!-- Modal Agregar Usuario -->
    <div class="modal fade" id="agregarUsuarioModal" tabindex="-1" aria-labelledby="agregarUsuarioModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarUsuarioModalLabel">Agregar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para agregar un nuevo usuario -->
                    <form id="formAgregarUsuario" method="POST" action="{{ route('usuarios.guardar') }}" novalidate>
                        @csrf
                        <!-- Campo para los nombres -->
                        <div class="mb-3">
                            <label for="nombres" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="nombres" name="nombres" required>
                        </div>
                        <!-- Campo para el apellido paterno -->
                        <div class="mb-3">
                            <label for="apellidoP" class="form-label">Apellido Paterno</label>
                            <input type="text" class="form-control" id="apellidoP" name="apellidoP" required>
                        </div>
                        <!-- Campo para el apellido materno -->
                        <div class="mb-3">
                            <label for="apellidoM" class="form-label">Apellido Materno</label>
                            <input type="text" class="form-control" id="apellidoM" name="apellidoM" required>
                        </div>
                        <!-- Campo para el correo electrónico -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <!-- Campo para el teléfono -->
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <!-- Campo para el Dirección -->
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>
                        <!-- Select para el rol -->
                        <div class="mb-3">
                            <label for="rol" class="form-label">Seleccionar Rol</label>
                            <select class="form-select" id="rol" name="rol" required>
                                <option value="">Selecciona un rol</option>
                                <!-- Opciones de roles -->
                            </select>
                        </div>
                        <!-- Select para el municipio -->
                        <div class="mb-3">
                            <label for="municipio" class="form-label">Seleccionar Municipio</label>
                            <select class="form-select" id="municipio" name="municipio" required>
                                <option value="">Selecciona un municipio</option>
                                <!-- Opciones de municipios -->
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
