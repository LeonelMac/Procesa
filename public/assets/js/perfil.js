document.addEventListener("DOMContentLoaded", function () {
  const profileForm = document.getElementById("profileForm");
  profileForm.addEventListener("submit", function (e) {
    e.preventDefault();
    const nombres = document.getElementById("nombres").value.trim();
    const apellidoP = document.getElementById("apellidoP").value.trim();
    const apellidoM = document.getElementById("apellidoM").value.trim();
    const direccion = document.getElementById("direccion").value.trim();
    const telefono = document.getElementById("telefono").value.trim();
    const municipio = document.getElementById("municipio").value;
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
    const phoneRegex = /^[0-9]{10}$/;
    if (!phoneRegex.test(telefono)) {
      toastr.error("El teléfono debe contener 10 dígitos numéricos.");
      return;
    }
    let formData = new FormData(profileForm);
    fetch(profileForm.action, {
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute("content"),
      },
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          toastr.success(data.message, "", { timeOut: 5000 });
          setTimeout(() => {
            location.reload();
          }, 1000);
        } else {
          toastr.error(data.message, "", { timeOut: 5000 });
        }
      })
      .catch((error) => {
        toastr.error(
          "Ocurrió un error inesperado. Por favor, inténtalo de nuevo.",
          "",
          { timeOut: 5000 }
        );
      });
  });
  const passwordForm = document.getElementById("passwordForm");
  passwordForm.addEventListener("submit", function (e) {
    e.preventDefault();
    const currentPassword = document
      .getElementById("current-password")
      .value.trim();
    const newPassword = document.getElementById("password").value.trim();
    const confirmPassword = document
      .getElementById("password-confirm")
      .value.trim();
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
    let formData = new FormData(passwordForm);
    fetch(passwordForm.action, {
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute("content"),
      },
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          toastr.success(data.message, "", { timeOut: 5000 });
          passwordForm.reset();
        } else {
          toastr.error(data.message, "", { timeOut: 5000 });
        }
      })
      .catch((error) => {
        toastr.error(
          "Ocurrió un error inesperado. Por favor, inténtalo de nuevo.",
          "",
          { timeOut: 5000 }
        );
      });
  });
});
