document.addEventListener("DOMContentLoaded", function () {
  // Verificar si el tipo de búsqueda ya existe
  function verificarTipoBusquedaDuplicado(tipobusqueda, callback) {
    $.ajax({
      url: "/tipo/busquedas/verificar", // Ruta para verificar tipo de búsqueda duplicado
      method: "POST",
      data: {
        tipobusqueda: tipobusqueda,
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

  // Manejar el formulario de agregar tipo de búsqueda
  $("#agregarTipoBusquedaModal").on("shown.bs.modal", function () {
    let agregarForm = document.getElementById("formAgregarTipoBusqueda");
    if (agregarForm) {
      agregarForm.addEventListener("submit", function (event) {
        let tipoBusquedaInput = document.getElementById("tipobusqueda");
        let juzgadoInput = document.getElementById("juzgado");

        // Validaciones básicas del campo de tipo de búsqueda
        if (tipoBusquedaInput.value.trim() === "") {
          event.preventDefault();
          toastr.error('El campo "Tipo de Búsqueda" es obligatorio.');
          return;
        }

        // Validación de longitud mínima y máxima
        if (
          tipoBusquedaInput.value.trim().length < 3 ||
          tipoBusquedaInput.value.trim().length > 50
        ) {
          event.preventDefault();
          toastr.error(
            "El tipo de búsqueda debe tener entre 3 y 50 caracteres."
          );
          return;
        }

        // Validación de solo letras y espacios
        if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(tipoBusquedaInput.value.trim())) {
          event.preventDefault();
          toastr.error(
            "El tipo de búsqueda solo debe contener letras y espacios."
          );
          return;
        }

        if (juzgadoInput.value === "") {
          event.preventDefault();
          toastr.error('El campo "Seleccionar Juzgado" es obligatorio.');
          return;
        }

        event.preventDefault(); // Prevenir el envío por defecto

        // Verificar si el tipo de búsqueda ya existe
        verificarTipoBusquedaDuplicado(
          tipoBusquedaInput.value.trim(),
          function (existe) {
            if (existe) {
              toastr.error("Ya existe un tipo de búsqueda con este nombre.");
            } else {
              toastr.success("Tipo de Búsqueda agregado exitosamente.");
              agregarForm.submit(); // Enviar el formulario
            }
          }
        );
      });
    }
  });

  // Manejar el formulario de editar tipo de búsqueda
  document
    .querySelectorAll('form[action*="/tipo/busquedas/editar"]')
    .forEach(function (form) {
      form.addEventListener("submit", function (event) {
        let tipoBusquedaInput = form.querySelector(
          'input[name="tipobusqueda"]'
        );
        let juzgadoInput = form.querySelector('select[name="juzgado"]');

        // Validaciones básicas del campo de tipo de búsqueda
        if (tipoBusquedaInput.value.trim() === "") {
          event.preventDefault();
          toastr.error('El campo "Tipo de Búsqueda" es obligatorio.');
          return;
        }

        // Validación de longitud mínima y máxima
        if (
          tipoBusquedaInput.value.trim().length < 3 ||
          tipoBusquedaInput.value.trim().length > 50
        ) {
          event.preventDefault();
          toastr.error(
            "El tipo de búsqueda debe tener entre 3 y 50 caracteres."
          );
          return;
        }

        // Validación de solo letras y espacios
        if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(tipoBusquedaInput.value.trim())) {
          event.preventDefault();
          toastr.error(
            "El tipo de búsqueda solo debe contener letras y espacios."
          );
          return;
        }

        if (juzgadoInput.value === "") {
          event.preventDefault();
          toastr.error('El campo "Seleccionar Juzgado" es obligatorio.');
          return;
        }

        event.preventDefault(); // Prevenir envío inmediato

        // Verificar si el tipo de búsqueda ya existe
        verificarTipoBusquedaDuplicado(
          tipoBusquedaInput.value.trim(),
          function (existe) {
            if (existe) {
              toastr.error("Ya existe un tipo de búsqueda con este nombre.");
            } else {
              toastr.success("Tipo de Búsqueda editado exitosamente.");
              form.submit(); // Enviar el formulario
            }
          }
        );
      });
    });

  // Confirmar eliminación de tipo de búsqueda con SweetAlert
  document
    .querySelectorAll('form[action*="/tipo/busquedas/eliminar"]')
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
            toastr.success("Tipo de Búsqueda eliminado exitosamente.");
          }
        });
      });
    });

  // Cargar juzgados cuando se abre el modal de agregar tipo de búsqueda
  $("#agregarTipoBusquedaModal").on("show.bs.modal", function () {
    $.ajax({
      url: "/tipo/busquedas/obtener",
      type: "GET",
      success: function (data) {
        let selectJuzgado = $("#juzgado");
        selectJuzgado.empty();
        selectJuzgado.append('<option value="">Selecciona un juzgado</option>');
        data.juzgados.forEach(function (juzgado) {
          selectJuzgado.append(
            '<option value="' +
              juzgado.idjuzgados +
              '">' +
              juzgado.juzgados +
              "</option>"
          );
        });
      },
      error: function (xhr, status, error) {
        console.error("Error al obtener los juzgados:", error);
      },
    });
  });
});

// Función para cargar los datos del tipo de búsqueda al abrir el modal de edición
function cargarDatosTipoBusqueda(idtipobusqueda) {
  $.ajax({
    url: "/tipo/busquedas/obtener/" + idtipobusqueda,
    type: "GET",
    success: function (data) {
      console.log(data);
      $("#editar-tipobusqueda-" + idtipobusqueda).val(
        data.tipobusqueda.tipobusqueda
      );
      let selectJuzgado = $("#editar-juzgado-" + idtipobusqueda);
      selectJuzgado.empty();
      selectJuzgado.append('<option value="">Selecciona un juzgado</option>');
      data.juzgados.forEach(function (juzgado) {
        selectJuzgado.append(
          '<option value="' +
            juzgado.idjuzgados +
            '">' +
            juzgado.juzgados +
            "</option>"
        );
      });
      selectJuzgado.val(data.tipobusqueda.juzgado.idjuzgados);
    },
    error: function (xhr, status, error) {
      console.error("Error al obtener los datos:", error);
    },
  });
}
