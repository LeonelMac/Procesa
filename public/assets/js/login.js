document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("loginForm")
    .addEventListener("submit", function (event) {
      const email = document.getElementById("email").value.trim();
      const password = document.getElementById("password").value.trim();
      if (email === "" || password === "") {
        event.preventDefault();
        Swal.fire({
          icon: "error",
          title: "Campos vacíos",
          text: "Por favor, complete todos los campos.",
        });
        return;
      }
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        event.preventDefault();
        Swal.fire({
          icon: "error",
          title: "Correo inválido",
          text: "Por favor, ingrese un correo electrónico válido.",
        });
        return;
      }
      if (email.length < 5 || email.length > 100) {
        event.preventDefault();
        Swal.fire({
          icon: "error",
          title: "Correo inválido",
          text: "El correo electrónico debe tener entre 5 y 100 caracteres.",
        });
        return;
      }
      const specialCharEmailRegex = /[^a-zA-Z0-9@.]/;
      if (specialCharEmailRegex.test(email)) {
        event.preventDefault();
        Swal.fire({
          icon: "error",
          title: "Correo con caracteres no permitidos",
          text: "El correo no debe contener caracteres especiales no permitidos.",
        });
        return;
      }
      if (password.length < 8) {
        event.preventDefault();
        Swal.fire({
          icon: "error",
          title: "Contraseña demasiado corta",
          text: "La contraseña debe tener al menos 8 caracteres.",
        });
        return;
      }
      if (/\s/.test(password)) {
        event.preventDefault();
        Swal.fire({
          icon: "error",
          title: "Contraseña inválida",
          text: "La contraseña no debe contener espacios.",
        });
        return;
      }
      const commonPasswords = [
        "123456",
        "password",
        "123456789",
        "12345678",
        "qwerty",
        "abc123",
      ];
      if (commonPasswords.includes(password)) {
        event.preventDefault();
        Swal.fire({
          icon: "error",
          title: "Contraseña débil",
          text: "Por favor, elija una contraseña más segura.",
        });
        return;
      }
      if (!/[A-Z]/.test(password)) {
        event.preventDefault();
        Swal.fire({
          icon: "error",
          title: "Contraseña débil",
          text: "La contraseña debe contener al menos una letra mayúscula.",
        });
        return;
      }
      if (!/[a-z]/.test(password)) {
        event.preventDefault();
        Swal.fire({
          icon: "error",
          title: "Contraseña débil",
          text: "La contraseña debe contener al menos una letra minúscula.",
        });
        return;
      }
      if (!/[0-9]/.test(password)) {
        event.preventDefault();
        Swal.fire({
          icon: "error",
          title: "Contraseña débil",
          text: "La contraseña debe contener al menos un número.",
        });
        return;
      }
      const specialCharRegex = /[!@#$%^&*(),.?":{}|<>]/;
      if (!specialCharRegex.test(password)) {
        event.preventDefault();
        Swal.fire({
          icon: "error",
          title: "Contraseña débil",
          text: "La contraseña debe contener al menos un carácter especial (por ejemplo: !@#$%^&*).",
        });
        return;
      }
    });
});
