// script.js
document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Evita el envío del formulario

    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();

    // Validar que los campos no estén vacíos
    if (email === "" || password === "") {
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
        Swal.fire({
            icon: 'error',
            title: 'Correo inválido',
            text: 'Por favor, ingrese un correo electrónico válido.',
        });
        return;
    }

    // Simular una autenticación exitosa
    if (email === "admin@procesa.com" && password === "1234") {
        Swal.fire({
            icon: 'success',
            title: '¡BIENVENIDO AL SISTEMA PROCESA!',
        }).then(() => {
            // Redireccionar a otra página después de la autenticación
            window.location.href = "../pantallas/inicio.html";
        });
    } else if(email === "user@procesa.com" && password === "1234") {
        Swal.fire({
            icon: 'success',
            title: '¡BIENVENIDO AL SISTEMA PROCESA!',
        }).then(() => {
            // Redireccionar a otra página después de la autenticación
            window.location.href = "../pantallas/inicio_user.html";
        });
    }else{
        Swal.fire({
            icon: 'error',
            title: 'Error de autenticación',
            text: 'Correo electrónico o contraseña incorrectos.',
        });
    }
});
