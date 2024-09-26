@props(['value', 'state'])

<div>
    <x-acciones.editarTipoExpediente :value="$value" mensaje="Editar Tipo Expediente"></x-acciones.editarTipoExpediente>
    <x-acciones.eliminarTipoExpediente :value="$value" mensaje="Eliminar Tipo Expediente"></x-acciones.eliminarTipoExpediente>
</div>
