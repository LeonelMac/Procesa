document.addEventListener("DOMContentLoaded", function () {
  // Verificar si el tipo de expediente ya existe
  function verificarTipoExpedienteDuplicado(tipoexpediente, callback) {
    $.ajax({
      url: "/tipoExpedientes/verificar", // Ruta para verificar duplicados de tipo expediente
      method: "POST",
      data: {
        tipoexpediente: tipoexpediente,
        _token: $('meta[name="csrf-token"]').attr("content"), // Token CSRF
      },
      success: function (response) {
        callback(response.exists); // Ejecutar el callback con el resultado
      },
      error: function (xhr, status, error) {
        toastr.error("Error al verificar duplicados.");
      },
    });
  }

  // Manejar el formulario de agregar tipo expediente
  $("#agregarTipoExpedienteModal").on("shown.bs.modal", function () {
    let agregarForm = document.getElementById("formAgregarTipoExpediente");
    if (agregarForm) {
      agregarForm.addEventListener("submit", function (event) {
        let tipoExpedienteInput = document.getElementById("tipoexpediente");

        // Validaciones básicas del campo de tipo expediente
        if (tipoExpedienteInput.value.trim() === "") {
          event.preventDefault();
          toastr.error('El campo "Nombre del Tipo Expediente" es obligatorio.');
          return;
        }

        // Validación de longitud mínima y máxima
        if (
          tipoExpedienteInput.value.trim().length < 3 ||
          tipoExpedienteInput.value.trim().length > 50
        ) {
          event.preventDefault();
          toastr.error(
            "El tipo expediente debe tener entre 3 y 50 caracteres."
          );
          return;
        }

        // Validación de solo letras y espacios
        if (
          !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(tipoExpedienteInput.value.trim())
        ) {
          event.preventDefault();
          toastr.error(
            "El tipo expediente solo debe contener letras y espacios."
          );
          return;
        }

        event.preventDefault(); // Prevenir el envío por defecto

        // Verificar si el tipo expediente ya existe
        verificarTipoExpedienteDuplicado(
          tipoExpedienteInput.value.trim(),
          function (existe) {
            if (existe) {
              toastr.error("Ya existe un tipo expediente con este nombre.");
            } else {
              toastr.success("Tipo de Expediente agregado exitosamente.");
              agregarForm.submit(); // Enviar el formulario
            }
          }
        );
      });
    }
  });

  // Manejar el formulario de editar tipo expediente
  document
    .querySelectorAll('form[action*="/tipoExpedientes/editar"]')
    .forEach(function (form) {
      form.addEventListener("submit", function (event) {
        let tipoExpedienteInput = form.querySelector(
          'input[name="tipoexpediente"]'
        );

        // Validaciones básicas del campo de tipo expediente
        if (tipoExpedienteInput.value.trim() === "") {
          event.preventDefault();
          toastr.error('El campo "Nombre del Tipo Expediente" es obligatorio.');
          return;
        }

        // Validación de longitud mínima y máxima
        if (
          tipoExpedienteInput.value.trim().length < 3 ||
          tipoExpedienteInput.value.trim().length > 50
        ) {
          event.preventDefault();
          toastr.error(
            "El tipo expediente debe tener entre 3 y 50 caracteres."
          );
          return;
        }

        // Validación de solo letras y espacios
        if (
          !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(tipoExpedienteInput.value.trim())
        ) {
          event.preventDefault();
          toastr.error(
            "El tipo expediente solo debe contener letras y espacios."
          );
          return;
        }

        event.preventDefault(); // Prevenir envío inmediato

        // Verificar si el tipo expediente ya existe
        verificarTipoExpedienteDuplicado(
          tipoExpedienteInput.value.trim(),
          function (existe) {
            if (existe) {
              toastr.error("Ya existe un tipo expediente con este nombre.");
            } else {
              toastr.success("Tipo de Expediente editado exitosamente.");
              form.submit(); // Enviar el formulario
            }
          }
        );
      });
    });

  // Confirmar eliminación de tipo expediente con SweetAlert
  document
    .querySelectorAll('form[action*="/tipoExpedientes/eliminar"]')
    .forEach(function (form) {
      form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevenir envío inmediato
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
            toastr.success("Tipo de Expediente eliminado exitosamente.");
          }
        });
      });
    });
});
// Cargar datos cuando se abre el modal de editar tipo expediente
function cargarDatosTipoExpediente(idtipoexpediente) {
  $.ajax({
    url: "/tipoExpedientes/obtener/" + idtipoexpediente,
    type: "GET",
    success: function (data) {
      $("#editar-tipoexpediente-" + idtipoexpediente).val(data.tipoexpediente);
    },
    error: function (xhr, status, error) {
      toastr.error("Error al obtener los datos del tipo expediente.");
    },
  });
}
