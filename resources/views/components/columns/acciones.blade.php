@props(['value', 'state'])

<div>
    <x-acciones.editarDistrito :value="$value" mensaje="Editar Distrito"></x-acciones.editarDistrito>
    <x-acciones.eliminarDistrito :value="$value" mensaje="Eliminar Distrito"></x-acciones.eliminarDistrito>
</div>
<script>
    // inicializa los tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
