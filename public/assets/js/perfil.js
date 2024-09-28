document.addEventListener("DOMContentLoaded", function () {
    // 1. Formulario de perfil
    const profileForm = document.getElementById("profileForm");

    profileForm.addEventListener("submit", function (e) {
        e.preventDefault(); // Evitar el envío tradicional del formulario

        // Obtener los valores de los campos
        const nombres = document.getElementById("nombres").value.trim();
        const apellidoP = document.getElementById("apellidoP").value.trim();
        const apellidoM = document.getElementById("apellidoM").value.trim();
        const direccion = document.getElementById("direccion").value.trim();
        const telefono = document.getElementById("telefono").value.trim();
        const municipio = document.getElementById("municipio").value;

        // Validar que todos los campos requeridos no estén vacíos
        if (nombres === "") {
            toastr.error("El nombre no puede estar vacío.");
            return;
        }

        if (apellidoP === "") {
            toastr.error("El apellido paterno no puede estar vacío.");
            return;
        }

        if (apellidoM === "") {
            toastr.error("El apellido materno no puede estar vacío.");
            return;
        }

        if (direccion === "") {
            toastr.error("La dirección no puede estar vacía.");
            return;
        }

        if (telefono === "") {
            toastr.error("El teléfono no puede estar vacío.");
            return;
        }

        if (municipio === "") {
            toastr.error("Debe seleccionar un municipio.");
            return;
        }

        // Validar formato de teléfono (sólo números y longitud mínima de 10)
        const phoneRegex = /^[0-9]{10}$/;
        if (!phoneRegex.test(telefono)) {
            toastr.error("El teléfono debe contener 10 dígitos numéricos.");
            return;
        }

        // Crear objeto FormData para enviar la solicitud
        let formData = new FormData(profileForm);

        // Enviar la solicitud AJAX para editar perfil
        fetch(profileForm.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar mensaje de éxito con Toastr
                toastr.success(data.message, '', { timeOut: 5000 });

                // Refrescar la página después de la actualización
                setTimeout(() => {
                    location.reload();
                }, 1000); // Esperar 1 segundo antes de refrescar
            } else {
                // Mostrar mensaje de error con Toastr
                toastr.error(data.message, '', { timeOut: 5000 });
            }
        })
        .catch(error => {
            toastr.error("Ocurrió un error inesperado. Por favor, inténtalo de nuevo.", '', { timeOut: 5000 });
        });
    });

    // 2. Formulario de cambiar contraseña
    const passwordForm = document.getElementById("passwordForm");

    passwordForm.addEventListener("submit", function (e) {
        e.preventDefault(); // Evitar el envío tradicional

        // Obtener los valores de los campos
        const currentPassword = document.getElementById("current-password").value.trim();
        const newPassword = document.getElementById("password").value.trim();
        const confirmPassword = document.getElementById("password-confirm").value.trim();

        // Validaciones Frontend
        if (currentPassword === "") {
            toastr.error("La contraseña actual es obligatoria.");
            return;
        }

        if (newPassword === "") {
            toastr.error("La nueva contraseña es obligatoria.");
            return;
        }

        if (confirmPassword === "") {
            toastr.error("La confirmación de la contraseña es obligatoria.");
            return;
        }

        // Validar que la nueva contraseña tenga al menos 8 caracteres
        if (newPassword.length < 8) {
            toastr.error("La nueva contraseña debe tener al menos 8 caracteres.");
            return;
        }

        // Validar que la nueva contraseña no contenga espacios
        if (/\s/.test(newPassword)) {
            toastr.error("La nueva contraseña no debe contener espacios.");
            return;
        }

        // Validar que la nueva contraseña no sea una de las más comunes
        const commonPasswords = [
            "123456",
            "password",
            "123456789",
            "12345678",
            "qwerty",
            "abc123",
        ];
        if (commonPasswords.includes(newPassword)) {
            toastr.error("Por favor, elija una nueva contraseña más segura.");
            return;
        }

        // Validar que la nueva contraseña tenga al menos una letra mayúscula
        if (!/[A-Z]/.test(newPassword)) {
            toastr.error("La nueva contraseña debe contener al menos una letra mayúscula.");
            return;
        }

        // Validar que la nueva contraseña tenga al menos una letra minúscula
        if (!/[a-z]/.test(newPassword)) {
            toastr.error("La nueva contraseña debe contener al menos una letra minúscula.");
            return;
        }

        // Validar que la nueva contraseña tenga al menos un número
        if (!/[0-9]/.test(newPassword)) {
            toastr.error("La nueva contraseña debe contener al menos un número.");
            return;
        }

        // Validar que la nueva contraseña tenga al menos un carácter especial
        const specialCharRegex = /[!@#$%^&*(),.?":{}|<>]/;
        if (!specialCharRegex.test(newPassword)) {
            toastr.error("La nueva contraseña debe contener al menos un carácter especial (por ejemplo: !@#$%^&*).");
            return;
        }

        // Validar que la confirmación de la contraseña coincida con la nueva contraseña
        if (newPassword !== confirmPassword) {
            toastr.error("La confirmación de la nueva contraseña no coincide.");
            return;
        }

        // Crear objeto FormData para enviar la solicitud AJAX
        let formData = new FormData(passwordForm);

        // Enviar la solicitud AJAX
        fetch(passwordForm.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar mensaje de éxito con Toastr
                toastr.success(data.message, '', { timeOut: 5000 });

                // Limpiar los campos del formulario
                passwordForm.reset();
            } else {
                // Mostrar mensaje de error con Toastr
                toastr.error(data.message, '', { timeOut: 5000 });
            }
        })
        .catch(error => {
            toastr.error("Ocurrió un error inesperado. Por favor, inténtalo de nuevo.", '', { timeOut: 5000 });
        });
    });
});
