document
  .getElementById("changePasswordForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    // Obtener los valores de los campos
    let currentPassword = document.getElementById("current-password").value;
    let newPassword = document.getElementById("password").value;
    let confirmPassword = document.getElementById("password-confirm").value;

    // Validaciones Frontend

    // Validar que los campos no estén vacíos
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

    // Validar que la contraseña no contenga espacios
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
      toastr.error(
        "La nueva contraseña debe contener al menos una letra mayúscula."
      );
      return;
    }

    // Validar que la nueva contraseña tenga al menos una letra minúscula
    if (!/[a-z]/.test(newPassword)) {
      toastr.error(
        "La nueva contraseña debe contener al menos una letra minúscula."
      );
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
      toastr.error(
        "La nueva contraseña debe contener al menos un carácter especial (por ejemplo: !@#$%^&*)."
      );
      return;
    }

    // Validar que la confirmación de la contraseña coincida con la nueva contraseña
    if (newPassword !== confirmPassword) {
      toastr.error("La confirmación de la nueva contraseña no coincide.");
      return;
    }

    // Si las validaciones son correctas, enviamos el formulario usando AJAX
    let formData = new FormData(this);

    fetch(
      document
        .querySelector('meta[name="change-password-url"]')
        .getAttribute("content"),
      {
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        },
        body: formData,
      }
    )
      .then((response) => {
        if (!response.ok) {
          return response.json().then((errorData) => {
            throw new Error(
              errorData.message ||
                "Ocurrió un error, por favor inténtalo de nuevo."
            );
          });
        }
        return response.json();
      })
      .then((data) => {
        if (data.success) {
          toastr.success(data.message);
          // Redirigir si es necesario
          setTimeout(() => {
            window.location.href = "/inicio";
          }, 2000);
        } else {
          toastr.error(data.message);
        }
      })
      .catch((error) => {
        toastr.error(error.message);
      });
  });
