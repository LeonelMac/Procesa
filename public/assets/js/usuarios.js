document.addEventListener("DOMContentLoaded", function () {
    const formAgregar = document.getElementById('agregarUsuarioModal');
    if (formAgregar) {
        formAgregar.addEventListener('submit', function (e) {
            e.preventDefault();
            const form = this;
            const nombres = form.querySelector('#nombres');
            const apellidoP = form.querySelector('#apellidoP');
            const apellidoM = form.querySelector('#apellidoM');
            const email = form.querySelector('#email');
            const rol = form.querySelector('#rol');
            const municipio = form.querySelector('#municipio');
            const direccion = form.querySelector('#direccion');
            const telefono = form.querySelector('#telefono');
            if (!validarCampo(nombres, 'Por favor, ingresa un nombre válido.')) return;
            if (!validarCampo(apellidoP, 'Por favor, ingresa el apellido paterno.')) return;
            if (!validarCampo(apellidoM, 'Por favor, ingresa el apellido materno.')) return;
            if (!validarEmail(email)) return;
            if (!validarCampo(rol, 'Por favor, selecciona un rol.')) return;
            if (!validarCampo(municipio, 'Por favor, selecciona un municipio.')) return;
            if (!validarCampo(direccion, 'Por favor, ingresa una dirección.')) return;
            if (!validarTelefono(telefono)) return;
            e.target.submit(); 
        });
    }

    function validarCampo(campo, mensajeError) {
        if (!campo) {  
            console.error('El campo no existe en el formulario.');
            return false;
        }
        const valor = campo.value.trim(); 
        if (valor === "") {  
            toastr.error(mensajeError);
            campo.focus();
            return false;
        }
        return true;
    }

    function validarEmail(campo) {
        if (!campo) {
            toastr.error('El campo de correo electrónico no existe.');
            return false;
        }
        const email = campo.value.trim();
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!regex.test(email)) {
            toastr.error('Por favor, ingresa un correo electrónico válido.');
            campo.focus();
            return false;
        }
        return true;
    }

    function validarTelefono(campo) {
        if (!campo) {
            toastr.error('El campo de teléfono no existe.');
            return false;
        }
        const telefono = campo.value.trim();
        if (telefono.length !== 10 || isNaN(telefono)) {
            toastr.error('El teléfono debe tener 10 dígitos numéricos.');
            campo.focus();
            return false;
        }
        return true;
    }

    document.querySelectorAll('[id^=deleteUser]').forEach(function (button) {
        button.addEventListener('click', function () {
            let userId = button.getAttribute('data-user-id'); 
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esta acción",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/usuarios/eliminar/${userId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json()) 
                    .then(data => {
                        if (data.success) {
                           
                            Swal.fire('Eliminado', data.message, 'success')
                            .then(() => window.location.reload());
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => Swal.fire('Error', 'Ocurrió un error inesperado.', 'error'));
                }
            });
        });
    });

    document.querySelectorAll('[id^=resetPassword]').forEach(function (button) {
        button.addEventListener('click', function () {
            let userId = button.getAttribute('data-user-id');
            Swal.fire({
                title: '¿Estás seguro?',
                text: "La contraseña será restablecida",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, restablecer',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/usuarios/resetPassword/${userId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error en la solicitud');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Restablecido', data.message, 'success')
                            .then(() => window.location.reload()); 
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => Swal.fire('Error', 'Ocurrió un error inesperado.', 'error'));
                }
            });
        });
    });
});
