@props(['value', 'state'])

<div class="acciones-container">
    <x-acciones.editar :value="$value" mensaje="Editar Usuario"></x-acciones.editar>
    <x-acciones.contrasenia :value="$value" mensaje="Restablecer Contraseña"></x-acciones.contrasenia>
    <x-modal :value="$value" mensajeBoton="Restablecer" accion="resetPassword"
        titulo="Confirmar Acción">¿Deseas restablecer la contraseña de este usuario?</x-modal>
    <x-modal :value="$value . 'eliminar'" mensajeBoton="Eliminar" accion="deleteUser"
        titulo="Confirmar Acción">¿Deseas eliminar este usuario?</x-modal>
    <x-acciones.eliminar :value="$value" mensaje="Eliminar Usuario"></x-acciones.eliminar>
</div>

<style>
    .acciones-container button {
        display: block;
        margin-bottom: 10px; 
    }
</style>
