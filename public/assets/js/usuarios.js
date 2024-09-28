document.addEventListener("DOMContentLoaded", function () {
  function verificarEmailDuplicado(email, userId, callback) {
    let data = {
      email: email,
      _token: $('meta[name="csrf-token"]').attr("content"),
    };
    if (userId) {
      data.user_id = userId;
    }

    $.ajax({
      url: "/usuarios/verificar/email",
      method: "POST",
      data: data,
      success: function (response) {
        callback(response.exists);
      },
      error: function (xhr, status, error) {
        toastr.error("Error al verificar el correo electrónico.");
      },
    });
  }
  function verificarTelefonoDuplicado(telefono, userId, callback) {
    let data = {
      telefono: telefono,
      _token: $('meta[name="csrf-token"]').attr("content"),
    };
    if (userId) {
      data.user_id = userId;
    }

    $.ajax({
      url: "/usuarios/verificar/telefono",
      method: "POST",
      data: data,
      success: function (response) {
        callback(response.exists);
      },
      error: function (xhr, status, error) {
        toastr.error("Error al verificar el teléfono.");
      },
    });
  }
  function validarCampoIndividual(valor, campo, mensaje) {
    if (valor.trim() === "") {
      toastr.error(mensaje);
      return false;
    }
    return true;
  }

  $("#agregarUsuarioModal").on("shown.bs.modal", function () {
    let agregarForm = document.getElementById("formAgregarUsuario");
    if (agregarForm) {
      agregarForm.addEventListener("submit", function (event) {
        event.preventDefault();
        let nombresInput = document.getElementById("nombres");
        let apellidoPInput = document.getElementById("apellidoP");
        let apellidoMInput = document.getElementById("apellidoM");
        let emailInput = document.getElementById("email");
        let telefonoInput = document.getElementById("telefono");
        let direccionInput = document.getElementById("direccion");
        let rolInput = document.getElementById("rol");
        let municipioInput = document.getElementById("municipio");
        if (
          !validarCampoIndividual(
            nombresInput.value,
            "nombres",
            'El campo "Nombre" es obligatorio.'
          ) ||
          !validarCampoIndividual(
            apellidoPInput.value,
            "apellidoP",
            'El campo "Apellido Paterno" es obligatorio.'
          ) ||
          !validarCampoIndividual(
            apellidoMInput.value,
            "apellidoM",
            'El campo "Apellido Materno" es obligatorio.'
          ) ||
          !validarCampoIndividual(
            emailInput.value,
            "email",
            'El campo "Correo Electrónico" es obligatorio.'
          ) ||
          !validarCampoIndividual(
            telefonoInput.value,
            "telefono",
            'El campo "Teléfono" es obligatorio.'
          ) ||
          !validarCampoIndividual(
            direccionInput.value,
            "direccion",
            'El campo "Dirección" es obligatorio.'
          ) ||
          !validarCampoIndividual(
            rolInput.value,
            "rol",
            'El campo "Seleccionar Rol" es obligatorio.'
          ) ||
          !validarCampoIndividual(
            municipioInput.value,
            "municipio",
            'El campo "Seleccionar Municipio" es obligatorio.'
          )
        ) {
          return;
        }
        verificarEmailDuplicado(
          emailInput.value.trim(),
          null,
          function (emailExiste) {
            if (emailExiste) {
              toastr.error("Ya existe un usuario con este correo.");
            } else {
              verificarTelefonoDuplicado(
                telefonoInput.value.trim(),
                null,
                function (telefonoExiste) {
                  if (telefonoExiste) {
                    toastr.error("Ya existe un usuario con este teléfono.");
                  } else {
                    toastr.success("Usuario agregado exitosamente.");
                    agregarForm.submit();
                  }
                }
              );
            }
          }
        );
      });
    }
  });

  document
    .querySelectorAll('form[action*="/usuarios/editar"]')
    .forEach(function (form) {
      form.addEventListener("submit", function (event) {
        event.preventDefault();
        let usuarioId = form.querySelector('input[name="id"]').value;
        let nombresInput = form.querySelector('input[name="nombres"]');
        let apellidoPInput = form.querySelector('input[name="apellidoP"]');
        let apellidoMInput = form.querySelector('input[name="apellidoM"]');
        let emailInput = form.querySelector('input[name="email"]');
        let telefonoInput = form.querySelector('input[name="telefono"]');
        let direccionInput = form.querySelector('input[name="direccion"]');
        let rolInput = form.querySelector('select[name="rol"]');
        let municipioInput = form.querySelector('select[name="municipio"]');
        if (
          !validarCampoIndividual(
            nombresInput.value,
            "nombres",
            'El campo "Nombre" es obligatorio.'
          ) ||
          !validarCampoIndividual(
            apellidoPInput.value,
            "apellidoP",
            'El campo "Apellido Paterno" es obligatorio.'
          ) ||
          !validarCampoIndividual(
            apellidoMInput.value,
            "apellidoM",
            'El campo "Apellido Materno" es obligatorio.'
          ) ||
          !validarCampoIndividual(
            emailInput.value,
            "email",
            'El campo "Correo Electrónico" es obligatorio.'
          ) ||
          !validarCampoIndividual(
            telefonoInput.value,
            "telefono",
            'El campo "Teléfono" es obligatorio.'
          ) ||
          !validarCampoIndividual(
            direccionInput.value,
            "telefono",
            'El campo "Dirección" es obligatorio.'
          ) ||
          !validarCampoIndividual(
            rolInput.value,
            "rol",
            'El campo "Seleccionar Rol" es obligatorio.'
          ) ||
          !validarCampoIndividual(
            municipioInput.value,
            "municipio",
            'El campo "Seleccionar Municipio" es obligatorio.'
          )
        ) {
          return;
        }
        verificarEmailDuplicado(
          emailInput.value.trim(),
          usuarioId,
          function (emailExiste) {
            if (emailExiste) {
              toastr.error("Ya existe un usuario con este correo.");
            } else {
              verificarTelefonoDuplicado(
                telefonoInput.value.trim(),
                usuarioId,
                function (telefonoExiste) {
                  if (telefonoExiste) {
                    toastr.error("Ya existe un usuario con este teléfono.");
                  } else {
                    toastr.success("Usuario editado correctamente.");
                    form.submit();
                  }
                }
              );
            }
          }
        );
      });
    });

  document
    .querySelectorAll('form[action*="/usuarios/eliminar"]')
    .forEach(function (form) {
      form.addEventListener("submit", function (event) {
        event.preventDefault();
        const userIdInput = form.querySelector('input[name="id"]');
        if (!userIdInput) {
          toastr.error("El ID del usuario no está disponible.");
          return;
        }
        const userIdToDelete = userIdInput.value;
        const currentUserId = document
          .querySelector('meta[name="user-id"]')
          .getAttribute("content");
        if (userIdToDelete === currentUserId) {
          toastr.error("No puedes eliminar tu propio usuario.");
          return;
        }
        Swal.fire({
          title: "¿Estás seguro?",
          text: "No podrás revertir esta acción",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Sí, eliminar",
          cancelButtonText: "Cancelar",
          reverseButtons: true,
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
            toastr.success("Usuario eliminado exitosamente.");
          }
        });
      });
    });

  document
    .querySelectorAll('button[id^="confirmResetPassword"]')
    .forEach(function (button) {
      button.addEventListener("click", function () {
        let userId = this.getAttribute("data-user-id");
        Swal.fire({
          title: "¿Estás seguro?",
          text: "Esta acción restablecerá la contraseña del usuario.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Sí, restablecer",
          cancelButtonText: "Cancelar",
          reverseButtons: true,
        }).then((result) => {
          if (result.isConfirmed) {
            let form = document.querySelector(
              `#confirmModal${userId}reset form`
            );
            let formData = new FormData(form);
            let actionUrl = form.getAttribute("action");

            fetch(actionUrl, {
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
                  Swal.fire({
                    icon: "success",
                    title: "¡Éxito!",
                    text: data.message,
                    confirmButtonText: "Aceptar",
                  }).then(() => {
                    let modal = document.querySelector(
                      `#confirmModal${userId}reset`
                    );
                    let bootstrapModal = bootstrap.Modal.getInstance(modal);
                    bootstrapModal.hide();
                    setTimeout(() => {
                      location.reload();
                    }, 500);
                  });
                } else {
                  Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: data.message,
                    confirmButtonText: "Aceptar",
                  });
                }
              })
              .catch((error) => {
                Swal.fire({
                  icon: "error",
                  title: "Error inesperado",
                  text: "Ocurrió un error al restablecer la contraseña.",
                  confirmButtonText: "Aceptar",
                });
              });
          }
        });
      });
    });

  $("#agregarUsuarioModal").on("show.bs.modal", function () {
    $.ajax({
      url: "/usuarios/obtener",
      type: "GET",
      success: function (data) {
        let selectRol = $("#rol");
        let selectMunicipio = $("#municipio");

        selectRol.empty();
        selectRol.append('<option value="">Selecciona un rol</option>');
        data.roles.forEach(function (rol) {
          selectRol.append(
            '<option value="' +
              rol.id_rolusuarios +
              '">' +
              rol.rolusuarios +
              "</option>"
          );
        });

        selectMunicipio.empty();
        selectMunicipio.append(
          '<option value="">Selecciona un municipio</option>'
        ); // Opción por defecto
        data.municipios.forEach(function (municipio) {
          selectMunicipio.append(
            '<option value="' +
              municipio.idmunicipio +
              '">' +
              municipio.municipio +
              "</option>"
          );
        });
      },
      error: function (xhr, status, error) {
        toastr.error("Error al obtener los roles y municipios.");
      },
    });
  });
});

function cargarDatosUsuario(idUsuario) {
  $.ajax({
    url: "/usuarios/obtener/" + idUsuario,
    type: "GET",
    success: function (data) {
      $("#editar-nombres-" + idUsuario).val(data.usuario.nombres);
      $("#editar-apellidoP-" + idUsuario).val(data.usuario.apellidoP);
      $("#editar-apellidoM-" + idUsuario).val(data.usuario.apellidoM);
      $("#editar-email-" + idUsuario).val(data.usuario.email);
      $("#editar-telefono-" + idUsuario).val(data.usuario.telefono);
      $("#editar-direccion-" + idUsuario).val(data.usuario.direccion);

      let selectRol = $("#editar-rol-" + idUsuario);
      let selectMunicipio = $("#editar-municipio-" + idUsuario);

      selectRol.empty();
      selectRol.append('<option value="">Selecciona un rol</option>');
      data.roles.forEach(function (rol) {
        selectRol.append(
          '<option value="' +
            rol.id_rolusuarios +
            '">' +
            rol.rolusuarios +
            "</option>"
        );
      });
      selectRol.val(data.usuario.rol.id_rolusuarios);

      selectMunicipio.empty();
      selectMunicipio.append(
        '<option value="">Selecciona un municipio</option>'
      );
      data.municipios.forEach(function (municipio) {
        selectMunicipio.append(
          '<option value="' +
            municipio.idmunicipio +
            '">' +
            municipio.municipio +
            "</option>"
        );
      });
      selectMunicipio.val(data.usuario.municipio.idmunicipio);
    },
    error: function (xhr, status, error) {
      toastr.error("Error al obtener los datos del usuario.");
    },
  });
}
