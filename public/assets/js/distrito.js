document.addEventListener('DOMContentLoaded', function () {
    function verificarDistritoDuplicado(distrito, callback) {
        $.ajax({
            url: '/distritos/verificar-duplicado',  
            method: 'POST',
            data: {
                distrito: distrito,
                _token: $('meta[name="csrf-token"]').attr('content')  
            },
            success: function (response) {
                callback(response.exists);  
            }
        });
    }
    $('#agregarDistritoModal').on('shown.bs.modal', function () {
        let agregarForm = document.getElementById('formAgregarDistrito');
        if (agregarForm) {
            agregarForm.addEventListener('submit', function (event) {
                let distritoInput = document.getElementById('distrito');
                if (distritoInput.value.trim() === '') {
                    event.preventDefault();
                    toastr.error('El campo "Nombre del Distrito" es obligatorio.');
                    return;
                }
                if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(distritoInput.value.trim())) {
                    event.preventDefault();
                    toastr.error('El nombre del distrito solo debe contener letras y espacios.');
                    return;
                }
                if (distritoInput.value.trim().length < 3 || distritoInput.value.trim().length > 50) {
                    event.preventDefault();
                    toastr.error('El nombre del distrito debe tener entre 3 y 50 caracteres.');
                    return;
                }
                if (!/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ\s]+$/.test(distritoInput.value.trim())) {
                    event.preventDefault();
                    toastr.error('El nombre del distrito debe comenzar con una letra mayúscula.');
                    return;
                }
                if (distritoInput.value.trim() !== distritoInput.value) {
                    event.preventDefault();
                    toastr.error('El nombre del distrito no debe tener espacios al inicio o al final.');
                    return;
                }
                const palabrasProhibidas = ['test', 'falso', 'prueba'];
                if (palabrasProhibidas.some(palabra => distritoInput.value.toLowerCase().includes(palabra))) {
                    event.preventDefault();
                    toastr.error('El nombre del distrito contiene palabras no permitidas.');
                    return;
                }
                event.preventDefault(); 
                verificarDistritoDuplicado(distritoInput.value.trim(), function(existe) {
                    if (existe) {
                        toastr.error('Ya existe un distrito con este nombre.');
                    } else {
                        toastr.success('Distrito agregado exitosamente.');
                        agregarForm.submit();  
                    }
                });
            });
        }
    });
    document.querySelectorAll('form[action*="/distritos/editar"]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            let distritoInput = form.querySelector('input[name="distrito"]');
            if (distritoInput.value.trim() === '') {
                event.preventDefault();
                toastr.error('El campo "Nombre del Distrito" es obligatorio.');
                return;
            }
            if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(distritoInput.value.trim())) {
                event.preventDefault();
                toastr.error('El nombre del distrito solo debe contener letras y espacios.');
                return;
            }
            if (distritoInput.value.trim().length < 3 || distritoInput.value.trim().length > 50) {
                event.preventDefault();
                toastr.error('El nombre del distrito debe tener entre 3 y 50 caracteres.');
                return;
            }
            if (!/^[A-ZÁÉÍÓÚÑ][a-záéíóúñ\s]+$/.test(distritoInput.value.trim())) {
                event.preventDefault();
                toastr.error('El nombre del distrito debe comenzar con una letra mayúscula.');
                return;
            }
            if (distritoInput.value.trim() !== distritoInput.value) {
                event.preventDefault();
                toastr.error('El nombre del distrito no debe tener espacios al inicio o al final.');
                return;
            }
            const palabrasProhibidas = ['test', 'falso', 'prueba'];
            if (palabrasProhibidas.some(palabra => distritoInput.value.toLowerCase().includes(palabra))) {
                event.preventDefault();
                toastr.error('El nombre del distrito contiene palabras no permitidas.');
                return;
            }

            event.preventDefault();  
            verificarDistritoDuplicado(distritoInput.value.trim(), function(existe) {
                if (existe) {
                    toastr.error('Ya existe un distrito con este nombre.');
                } else {
                    toastr.success('Distrito editado exitosamente.');
                    form.submit();  
                }
            });
        });
    });

    document.querySelectorAll('form[action*="/distritos/eliminar"]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();  
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'No podrás revertir esta acción',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();  
                    toastr.success('Distrito eliminado exitosamente.');
                }
            });
        });
    });
});
