// script.js
document.getElementById("myForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Evita el envío del formulario

    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const password = document.getElementById("password").value.trim();

    // Validar que el nombre no esté vacío
    if (name === "") {
        Swal.fire({
            icon: 'error',
            title: 'Nombre requerido',
            text: 'Por favor, ingresa tu nombre completo.',
        });
        return;
    }

    // Validar formato de correo electrónico
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        Swal.fire({
            icon: 'error',
            title: 'Correo inválido',
            text: 'Por favor, ingresa un correo electrónico válido.',
        });
        return;
    }

    // Validar que el teléfono no esté vacío y tenga un formato válido
    const phoneRegex = /^[0-9]{10,15}$/; // Acepta números entre 10 y 15 dígitos
    if (!phoneRegex.test(phone)) {
        Swal.fire({
            icon: 'error',
            title: 'Teléfono inválido',
            text: 'Por favor, ingresa un número de teléfono válido.',
        });
        return;
    }

    // Simulación de actualización exitosa
    Swal.fire({
        icon: 'success',
        title: 'Datos actualizados',
        text: 'Tus datos se han actualizado correctamente.',
    }).then(() => {
        // Aquí podrías realizar otras acciones, como redireccionar
        console.log("Datos actualizados: ", { name, email, phone, password });
        document.getElementById("myForm").reset(); // Reiniciar el formulario
    });
});



// delete-script.js
document.getElementById("deleteForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Evita el envío del formulario

    // Confirmación de eliminación
    Swal.fire({
        title: '¿Estás seguro que deseas eliminar este cliente?',
        text: "Esta acción no se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Simulación de eliminación exitosa
            Swal.fire(
                'Eliminado',
                'El cliente ha sido eliminada.',
                'success'
            ).then(() => {
                // Aquí podrías realizar la eliminación real, redireccionar, etc.
                console.log("Cuenta eliminada: ", { email, password });
                document.getElementById("deleteForm").reset(); // Reiniciar el formulario
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire(
                'Cancelado',
                'Tu cliente está a salvo :)',
                'error'
            );
        }
    });
});
