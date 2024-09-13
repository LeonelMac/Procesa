@props(['value', 'state'])

<div>
    <x-acciones.editarJuzgado :value="$value" mensaje="Editar usuario"></x-acciones.editarJuzgado>
    <x-acciones.eliminarJuzgado :value="$value" mensaje="Eliminar usuario"></x-acciones.eliminarJuzgado>
</div>
<script>
    // inicializa los tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
