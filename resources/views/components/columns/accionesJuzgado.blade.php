@props(['value', 'state'])

<div>
    <x-acciones.editarJuzgado :value="$value" mensaje="Editar Juzgado"></x-acciones.editarJuzgado>
    <x-acciones.eliminarJuzgado :value="$value" mensaje="Eliminar Juzgado"></x-acciones.eliminarJuzgado>
</div>
