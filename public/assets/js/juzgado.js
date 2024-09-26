$('#formAgregarJuzgado').on('submit', function(e) {
    e.preventDefault();

    var juzgado = $('#juzgado').val();
    var distrito = $('#distrito').val();

    if (juzgado === '') {
        toastr.error('El campo "Nombre del Juzgado" es obligatorio.');
        return;
    }

    if (distrito === '') {
        toastr.error('El campo "Seleccionar Distrito" es obligatorio.');
        return;
    }

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            toastr.success('Juzgado agregado correctamente.');
            $('#agregarJuzgadoModal').modal('hide');
            location.reload(); 
        },
        error: function(xhr, status, error) {
            toastr.error('Ocurrió un error al agregar el juzgado.');
        }
    });
});

$('form[action*="juzgados/editar"]').on('submit', function(e) {
    e.preventDefault();

    var juzgadoId = $(this).attr('action').split('/').pop();
    var juzgado = $('#editar-juzgado-' + juzgadoId).val();
    var distrito = $('#editar-distrito-' + juzgadoId).val();

    if (juzgado === '') {
        toastr.error('El campo "Nombre del Juzgado" es obligatorio.');
        return;
    }

    if (distrito === '') {
        toastr.error('El campo "Seleccionar Distrito" es obligatorio.');
        return;
    }

    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            toastr.success('Juzgado editado correctamente.');
            $('#editarJuzgadoModal-' + juzgadoId).modal('hide');
            location.reload(); 
        },
        error: function(xhr, status, error) {
            toastr.error('Ocurrió un error al editar el juzgado.');
        }
    });
});

$('form[action*="juzgados/eliminar"]').on('submit', function(e) {
    e.preventDefault();
    var form = this;

    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esta acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                data: $(form).serialize(),
                success: function(response) {
                    toastr.success('Juzgado eliminado correctamente.');
                    location.reload(); 
                },
                error: function(xhr, status, error) {
                    toastr.error('Ocurrió un error al eliminar el juzgado.');
                }
            });
        }
    });
});

$('#agregarJuzgadoModal').on('show.bs.modal', function() {
    $.ajax({
        url: '/juzgados/obtener',
        type: 'GET',
        success: function(data) {
            let selectDistrito = $('#distrito');
            selectDistrito.empty();
            selectDistrito.append('<option value="">Selecciona un distrito</option>');
            data.forEach(function(distrito) {
                selectDistrito.append('<option value="' + distrito.iddistrito + '">' + distrito.distrito + '</option>');
            });
        },
        error: function(xhr, status, error) {
            toastr.error('Error al obtener los distritos.');
        }
    });
});

function cargarDatosJuzgado(idjuzgados) {
    $.ajax({
        url: '/juzgados/obtener/' + idjuzgados,
        type: 'GET',
        success: function(data) {
            $('#editar-juzgado-' + idjuzgados).val(data.juzgado.juzgados);
            let selectDistrito = $('#editar-distrito-' + idjuzgados);
            selectDistrito.empty();
            selectDistrito.append('<option value="">Selecciona un distrito</option>');
            data.distritos.forEach(function(distrito) {
                selectDistrito.append('<option value="' + distrito.iddistrito + '">' + distrito.distrito + '</option>');
            });
            selectDistrito.val(data.juzgado.distrito.iddistrito);
        },
        error: function(xhr, status, error) {
            toastr.error('Error al obtener los datos del juzgado.');
        }
    });
}
