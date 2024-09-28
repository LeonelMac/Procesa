document
  .getElementById("changePasswordForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();
    let currentPassword = document.getElementById("current-password").value;
    let newPassword = document.getElementById("password").value;
    let confirmPassword = document.getElementById("password-confirm").value;
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
    if (newPassword.length < 8) {
      toastr.error("La nueva contraseña debe tener al menos 8 caracteres.");
      return;
    }
    if (/\s/.test(newPassword)) {
      toastr.error("La nueva contraseña no debe contener espacios.");
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
    if (commonPasswords.includes(newPassword)) {
      toastr.error("Por favor, elija una nueva contraseña más segura.");
      return;
    }
    if (!/[A-Z]/.test(newPassword)) {
      toastr.error(
        "La nueva contraseña debe contener al menos una letra mayúscula."
      );
      return;
    }
    if (!/[a-z]/.test(newPassword)) {
      toastr.error(
        "La nueva contraseña debe contener al menos una letra minúscula."
      );
      return;
    }
    if (!/[0-9]/.test(newPassword)) {
      toastr.error("La nueva contraseña debe contener al menos un número.");
      return;
    }
    const specialCharRegex = /[!@#$%^&*(),.?":{}|<>]/;
    if (!specialCharRegex.test(newPassword)) {
      toastr.error(
        "La nueva contraseña debe contener al menos un carácter especial (por ejemplo: !@#$%^&*)."
      );
      return;
    }
    if (newPassword !== confirmPassword) {
      toastr.error("La confirmación de la nueva contraseña no coincide.");
      return;
    }
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
