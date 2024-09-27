@props(['value', 'state'])

<div class="acciones-container">
    <x-acciones.editar :value="$value" mensaje="Editar Usuario"></x-acciones.editar>
    <x-acciones.contrasenia :value="$value" mensaje="Restablecer Contraseña"></x-acciones.contrasenia>
    <x-resetPasswordModal :value="$value" mensajeBoton="Restablecer" titulo="Confirmar Acción" />
    <x-acciones.eliminar :value="$value" mensaje="Eliminar Usuario"></x-acciones.eliminar>
    <x-deleteUserModal :value="$value" mensajeBoton="Eliminar" titulo="Confirmar Acción" />
</div>

<style>
    .acciones-container button {
        display: block;
        margin-bottom: 10px;
    }
</style>
