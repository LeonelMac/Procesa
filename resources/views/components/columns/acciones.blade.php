@props(['value', 'state'])

<div>
    <x-acciones.editar :value="$value" mensaje="Editar cuenta"></x-acciones.editar>
</div>
<script>
    // inicializa los tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
