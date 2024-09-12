@props(['value', 'state'])

<div>
    <x-acciones.editarDistrito :value="$value" mensaje="Editar usuario"></x-acciones.editarDistrito>
    <x-acciones.eliminarDistrito :value="$value" mensaje="Eliminar usuario"></x-acciones.eliminarDistrito>
</div>
<script>
    // inicializa los tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
