document.addEventListener("DOMContentLoaded", function () {
    // Verificar si el juzgado ya existe
    function verificarJuzgadoDuplicado(juzgado, callback) {
      $.ajax({
        url: "/juzgados/verificar", // Ruta para verificar juzgados duplicados
        method: "POST",
        data: {
          juzgados: juzgado,
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
  
    // Manejar el formulario de agregar juzgado
    $("#agregarJuzgadoModal").on("shown.bs.modal", function () {
      let agregarForm = document.getElementById("formAgregarJuzgado");
      if (agregarForm) {
        agregarForm.addEventListener("submit", function (event) {
          let juzgadoInput = document.getElementById("juzgado");
          let distritoInput = document.getElementById("distrito");
  
          // Validaciones básicas del campo de juzgado
          if (juzgadoInput.value.trim() === "") {
            event.preventDefault();
            toastr.error('El campo "Nombre del Juzgado" es obligatorio.');
            return;
          }
  
          // Validación de longitud mínima y máxima
          if (juzgadoInput.value.trim().length < 3 || juzgadoInput.value.trim().length > 100) {
            event.preventDefault();
            toastr.error('El nombre del juzgado debe tener entre 3 y 100 caracteres.');
            return;
          }
  
          // Validación de solo letras y espacios
          if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(juzgadoInput.value.trim())) {
            event.preventDefault();
            toastr.error('El nombre del juzgado solo debe contener letras y espacios.');
            return;
          }
  
          // Validar que no contenga espacios al inicio o al final
          if (juzgadoInput.value.trim() !== juzgadoInput.value) {
            event.preventDefault();
            toastr.error('El nombre del juzgado no debe tener espacios al inicio o al final.');
            return;
          }
  
          // Prohibición de palabras específicas
          const palabrasProhibidas = ["test", "falso", "prueba"];
          if (palabrasProhibidas.some(palabra => juzgadoInput.value.toLowerCase().includes(palabra))) {
            event.preventDefault();
            toastr.error('El nombre del juzgado contiene palabras no permitidas.');
            return;
          }
  
          if (distritoInput.value === "") {
            event.preventDefault();
            toastr.error('El campo "Seleccionar Distrito" es obligatorio.');
            return;
          }
  
          event.preventDefault(); // Prevenir el envío por defecto
  
          // Verificar si el juzgado ya existe
          verificarJuzgadoDuplicado(juzgadoInput.value.trim(), function (existe) {
            if (existe) {
              toastr.error("Ya existe un juzgado con este nombre.");
            } else {
              toastr.success("Juzgado agregado exitosamente.");
              agregarForm.submit(); // Enviar el formulario
            }
          });
        });
      }
    });
  
    // Manejar el formulario de editar juzgado
    document
      .querySelectorAll('form[action*="/juzgados/editar"]')
      .forEach(function (form) {
        form.addEventListener("submit", function (event) {
          let juzgadoInput = form.querySelector('input[name="juzgados"]');
          let distritoInput = form.querySelector('select[name="distrito"]');
  
          // Validaciones básicas del campo de juzgado
          if (juzgadoInput.value.trim() === "") {
            event.preventDefault();
            toastr.error('El campo "Nombre del Juzgado" es obligatorio.');
            return;
          }
  
          // Validación de longitud mínima y máxima
          if (juzgadoInput.value.trim().length < 3 || juzgadoInput.value.trim().length > 100) {
            event.preventDefault();
            toastr.error('El nombre del juzgado debe tener entre 3 y 100 caracteres.');
            return;
          }
  
          // Validación de solo letras y espacios
          if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(juzgadoInput.value.trim())) {
            event.preventDefault();
            toastr.error('El nombre del juzgado solo debe contener letras y espacios.');
            return;
          }
  
          // Validar que no contenga espacios al inicio o al final
          if (juzgadoInput.value.trim() !== juzgadoInput.value) {
            event.preventDefault();
            toastr.error('El nombre del juzgado no debe tener espacios al inicio o al final.');
            return;
          }
  
          // Prohibición de palabras específicas
          const palabrasProhibidas = ["test", "falso", "prueba"];
          if (palabrasProhibidas.some(palabra => juzgadoInput.value.toLowerCase().includes(palabra))) {
            event.preventDefault();
            toastr.error('El nombre del juzgado contiene palabras no permitidas.');
            return;
          }
  
          if (distritoInput.value === "") {
            event.preventDefault();
            toastr.error('El campo "Seleccionar Distrito" es obligatorio.');
            return;
          }
  
          event.preventDefault(); // Prevenir envío inmediato
  
          // Verificar si el juzgado ya existe
          verificarJuzgadoDuplicado(juzgadoInput.value.trim(), function (existe) {
            if (existe) {
              toastr.error("Ya existe un juzgado con este nombre.");
            } else {
              toastr.success("Juzgado editado exitosamente.");
              form.submit(); // Enviar el formulario
            }
          });
        });
      });
  
    // Confirmar eliminación de juzgado con SweetAlert
    document
      .querySelectorAll('form[action*="/juzgados/eliminar"]')
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
              toastr.success("Juzgado eliminado exitosamente.");
            }
          });
        });
      });
  
    // Cargar distritos cuando se abre el modal de agregar juzgado
    $("#agregarJuzgadoModal").on("show.bs.modal", function () {
      $.ajax({
        url: "/juzgados/obtener",
        type: "GET",
        success: function (data) {
          let selectDistrito = $("#distrito");
          selectDistrito.empty(); // Limpiar el select antes de llenarlo
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
  
  // Función para cargar los datos del juzgado al abrir el modal de edición
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
  