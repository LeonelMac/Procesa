@props(['value', 'state'])

<div>
    <x-acciones.editarEstatusExpediente :value="$value"
        mensaje="Editar Estatus Expediente"></x-acciones.editarEstatusExpediente>
    <x-acciones.eliminarEstatusExpediente :value="$value"
        mensaje="Eliminar Estatus Expediente"></x-acciones.eliminarEstatusExpediente>
</div>
