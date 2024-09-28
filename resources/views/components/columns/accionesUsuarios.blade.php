@props(['value', 'state'])

<div class="acciones-container">
    <x-acciones.editar :value="$value" mensaje="Editar Usuario"></x-acciones.editar>
    <x-acciones.contrasenia :value="$value" mensaje="Restablecer Contraseña"></x-acciones.contrasenia>
    <x-acciones.eliminar :value="$value" mensaje="Eliminar Usuario"></x-acciones.eliminar>
</div>

<style>
    .acciones-container button {
        display: block;
        margin-bottom: 10px;
    }
</style>
