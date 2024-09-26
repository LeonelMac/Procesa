@props(['value', 'state'])

<div>
    <x-acciones.editarTipoBusqueda :value="$value" mensaje="Editar Tipo Búsqueda"></x-acciones.editarTipoBusqueda>
    <x-acciones.eliminarTipoBusqueda :value="$value" mensaje="Eliminar Tipo Búsqueda"></x-acciones.eliminarTipoBusqueda>
</div>

