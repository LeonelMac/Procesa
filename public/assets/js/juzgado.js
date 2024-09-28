document.addEventListener("DOMContentLoaded", function () {
  function verificarJuzgadoDuplicado(juzgado, callback) {
    $.ajax({
      url: "/juzgados/verificar", 
      method: "POST",
      data: {
        juzgados: juzgado,
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

  $("#agregarJuzgadoModal").on("shown.bs.modal", function () {
    let agregarForm = document.getElementById("formAgregarJuzgado");
    if (agregarForm) {
      agregarForm.addEventListener("submit", function (event) {
        let juzgadoInput = document.getElementById("juzgado");
        let distritoInput = document.getElementById("distrito");
        if (juzgadoInput.value.trim() === "") {
          event.preventDefault();
          toastr.error('El campo "Nombre del Juzgado" es obligatorio.');
          return;
        }
        if (
          juzgadoInput.value.trim().length < 3 ||
          juzgadoInput.value.trim().length > 100
        ) {
          event.preventDefault();
          toastr.error(
            "El nombre del juzgado debe tener entre 3 y 100 caracteres."
          );
          return;
        }
        if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(juzgadoInput.value.trim())) {
          event.preventDefault();
          toastr.error(
            "El nombre del juzgado solo debe contener letras y espacios."
          );
          return;
        }
        if (juzgadoInput.value.trim() !== juzgadoInput.value) {
          event.preventDefault();
          toastr.error(
            "El nombre del juzgado no debe tener espacios al inicio o al final."
          );
          return;
        }
        const palabrasProhibidas = ["test", "falso", "prueba"];
        if (
          palabrasProhibidas.some((palabra) =>
            juzgadoInput.value.toLowerCase().includes(palabra)
          )
        ) {
          event.preventDefault();
          toastr.error(
            "El nombre del juzgado contiene palabras no permitidas."
          );
          return;
        }
        if (distritoInput.value === "") {
          event.preventDefault();
          toastr.error('El campo "Seleccionar Distrito" es obligatorio.');
          return;
        }
        event.preventDefault(); 
        verificarJuzgadoDuplicado(juzgadoInput.value.trim(), function (existe) {
          if (existe) {
            toastr.error("Ya existe un juzgado con este nombre.");
          } else {
            toastr.success("Juzgado agregado exitosamente.");
            agregarForm.submit(); 
          }
        });
      });
    }
  });
  document
    .querySelectorAll('form[action*="/juzgados/editar"]')
    .forEach(function (form) {
      form.addEventListener("submit", function (event) {
        let juzgadoInput = form.querySelector('input[name="juzgados"]');
        let distritoInput = form.querySelector('select[name="distrito"]');
        if (juzgadoInput.value.trim() === "") {
          event.preventDefault();
          toastr.error('El campo "Nombre del Juzgado" es obligatorio.');
          return;
        }
        if (
          juzgadoInput.value.trim().length < 3 ||
          juzgadoInput.value.trim().length > 100
        ) {
          event.preventDefault();
          toastr.error(
            "El nombre del juzgado debe tener entre 3 y 100 caracteres."
          );
          return;
        }
        if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(juzgadoInput.value.trim())) {
          event.preventDefault();
          toastr.error(
            "El nombre del juzgado solo debe contener letras y espacios."
          );
          return;
        }
        if (juzgadoInput.value.trim() !== juzgadoInput.value) {
          event.preventDefault();
          toastr.error(
            "El nombre del juzgado no debe tener espacios al inicio o al final."
          );
          return;
        }
        const palabrasProhibidas = ["test", "falso", "prueba"];
        if (
          palabrasProhibidas.some((palabra) =>
            juzgadoInput.value.toLowerCase().includes(palabra)
          )
        ) {
          event.preventDefault();
          toastr.error(
            "El nombre del juzgado contiene palabras no permitidas."
          );
          return;
        }

        if (distritoInput.value === "") {
          event.preventDefault();
          toastr.error('El campo "Seleccionar Distrito" es obligatorio.');
          return;
        }
        event.preventDefault(); 
        verificarJuzgadoDuplicado(juzgadoInput.value.trim(), function (existe) {
          if (existe) {
            toastr.error("Ya existe un juzgado con este nombre.");
          } else {
            toastr.success("Juzgado editado exitosamente.");
            form.submit();
          }
        });
      });
    });
  document
    .querySelectorAll('form[action*="/juzgados/eliminar"]')
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
            toastr.success("Juzgado eliminado exitosamente.");
          }
        });
      });
    });
  $("#agregarJuzgadoModal").on("show.bs.modal", function () {
    $.ajax({
      url: "/juzgados/obtener",
      type: "GET",
      success: function (data) {
        let selectDistrito = $("#distrito");
        selectDistrito.empty(); 
        selectDistrito.append(
          '<option value="">Selecciona un distrito</option>'
        ); // Opción por defecto
        data.forEach(function (distrito) {
          selectDistrito.append(
            '<option value="' +
              distrito.iddistrito +
              '">' +
              distrito.distrito +
              "</option>"
          );
        });
      },
      error: function (xhr, status, error) {
        toastr.error("Error al obtener los distritos.");
      },
    });
  });
});

function cargarDatosJuzgado(idjuzgados) {
  $.ajax({
    url: "/juzgados/obtener/" + idjuzgados,
    type: "GET",
    success: function (data) {
      $("#editar-juzgado-" + idjuzgados).val(data.juzgado.juzgados);
      let selectDistrito = $("#editar-distrito-" + idjuzgados);
      selectDistrito.empty();
      selectDistrito.append('<option value="">Selecciona un distrito</option>');
      data.distritos.forEach(function (distrito) {
        selectDistrito.append(
          '<option value="' +
            distrito.iddistrito +
            '">' +
            distrito.distrito +
            "</option>"
        );
      });
      selectDistrito.val(data.juzgado.distrito.iddistrito);
    },
    error: function (xhr, status, error) {
      toastr.error("Error al obtener los datos del juzgado.");
    },
  });
}
