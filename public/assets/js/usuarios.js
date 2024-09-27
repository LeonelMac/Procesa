document.addEventListener("DOMContentLoaded", function () {
  const formAgregar = document.getElementById("agregarUsuarioModal");
  const formEditar = document.getElementById("editarUsuarioModal");

  if (formAgregar) {
    validarFormulario(formAgregar);
  }

  if (formEditar) {
    validarFormulario(formEditar);
  }

  function validarFormulario(form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      const nombres = form.querySelector("#nombres").value.trim();
      const apellidoP = form.querySelector("#apellidoP").value.trim();
      const apellidoM = form.querySelector("#apellidoM").value.trim();
      const email = form.querySelector("#email").value.trim();
      const rol = form.querySelector("#rol").value.trim();
      const municipio = form.querySelector("#municipio").value.trim();
      const direccion = form.querySelector("#direccion").value.trim();
      const telefono = form.querySelector("#telefono").value.trim();
      const userId = form.querySelector("#id")
        ? form.querySelector("#id").value
        : null; // Para editar

      verificarDuplicados(email, telefono, userId).then((result) => {
        if (result.success) {
          if (!validarCampo(nombres, "Por favor, ingresa un nombre válido."))
            return;
          if (
            !validarCampo(apellidoP, "Por favor, ingresa el apellido paterno.")
          )
            return;
          if (
            !validarCampo(apellidoM, "Por favor, ingresa el apellido materno.")
          )
            return;
          if (!validarEmail(email)) return;
          if (!validarCampo(rol, "Por favor, selecciona un rol.")) return;
          if (!validarCampo(municipio, "Por favor, selecciona un municipio."))
            return;
          if (!validarCampo(direccion, "Por favor, ingresa una dirección."))
            return;
          if (!validarTelefono(telefono)) return;

          e.target.submit();
        } else {
          toastr.error(result.message);
        }
      });
    });
  }

  function verificarDuplicados(email, telefono, userId = null) {
    return fetch("/usuarios/verificar-duplicados", {
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute("content"),
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        email: email,
        telefono: telefono,
        id: userId,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        return data;
      })
      .catch((error) => {
        toastr.error("Ocurrió un error al verificar duplicados.");
        return { success: false };
      });
  }

  function validarCampo(campo, mensajeError) {
    if (!campo || campo === "") {
      toastr.error(mensajeError);
      return false;
    }
    return true;
  }

  function validarEmail(campo) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regex.test(campo)) {
      toastr.error("Por favor, ingresa un correo electrónico válido.");
      return false;
    }
    return true;
  }

  function validarTelefono(campo) {
    if (campo.length !== 10 || isNaN(campo)) {
      toastr.error("El teléfono debe tener 10 dígitos numéricos.");
      return false;
    }
    return true;
  }

  document
    .querySelectorAll(
      '[data-action="deleteUser"], [data-action="resetPassword"]'
    )
    .forEach(function (button) {
      button.addEventListener("click", function () {
        const action = button.getAttribute("data-action");
        const userId = button.getAttribute("data-user-id");

        // Selecciona el modal correspondiente basado en la acción
        const modalId =
          action === "deleteUser"
            ? `deleteUserModal${userId}`
            : `resetPasswordModal${userId}`;
        const modalElement = document.getElementById(modalId);

        if (!modalElement) {
          console.error(`No se pudo encontrar el modal con id ${modalId}`);
          return;
        }

        // Inicializar el modal con Bootstrap
        const modal = new bootstrap.Modal(modalElement);
        modal.show();

        // Espera hasta que el modal esté completamente visible
        modalElement.addEventListener(
          "shown.bs.modal",
          function () {
            const confirmButtonId =
              action === "deleteUser"
                ? `confirmDeleteUser${userId}`
                : `confirmResetPassword${userId}`;
            const confirmButton = modalElement.querySelector(
              `#${confirmButtonId}`
            );

            if (!confirmButton) {
              console.error(
                `No se pudo encontrar el botón de confirmación con id ${confirmButtonId}`
              );
              return;
            }

            // Manejar el clic en el botón de confirmación
            confirmButton.addEventListener(
              "click",
              function () {
                modal.hide(); // Cierra el modal

                // Muestra el SweetAlert después de cerrar el modal
                modalElement.addEventListener(
                  "hidden.bs.modal",
                  function () {
                    Swal.fire({
                      title:
                        action === "deleteUser"
                          ? "¿Estás seguro de eliminar este usuario?"
                          : "¿Estás seguro de restablecer la contraseña?",
                      text:
                        action === "deleteUser"
                          ? "Esta acción no se puede deshacer."
                          : "La contraseña será restablecida.",
                      icon: "warning",
                      showCancelButton: true,
                      confirmButtonColor: "#3085d6",
                      cancelButtonColor: "#d33",
                      confirmButtonText:
                        action === "deleteUser"
                          ? "Sí, eliminar"
                          : "Sí, restablecer",
                      cancelButtonText: "Cancelar",
                    }).then((result) => {
                      if (result.isConfirmed) {
                        // Realiza la solicitud de API para eliminar o restablecer
                        const url =
                          action === "deleteUser"
                            ? `/usuarios/eliminar/${userId}`
                            : `/usuarios/resetPassword/${userId}`;
                        const method =
                          action === "deleteUser" ? "DELETE" : "POST";

                        fetch(url, {
                          method: method,
                          headers: {
                            "X-CSRF-TOKEN": document
                              .querySelector('meta[name="csrf-token"]')
                              .getAttribute("content"),
                          },
                        })
                          .then((response) => response.json())
                          .then((data) => {
                            if (data.success) {
                              Swal.fire("Éxito", data.message, "success").then(
                                () => window.location.reload()
                              ); // Recargar la página si la acción fue exitosa
                            } else {
                              Swal.fire("Error", data.message, "error");
                            }
                          })
                          .catch((error) =>
                            Swal.fire(
                              "Error",
                              "Ocurrió un error inesperado.",
                              "error"
                            )
                          );
                      }
                    });
                  },
                  { once: true }
                );
              },
              { once: true }
            );
          },
          { once: true }
        );
      });
    });
});
