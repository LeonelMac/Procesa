@props(['value', 'state'])

<div>
    <x-acciones.editarTipoBusqueda :value="$value" mensaje="Editar usuario"></x-acciones.editarTipoBusqueda>
    {{-- <x-acciones.eliminarTipoBusqueda :value="$value" mensaje="Eliminar usuario"></x-acciones.eliminarTipoBusqueda> --}}
</div>
<script>
    // inicializa los tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
