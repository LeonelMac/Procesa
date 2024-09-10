@props(['value', 'state'])

<div>
    <x-acciones.expedientes :value="$value" mensaje="Ver expediente"></x-acciones.expedientes>
</div>
<script>
    // inicializa los tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
