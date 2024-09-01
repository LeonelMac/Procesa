// script.js
document.getElementById("myForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Evita el envío del formulario

    const name = document.getElementById("namerol").value.trim();

    // Validar que el nombre no esté vacío
    if (name === "") {
        Swal.fire({
            icon: 'error',
            title: 'Nombre del rol requerido',
            text: 'Por favor, ingresa tu nombre completo.',
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
        console.log("Datos actualizados: ", { name });
        document.getElementById("myForm").reset(); // Reiniciar el formulario
    });
});



// delete-script.js
document.getElementById("deleteForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Evita el envío del formulario

    // Confirmación de eliminación
    Swal.fire({
        title: '¿Estás seguro que deseas eliminar este rol?',
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
                'El rol ha sido eliminada.',
                'success'
            ).then(() => {
                // Aquí podrías realizar la eliminación real, redireccionar, etc.
                console.log("Cuenta eliminada: ", { email, password });
                document.getElementById("deleteForm").reset(); // Reiniciar el formulario
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire(
                'Cancelado',
                'Todo está a salvo :)',
                'error'
            );
        }
    });
});

// delete-script.js
document.getElementById("deleteForm2").addEventListener("submit", function (event) {
    event.preventDefault(); // Evita el envío del formulario

    // Confirmación de eliminación
    Swal.fire({
        title: '¿Estás seguro que deseas eliminar este rol?',
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
                'El rol ha sido eliminada.',
                'success'
            ).then(() => {
                // Aquí podrías realizar la eliminación real, redireccionar, etc.
                console.log("Cuenta eliminada: ", { email, password });
                document.getElementById("deleteForm").reset(); // Reiniciar el formulario
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire(
                'Cancelado',
                'Todo está a salvo :)',
                'error'
            );
        }
    });
});

// delete-script.js
document.getElementById("deleteForm3").addEventListener("submit", function (event) {
    event.preventDefault(); // Evita el envío del formulario

    // Confirmación de eliminación
    Swal.fire({
        title: '¿Estás seguro que deseas eliminar este rol?',
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
                'El rol ha sido eliminada.',
                'success'
            ).then(() => {
                // Aquí podrías realizar la eliminación real, redireccionar, etc.
                console.log("Cuenta eliminada: ", { email, password });
                document.getElementById("deleteForm").reset(); // Reiniciar el formulario
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire(
                'Cancelado',
                'Todo está a salvo :)',
                'error'
            );
        }
    });
});
