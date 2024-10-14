document.addEventListener("DOMContentLoaded", function () {
  const emailInput = document.getElementById("email");
  const passwordInput = document.getElementById("password");
  const submitButton = document.querySelector('button[type="submit"]');
  const loginForm = document.getElementById("loginForm");
  const togglePassword = document.querySelector("#togglePassword");

  togglePassword.addEventListener("click", function () {
    const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
    passwordInput.setAttribute("type", type);
    this.querySelector("i").classList.toggle("bi-eye");
    this.querySelector("i").classList.toggle("bi-eye-slash");
  });

  if (emailInput.value) {
    fetch(`/check-lockout?email=${encodeURIComponent(emailInput.value)}`, {
      method: "GET",
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.is_locked) {
          Swal.fire({
            icon: "error",
            title: "Bloqueado",
            text: data.message,
          });

          emailInput.disabled = true;
          passwordInput.disabled = true;
          submitButton.disabled = true;

          const tiempoBloqueo = data.remaining_time * 1000;
          setTimeout(function () {
            emailInput.disabled = false;
            passwordInput.disabled = false;
            submitButton.disabled = false;
            Swal.fire({
              icon: "info",
              title: "Puedes volver a intentarlo",
              text: "El tiempo de bloqueo ha expirado.",
            });
          }, tiempoBloqueo);
        }
      })
      .catch((error) =>
        console.error("Error verificando el estado de bloqueo:", error)
      );
  }

  loginForm.addEventListener("submit", function (event) {
    event.preventDefault();

    const email = emailInput.value.trim();
    const password = passwordInput.value.trim();

    if (!email || !password) {
      Swal.fire({
        icon: "error",
        title: "Campos vacíos",
        text: "Por favor, complete todos los campos.",
      });
      return;
    }

    const formData = new FormData(this);

    fetch("/login", {
      method: "POST",
      body: formData,
      headers: {
        "X-Requested-With": "XMLHttpRequest",
        "X-CSRF-TOKEN": document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute("content"),
      },
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          Swal.fire({
            icon: "success",
            title: "Bienvenido a Procesa",
            text: data.message,
            timer: 3000,
            showConfirmButton: false,
          }).then(() => (window.location.href = "/inicio"));
        } else if (data.remaining_time) {
          Swal.fire({
            icon: "error",
            title: "Bloqueado",
            text: data.message,
          });

          emailInput.disabled = true;
          passwordInput.disabled = true;
          submitButton.disabled = true;

          setTimeout(() => {
            emailInput.disabled = false;
            passwordInput.disabled = false;
            submitButton.disabled = false;
            Swal.fire({
              icon: "info",
              title: "Puedes volver a intentarlo",
              text: "El tiempo de bloqueo ha expirado.",
            });
          }, data.remaining_time * 1000);
        } else {
          Swal.fire({
            icon: "error",
            title: "Credenciales incorrectas",
            text: data.message,
          });
        }
      })
      .catch((error) => {
        console.error("Error en la solicitud:", error);
        Swal.fire({
          icon: "error",
          title: "Error de conexión",
          text: "Inténtelo de nuevo.",
        });
      });
  });
});
