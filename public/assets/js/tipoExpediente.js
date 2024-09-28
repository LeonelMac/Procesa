document.addEventListener("DOMContentLoaded", function () {
  function verificarTipoExpedienteDuplicado(tipoexpediente, callback) {
    $.ajax({
      url: "/tipoExpedientes/verificar",
      method: "POST",
      data: {
        tipoexpediente: tipoexpediente,
        _token: $('meta[name="csrf-token"]').attr("content"),
      },
      success: function (response) {
        callback(response.exists);
      },
      error: function (xhr, status, error) {
        toastr.error("Error al verificar duplicados.");
      },
    });
  }
  $("#agregarTipoExpedienteModal").on("shown.bs.modal", function () {
    let agregarForm = document.getElementById("formAgregarTipoExpediente");
    if (agregarForm) {
      agregarForm.addEventListener("submit", function (event) {
        let tipoExpedienteInput = document.getElementById("tipoexpediente");
        if (tipoExpedienteInput.value.trim() === "") {
          event.preventDefault();
          toastr.error('El campo "Nombre del Tipo Expediente" es obligatorio.');
          return;
        }
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
        if (
          !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(tipoExpedienteInput.value.trim())
        ) {
          event.preventDefault();
          toastr.error(
            "El tipo expediente solo debe contener letras y espacios."
          );
          return;
        }
        event.preventDefault();
        verificarTipoExpedienteDuplicado(
          tipoExpedienteInput.value.trim(),
          function (existe) {
            if (existe) {
              toastr.error("Ya existe un tipo expediente con este nombre.");
            } else {
              toastr.success("Tipo de Expediente agregado exitosamente.");
              agregarForm.submit();
            }
          }
        );
      });
    }
  });
  document
    .querySelectorAll('form[action*="/tipoExpedientes/editar"]')
    .forEach(function (form) {
      form.addEventListener("submit", function (event) {
        let tipoExpedienteInput = form.querySelector(
          'input[name="tipoexpediente"]'
        );
        if (tipoExpedienteInput.value.trim() === "") {
          event.preventDefault();
          toastr.error('El campo "Nombre del Tipo Expediente" es obligatorio.');
          return;
        }
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
        if (
          !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(tipoExpedienteInput.value.trim())
        ) {
          event.preventDefault();
          toastr.error(
            "El tipo expediente solo debe contener letras y espacios."
          );
          return;
        }
        event.preventDefault();
        verificarTipoExpedienteDuplicado(
          tipoExpedienteInput.value.trim(),
          function (existe) {
            if (existe) {
              toastr.error("Ya existe un tipo expediente con este nombre.");
            } else {
              toastr.success("Tipo de Expediente editado exitosamente.");
              form.submit();
            }
          }
        );
      });
    });
  document
    .querySelectorAll('form[action*="/tipoExpedientes/eliminar"]')
    .forEach(function (form) {
      form.addEventListener("submit", function (event) {
        event.preventDefault();
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
            toastr.success("Tipo de Expediente eliminado exitosamente.");
          }
        });
      });
    });
});
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
