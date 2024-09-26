@props(['value', 'state'])

<div>
    <x-acciones.editar :value="$value" mensaje="Editar Usuario"></x-acciones.editar>
    <x-acciones.contrasenia :value="$value" mensaje="Restablecer Contraseña"></x-acciones.contrasenia>
    <x-acciones.eliminar :value="$value" mensaje="Eliminar Usuario"></x-acciones.eliminar>

    <x-modal :value="$value" mensajeBoton="Restablecer" accion="resetPassword({{ $value }})"
        titulo="Confirmar Acción">¿Deseas restablecer la contraseña de este usuario?</x-modal>
    <x-modal :value="$value . 'eliminar'" mensajeBoton="Eliminar" accion="deleteUser({{ $value }})"
        titulo="Confirmar Acción">¿Deseas eliminar este usuario?</x-modal>

</div>
