document.addEventListener("DOMContentLoaded", function () {
  function verificarEstatusExpedienteDuplicado(estatusexpediente, callback) {
    $.ajax({
      url: "/estatus/expedientes/verificar", 
      method: "POST",
      data: {
        estatusexpediente: estatusexpediente,
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

  $("#agregarEstatusExpedienteModal").on("shown.bs.modal", function () {
    let agregarForm = document.getElementById("formAgregarEstatusExpediente");
    if (agregarForm) {
      agregarForm.addEventListener("submit", function (event) {
        let estatusExpedienteInput =
          document.getElementById("estatusexpediente");
        if (estatusExpedienteInput.value.trim() === "") {
          event.preventDefault();
          toastr.error('El campo "Nombre del Estatus" es obligatorio.');
          return;
        }
        if (
          estatusExpedienteInput.value.trim().length < 3 ||
          estatusExpedienteInput.value.trim().length > 50
        ) {
          event.preventDefault();
          toastr.error(
            "El nombre del estatus debe tener entre 3 y 50 caracteres."
          );
          return;
        }
        if (
          !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(estatusExpedienteInput.value.trim())
        ) {
          event.preventDefault();
          toastr.error(
            "El nombre del estatus solo debe contener letras y espacios."
          );
          return;
        }

        event.preventDefault(); 
        verificarEstatusExpedienteDuplicado(
          estatusExpedienteInput.value.trim(),
          function (existe) {
            if (existe) {
              toastr.error("Ya existe un estatus expediente con este nombre.");
            } else {
              toastr.success("Estatus de Expediente agregado exitosamente.");
              agregarForm.submit(); 
            }
          }
        );
      });
    }
  });

  document
    .querySelectorAll('form[action*="/estatus/expedientes/editar"]')
    .forEach(function (form) {
      form.addEventListener("submit", function (event) {
        let estatusExpedienteInput = form.querySelector(
          'input[name="estatusexpediente"]'
        );
        if (estatusExpedienteInput.value.trim() === "") {
          event.preventDefault();
          toastr.error('El campo "Nombre del Estatus" es obligatorio.');
          return;
        }
        if (
          estatusExpedienteInput.value.trim().length < 3 ||
          estatusExpedienteInput.value.trim().length > 50
        ) {
          event.preventDefault();
          toastr.error(
            "El nombre del estatus debe tener entre 3 y 50 caracteres."
          );
          return;
        }
        if (
          !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(estatusExpedienteInput.value.trim())
        ) {
          event.preventDefault();
          toastr.error(
            "El nombre del estatus solo debe contener letras y espacios."
          );
          return;
        }

        event.preventDefault(); 
        verificarEstatusExpedienteDuplicado(
          estatusExpedienteInput.value.trim(),
          function (existe) {
            if (existe) {
              toastr.error("Ya existe un estatus expediente con este nombre.");
            } else {
              toastr.success("Estatus de Expediente editado exitosamente.");
              form.submit(); 
            }
          }
        );
      });
    });

  document
    .querySelectorAll('form[action*="/estatus/expedientes/eliminar"]')
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
            toastr.success("Estatus de Expediente eliminado exitosamente.");
          }
        });
      });
    });
});
function cargarDatosEstatusExpediente(idestatusexpediente) {
  $.ajax({
      url: '/estatus/expedientes/obtener/' + idestatusexpediente,  
      type: 'GET',
      success: function (data) {
          $('#editar-estatusexpediente-' + idestatusexpediente).val(data.estatusexpediente);
      }
  });
}
