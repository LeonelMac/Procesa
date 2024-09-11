@props(['value', 'state'])

<div>
    <x-acciones.descripcion :value="$value" mensaje="Ver PDF"></x-acciones.descripcion>
</div>
<script>
    // inicializa los tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
