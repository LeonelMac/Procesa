@props(['value'])

<div>
    <button type="button" class="bg-transparent border-0" data-bs-toggle="modal"
        data-bs-target="#editarUsuarioModal-{{ $value }}" data-toggle="tooltip" data-bs-placement="top"
        title="Editar Usuario" onclick="cargarDatosUsuario({{ $value }})">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
            class="bi bi-pencil-square" viewBox="0 0 16 16">
            <path
                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
            <path fill-rule="evenodd"
                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
        </svg>
    </button>

    <!-- Modal Editar Usuario -->
    <div class="modal fade" id="editarUsuarioModal-{{ $value }}" tabindex="-1"
        aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarUsuarioModalLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('usuarios.editar', ['id' => $value]) }}" novalidate>
                        @csrf
                        <input type="hidden" name="id" value="{{ $value }}">
                        <!-- Campo para los nombres -->
                        <div class="mb-3">
                            <label for="nombres" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="editar-nombres-{{ $value }}"
                                name="nombres" required>
                        </div>
                        <!-- Campo para el apellido paterno -->
                        <div class="mb-3">
                            <label for="apellidoP" class="form-label">Apellido Paterno</label>
                            <input type="text" class="form-control" id="editar-apellidoP-{{ $value }}"
                                name="apellidoP" required>
                        </div>
                        <!-- Campo para el apellido materno -->
                        <div class="mb-3">
                            <label for="apellidoM" class="form-label">Apellido Materno</label>
                            <input type="text" class="form-control" id="editar-apellidoM-{{ $value }}"
                                name="apellidoM" required>
                        </div>
                        <!-- Campo para el correo electrónico -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="editar-email-{{ $value }}"
                                name="email" required>
                        </div>
                        <!-- Campo para el teléfono -->
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="editar-telefono-{{ $value }}"
                                name="telefono" required>
                        </div>
                        <!-- Campo para el Dirección -->
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="editar-direccion-{{ $value }}"
                                name="direccion" required>
                        </div>
                        <!-- Select para el rol -->
                        <div class="mb-3">
                            <label for="rol" class="form-label">Seleccionar Rol</label>
                            <select class="form-select" id="editar-rol-{{ $value }}" name="rol" required>
                                <option value="">Selecciona un rol</option>
                                <!-- Opciones de roles -->
                            </select>
                        </div>
                        <!-- Select para el municipio -->
                        <div class="mb-3">
                            <label for="municipio" class="form-label">Seleccionar Municipio</label>
                            <select class="form-select" id="editar-municipio-{{ $value }}" name="municipio"
                                required>
                                <option value="">Selecciona un municipio</option>
                                <!-- Opciones de municipios -->
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
