document.addEventListener("DOMContentLoaded", function () {
  function verificarEmailDuplicado(email, userId, callback) {
    let data = {
      email: email,
      _token: $('meta[name="csrf-token"]').attr("content"), // Token CSRF
    };

    // Solo incluir userId si existe (caso de edición)
    if (userId) {
      data.user_id = userId;
    }

    $.ajax({
      url: "/usuarios/verificar/email",
      method: "POST",
      data: data,
      success: function (response) {
        callback(response.exists); // Ejecutar el callback con el resultado
      },
      error: function (xhr, status, error) {
        toastr.error("Error al verificar el correo electrónico.");
      },
    });
  }

  // Verificar si el teléfono ya existe, excepto para el usuario actual (solo si existe userId)
  function verificarTelefonoDuplicado(telefono, userId, callback) {
    let data = {
      telefono: telefono,
      _token: $('meta[name="csrf-token"]').attr("content"), // Token CSRF
    };

    // Solo incluir userId si existe (caso de edición)
    if (userId) {
      data.user_id = userId;
    }

    $.ajax({
      url: "/usuarios/verificar/telefono",
      method: "POST",
      data: data,
      success: function (response) {
        callback(response.exists); // Ejecutar el callback con el resultado
      },
      error: function (xhr, status, error) {
        toastr.error("Error al verificar el teléfono.");
      },
    });
  }

  // Validar campo individual
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
        event.preventDefault(); // Prevenir el envío por defecto

        let nombresInput = document.getElementById("nombres");
        let apellidoPInput = document.getElementById("apellidoP");
        let apellidoMInput = document.getElementById("apellidoM");
        let emailInput = document.getElementById("email");
        let telefonoInput = document.getElementById("telefono");
        let direccionInput = document.getElementById("direccion");
        let rolInput = document.getElementById("rol");
        let municipioInput = document.getElementById("municipio");

        // Validar campos individualmente
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
          return; // Detener si hay un error de validación
        }

        // Verificar duplicado de email (sin user_id para agregar)
        verificarEmailDuplicado(
          emailInput.value.trim(),
          null,
          function (emailExiste) {
            if (emailExiste) {
              toastr.error("Ya existe un usuario con este correo.");
            } else {
              // Verificar duplicado de teléfono (sin user_id para agregar)
              verificarTelefonoDuplicado(
                telefonoInput.value.trim(),
                null,
                function (telefonoExiste) {
                  if (telefonoExiste) {
                    toastr.error("Ya existe un usuario con este teléfono.");
                  } else {
                    // Si todo es válido, enviar el formulario
                    toastr.success("Usuario agregado exitosamente.");
                    agregarForm.submit(); // Enviar el formulario
                  }
                }
              );
            }
          }
        );
      });
    }
  });

  // Manejar el formulario de editar usuario
  document
    .querySelectorAll('form[action*="/usuarios/editar"]')
    .forEach(function (form) {
      form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevenir envío inmediato

        // Obtener el ID del usuario del campo oculto
        let usuarioId = form.querySelector('input[name="id"]').value;

        let nombresInput = form.querySelector('input[name="nombres"]');
        let apellidoPInput = form.querySelector('input[name="apellidoP"]');
        let apellidoMInput = form.querySelector('input[name="apellidoM"]');
        let emailInput = form.querySelector('input[name="email"]');
        let telefonoInput = form.querySelector('input[name="telefono"]');
        let direccionInput = form.querySelector('input[name="direccion"]');
        let rolInput = form.querySelector('select[name="rol"]');
        let municipioInput = form.querySelector('select[name="municipio"]');

        // Validar campos individualmente
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
          return; // Detener si hay un error de validación
        }

        // Verificar duplicado de email con el ID del usuario
        verificarEmailDuplicado(
          emailInput.value.trim(),
          usuarioId,
          function (emailExiste) {
            if (emailExiste) {
              toastr.error("Ya existe un usuario con este correo.");
            } else {
              // Verificar duplicado de teléfono con el ID del usuario
              verificarTelefonoDuplicado(
                telefonoInput.value.trim(),
                usuarioId,
                function (telefonoExiste) {
                  if (telefonoExiste) {
                    toastr.error("Ya existe un usuario con este teléfono.");
                  } else {
                    // Si todo es válido, enviar el formulario
                    toastr.success("Usuario editado correctamente.");
                    form.submit(); // Enviar el formulario
                  }
                }
              );
            }
          }
        );
      });
    });

  // Confirmar eliminación de usuario con SweetAlert
  document
    .querySelectorAll('form[action*="/usuarios/eliminar"]')
    .forEach(function (form) {
      form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevenir envío inmediato

        // Verificar si el campo 'input[name="id"]' existe en el formulario
        const userIdInput = form.querySelector('input[name="id"]');

        if (!userIdInput) {
          toastr.error("El ID del usuario no está disponible.");
          return; // Detener la ejecución si no se encuentra el campo 'id'
        }

        // Obtener el ID del usuario que se quiere eliminar desde el formulario
        const userIdToDelete = userIdInput.value;

        // Obtener el ID del usuario autenticado
        const currentUserId = document
          .querySelector('meta[name="user-id"]')
          .getAttribute("content");

        // Verificar si el usuario está intentando eliminarse a sí mismo
        if (userIdToDelete === currentUserId) {
          toastr.error("No puedes eliminar tu propio usuario.");
          return; // Detener la ejecución si intenta eliminarse a sí mismo
        }

        // Confirmar eliminación con SweetAlert
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
            form.submit(); // Enviar el formulario para eliminar
            toastr.success("Usuario eliminado exitosamente.");
          }
        });
      });
    });

  document
    .querySelectorAll('button[id^="confirmResetPassword"]')
    .forEach(function (button) {
      button.addEventListener("click", function () {
        let userId = this.getAttribute("data-user-id"); // Obtener el ID del usuario desde el botón

        // Usar SweetAlert para confirmar la acción
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
            // Capturamos el formulario dentro del modal usando el ID de usuario
            let form = document.querySelector(
              `#confirmModal${userId}reset form`
            );

            // Enviar la solicitud AJAX para restablecer la contraseña
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
                  // Mostrar mensaje de éxito con SweetAlert
                  Swal.fire({
                    icon: "success",
                    title: "¡Éxito!",
                    text: data.message,
                    confirmButtonText: "Aceptar",
                  }).then(() => {
                    // Cerrar el modal
                    let modal = document.querySelector(
                      `#confirmModal${userId}reset`
                    );
                    let bootstrapModal = bootstrap.Modal.getInstance(modal); // Usamos Bootstrap modal instance
                    bootstrapModal.hide();

                    // Refrescar la página
                    setTimeout(() => {
                      location.reload();
                    }, 500); // Refrescar después de cerrar el modal
                  });
                } else {
                  // Mostrar mensaje de error con SweetAlert
                  Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: data.message,
                    confirmButtonText: "Aceptar",
                  });
                }
              })
              .catch((error) => {
                // Manejar errores inesperados
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

  // Cargar roles y municipios cuando se abre el modal de agregar usuario
  $("#agregarUsuarioModal").on("show.bs.modal", function () {
    $.ajax({
      url: "/usuarios/obtener",
      type: "GET",
      success: function (data) {
        let selectRol = $("#rol");
        let selectMunicipio = $("#municipio");

        selectRol.empty(); // Limpiar el select de roles antes de llenarlo
        selectRol.append('<option value="">Selecciona un rol</option>'); // Opción por defecto
        data.roles.forEach(function (rol) {
          selectRol.append(
            '<option value="' +
              rol.id_rolusuarios +
              '">' +
              rol.rolusuarios +
              "</option>"
          );
        });

        selectMunicipio.empty(); // Limpiar el select de municipios antes de llenarlo
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

// Función para cargar los datos del usuario al abrir el modal de edición
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
