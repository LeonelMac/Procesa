document.addEventListener('DOMContentLoaded', function() {
    document.getElementById("loginForm").addEventListener("submit", function(event) {
        // Obtener los valores de los campos de entrada
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value.trim();

        // Validar que los campos no estén vacíos
        if (email === "" || password === "") {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Campos vacíos',
                text: 'Por favor, complete todos los campos.',
            });
            return;
        }

        // Validar formato de correo electrónico
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Correo inválido',
                text: 'Por favor, ingrese un correo electrónico válido.',
            });
            return;
        }

        // Validar que el correo tenga al menos 5 caracteres y no más de 100 caracteres
        if (email.length < 5 || email.length > 100) {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Correo inválido',
                text: 'El correo electrónico debe tener entre 5 y 100 caracteres.',
            });
            return;
        }

        // Validar que el correo no contenga caracteres especiales inválidos
        const specialCharEmailRegex = /[^a-zA-Z0-9@.]/;
        if (specialCharEmailRegex.test(email)) {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Correo con caracteres no permitidos',
                text: 'El correo no debe contener caracteres especiales no permitidos.',
            });
            return;
        }

        // // Validar que la contraseña tenga al menos 8 caracteres (puedes cambiar este valor según necesidad)
        // if (password.length < 8) {
        //     event.preventDefault();
        //     Swal.fire({
        //         icon: 'error',
        //         title: 'Contraseña demasiado corta',
        //         text: 'La contraseña debe tener al menos 8 caracteres.',
        //     });
        //     return;
        // }

        // // Validar que la contraseña no contenga espacios
        // if (/\s/.test(password)) {
        //     event.preventDefault();
        //     Swal.fire({
        //         icon: 'error',
        //         title: 'Contraseña inválida',
        //         text: 'La contraseña no debe contener espacios.',
        //     });
        //     return;
        // }

        // // Validar que la contraseña no sea una de las contraseñas más comunes
        // const commonPasswords = ["123456", "password", "123456789", "12345678", "qwerty", "abc123"];
        // if (commonPasswords.includes(password)) {
        //     event.preventDefault();
        //     Swal.fire({
        //         icon: 'error',
        //         title: 'Contraseña débil',
        //         text: 'Por favor, elija una contraseña más segura.',
        //     });
        //     return;
        // }

        // // Validar que la contraseña tenga al menos una letra mayúscula
        // if (!/[A-Z]/.test(password)) {
        //     event.preventDefault();
        //     Swal.fire({
        //         icon: 'error',
        //         title: 'Contraseña débil',
        //         text: 'La contraseña debe contener al menos una letra mayúscula.',
        //     });
        //     return;
        // }

        // // Validar que la contraseña tenga al menos una letra minúscula
        // if (!/[a-z]/.test(password)) {
        //     event.preventDefault();
        //     Swal.fire({
        //         icon: 'error',
        //         title: 'Contraseña débil',
        //         text: 'La contraseña debe contener al menos una letra minúscula.',
        //     });
        //     return;
        // }

        // // Validar que la contraseña tenga al menos un número
        // if (!/[0-9]/.test(password)) {
        //     event.preventDefault();
        //     Swal.fire({
        //         icon: 'error',
        //         title: 'Contraseña débil',
        //         text: 'La contraseña debe contener al menos un número.',
        //     });
        //     return;
        // }

        // Validar que la contraseña tenga al menos un carácter especial
        // const specialCharRegex = /[!@#$%^&*(),.?":{}|<>]/;
        // if (!specialCharRegex.test(password)) {
        //     event.preventDefault();
        //     Swal.fire({
        //         icon: 'error',
        //         title: 'Contraseña débil',
        //         text: 'La contraseña debe contener al menos un carácter especial (por ejemplo: !@#$%^&*).',
        //     });
        //     return;
        // }

    });
});
