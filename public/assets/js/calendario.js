document.addEventListener("DOMContentLoaded", function () {
  var calendarEl = document.getElementById("calendar");
  var calendar;

  if (typeof FullCalendar !== "undefined") {
      calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: "dayGridMonth",
          selectable: true,
          editable: true,
          events: "/events", // Ruta para obtener los eventos

          eventClick: function (info) {
            var event = info.event;
        
            // Almacenar el evento en la variable global `selectedEvent`
            selectedEvent = event;
        
            // Guardar el ID del evento en el campo oculto para su posterior uso
            document.getElementById("eventId").value = event.id;
        
            // Llenar los campos del modal de visualización
            document.getElementById("viewEventTitle").textContent = event.title;
            document.getElementById("viewEventDetails").textContent = event.extendedProps.description;
        
            // Formatear la fecha y hora (lo demás no se modifica)
            var startDate = new Date(event.start);
            var endDate = event.end ? new Date(event.end) : null;
            var options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
        
            if (event.allDay) {
                document.getElementById("viewEventTime").textContent = startDate.toLocaleDateString('es-ES', { year: 'numeric', month: 'long', day: 'numeric' }) + ' (Todo el día)';
            } else {
                var formattedStart = startDate.toLocaleDateString('es-ES', options);
                var formattedEnd = endDate ? endDate.toLocaleDateString('es-ES', options) : '';
                document.getElementById("viewEventTime").textContent = formattedStart + (formattedEnd ? ' - ' + formattedEnd : '');
            }
        
            // Mostrar la repetición
            var repetitionType = event.extendedProps.repetition_type || 'none';
            switch (repetitionType) {
                case 'monthly':
                    document.getElementById("viewRepetition").textContent = 'Cada mes';
                    break;
                case 'weekdays':
                    document.getElementById("viewRepetition").textContent = 'De lunes a viernes';
                    break;
                default:
                    document.getElementById("viewRepetition").textContent = 'No hay repetición';
                    break;
            }
        
            // Mostrar el modal de visualización
            var viewModal = new bootstrap.Modal(document.getElementById("viewEventModal"));
            viewModal.show();
        }
          ,        

          dateClick: function (info) {
              // Restablecer el formulario y mostrar el modal para crear un nuevo evento
              document.getElementById("eventForm").reset();
              document.getElementById("eventStart").value = info.dateStr; // Establecer la fecha seleccionada
              document.getElementById("startTime").value = "";
              document.getElementById("endTime").value = "";
              document.getElementById("allDayCheckbox").checked = true; // Marcar "Todo el día" por defecto
              document.getElementById("eventId").value = ""; // Asegurarse de que no haya un ID en caso de un nuevo evento

              toggleTimeInputs(); // Asegurarse de mostrar/ocultar las horas correctamente

              var myModal = new bootstrap.Modal(
                  document.getElementById("interactiveEventModal")
              );
              myModal.show();
          },
      });

      calendar.render();
  } else {
      console.error("FullCalendar no está disponible.");
  }

  // Configurar el token CSRF globalmente para todas las solicitudes AJAX
  $.ajaxSetup({
      headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
  });

  // Función para alternar la visibilidad de los campos de hora según si es "Todo el día"
  function toggleTimeInputs() {
      var allDayCheckbox = document.getElementById("allDayCheckbox");
      var startTimeInput = document.getElementById("startTime");
      var endTimeInput = document.getElementById("endTime");
      var timeSelectors = document.getElementById("timeSelectors");

      if (allDayCheckbox.checked) {
          startTimeInput.disabled = true;
          endTimeInput.disabled = true;
          timeSelectors.classList.add("d-none");
      } else {
          startTimeInput.disabled = false;
          endTimeInput.disabled = false;
          timeSelectors.classList.remove("d-none");
      }
  }

  document
      .getElementById("allDayCheckbox")
      .addEventListener("change", toggleTimeInputs);
  toggleTimeInputs(); // Ejecutar la función al cargar la página

  // Inicializar Flatpickr para los campos de tiempo
  flatpickr("#startTime", {
      enableTime: true,
      noCalendar: true,
      dateFormat: "H:i", // Formato de 24 horas
      time_24hr: true
  });

  flatpickr("#endTime", {
      enableTime: true,
      noCalendar: true,
      dateFormat: "H:i", // Formato de 24 horas
      time_24hr: true
  });

  // Botón para "Guardar" el evento (nuevo o editado)
  document.getElementById("saveEventBtn").addEventListener("click", function () {
    var title = document.getElementById("eventTitleInput").value;
    var startDate = document.getElementById("eventStart").value; // Solo la fecha (Y-m-d)
    var description = document.getElementById("eventDetails").value;
    var allDay = document.getElementById("allDayCheckbox").checked;
    var repetition = document.getElementById("repetitionSelect").value; // Obtener el valor de la repetición

    var startTime = document.getElementById("startTime").value;
    var endTime = document.getElementById("endTime").value;

    // Validación de campos obligatorios con Toastr
    if (!title) {
        toastr.error("El título del evento es obligatorio.");
        return;
    }
    if (!startDate) {
        toastr.error("La fecha de inicio es obligatoria.");
        return;
    }
    if (!description) {
        toastr.error("La descripción es obligatoria.");
        return;
    }
    if (!allDay && (!startTime || !endTime)) {
        toastr.error(
            "Debe especificar la hora de inicio y fin si no es un evento de todo el día."
        );
        return;
    }
    if (!allDay && startTime >= endTime) {
        toastr.error(
            "La hora de inicio debe ser menor a la hora de fin."
        );
        return;
    }

    // Si todas las validaciones pasan, hacer la solicitud AJAX
    var eventId = document.getElementById("eventId").value; // Si hay un ID, es una edición
    var ajaxUrl = eventId ? "/events/" + eventId : "/events";
    var ajaxType = eventId ? "PUT" : "POST";

    // Aquí aseguramos que start solo tenga la fecha (Y-m-d)
    $.ajax({
        url: ajaxUrl,
        type: ajaxType,
        data: {
            title: title,
            start: startDate,  // Solo la fecha, no incluir la hora
            description: description,
            all_day: allDay ? 1 : 0,
            repetition_type: repetition, // Asegúrate de enviar el valor de repetición
            start_time: allDay ? null : startTime,  // Enviar la hora aparte
            end_time: allDay ? null : endTime,      // Enviar la hora aparte
        },
        success: function (response) {
            calendar.refetchEvents(); // Refrescar el calendario
            toastr.success("Evento guardado correctamente.");
            var myModal = bootstrap.Modal.getInstance(
                document.getElementById("interactiveEventModal")
            );
            myModal.hide();
        },
        error: function (xhr, status, error) {
            toastr.error("Error al guardar el evento.");
            console.error(
                "Error al guardar el evento:",
                xhr.responseText
            );

            // Para mayor depuración, puedes mostrar el mensaje de error que retorna Laravel
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                console.log(
                    "Errores de validación:",
                    xhr.responseJSON.errors
                );
            }
        },
    });
});

  // Al hacer clic en "Editar" dentro del modal de visualización, abrir el modal de edición
  var selectedEvent = null; // Variable global para almacenar el evento seleccionado

  document.getElementById("editEventBtn").addEventListener("click", function () {
      if (!selectedEvent) {
          console.error("No se ha seleccionado ningún evento.");
          return;
      }
  
      // Obtener los datos del evento actual desde la variable global `selectedEvent`
      var title = selectedEvent.title;
      var description = selectedEvent.extendedProps.description;
      var allDay = selectedEvent.allDay;
      var repetitionType = selectedEvent.extendedProps.repetition_type;
  
      // Cargar los datos en el modal de edición
      document.getElementById("eventTitleInput").value = title;
      document.getElementById("eventDetails").value = description;
      document.getElementById("eventStart").value = selectedEvent.start.toISOString().substring(0, 10); // Solo la fecha
  
      // Verificar si es "Todo el día" o no
      if (allDay) {
          document.getElementById("allDayCheckbox").checked = true;
          document.getElementById("startTime").value = '';
          document.getElementById("endTime").value = '';
          document.getElementById("startTime").disabled = true;
          document.getElementById("endTime").disabled = true;
          document.getElementById("timeSelectors").classList.add('d-none');
      } else {
          document.getElementById("allDayCheckbox").checked = false;
          document.getElementById("startTime").disabled = false;
          document.getElementById("endTime").disabled = false;
          document.getElementById("timeSelectors").classList.remove('d-none');
  
          // Cargar la hora de inicio y fin
          document.getElementById("startTime").value = selectedEvent.start.toTimeString().substring(0, 5); // Hora de inicio
          if (selectedEvent.end) {
              document.getElementById("endTime").value = selectedEvent.end.toTimeString().substring(0, 5); // Hora de fin
          }
      }
  
      // Manejar la repetición
      switch (repetitionType) {
          case 'monthly':
              document.getElementById("repetitionSelect").value = 'monthly';
              break;
          case 'weekdays':
              document.getElementById("repetitionSelect").value = 'weekdays';
              break;
          default:
              document.getElementById("repetitionSelect").value = 'none';
              break;
      }
  
      // Cerrar el modal de visualización y abrir el modal de edición
      var viewModal = bootstrap.Modal.getInstance(document.getElementById("viewEventModal"));
      viewModal.hide();
  
      var editModal = new bootstrap.Modal(document.getElementById("interactiveEventModal"));
      editModal.show();
  });
  

  // Eliminar el evento con confirmación usando SweetAlert
  document
      .getElementById("deleteEventBtn")
      .addEventListener("click", function () {
          var eventId = document.getElementById("eventId").value; // Obtener el ID del evento

          if (!eventId) {
              toastr.error("El evento no tiene un ID válido para eliminar.");
              return;
          }

          // Verificar si el evento tiene una repetición asociada
          $.ajax({
              url: "/events/check-repetition/" + eventId,
              type: "GET",
              success: function (response) {
                  console.log(
                      "Repetición detectada: ",
                      response.hasRepetition
                  );
                  if (response.hasRepetition) {
                      // Si el evento tiene una repetición, mostrar el modal con la opción de eliminar todos o solo este
                      Swal.fire({
                          title: "¿Qué deseas eliminar?",
                          text: "¿Quieres eliminar solo este evento o todos los eventos relacionados?",
                          icon: "warning",
                          showCancelButton: true,
                          showDenyButton: true,
                          confirmButtonText: "Solo este evento",
                          denyButtonText: "Todos los eventos",
                          cancelButtonText: "Cancelar",
                          confirmButtonColor: "#3085d6",
                          denyButtonColor: "#d33",
                          cancelButtonColor: "#999",
                      }).then((result) => {
                          if (result.isConfirmed) {
                              // Eliminar solo este evento
                              eliminarEvento(eventId, false);
                          } else if (result.isDenied) {
                              // Eliminar todos los eventos relacionados
                              eliminarEvento(eventId, true);
                          }
                      });
                  } else {
                      // Si no tiene repetición, eliminar el evento directamente
                      Swal.fire({
                          title: "¿Estás seguro?",
                          text: "Esta acción no se puede deshacer.",
                          icon: "warning",
                          showCancelButton: true,
                          confirmButtonColor: "#3085d6",
                          cancelButtonColor: "#d33",
                          confirmButtonText: "Sí, eliminarlo",
                      }).then((result) => {
                          if (result.isConfirmed) {
                              eliminarEvento(eventId, false);
                          }
                      });
                  }
              },
              error: function (error) {
                  toastr.error(
                      "Error al verificar la repetición del evento."
                  );
                  console.error(
                      "Error al verificar la repetición del evento:",
                      error
                  );
              },
          });
      });

  // Función para eliminar evento
  function eliminarEvento(eventId, eliminarTodos) {
      $.ajax({
          url: "/events/" + eventId,
          type: "DELETE",
          data: { eliminar_todos: eliminarTodos }, // Enviar la información de si se eliminan todos
          success: function (response) {
              calendar.refetchEvents(); // Refrescar el calendario
              Swal.fire(
                  "Eliminado",
                  "El evento ha sido eliminado correctamente.",
                  "success"
              );
              var viewModal = bootstrap.Modal.getInstance(
                  document.getElementById("viewEventModal")
              );
              viewModal.hide(); // Cerrar el modal
          },
          error: function (error) {
              Swal.fire(
                  "Error",
                  "Hubo un error al eliminar el evento.",
                  "error"
              );
              console.error("Error al eliminar el evento:", error);
          },
      });
  }
});
