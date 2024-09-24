document.addEventListener('DOMContentLoaded', function() {
  // Inicializar el calendario
  var calendarEl = document.getElementById('calendar');
  var calendar;

  if (typeof FullCalendar !== 'undefined') {
      // Inicializar el calendario
      calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          selectable: true,
          editable: true,
          events: '/events',  // Asegúrate de que esta ruta esté sirviendo los eventos correctamente
          eventClick: function(info) {
              // Mostrar los detalles del evento en el modal cuando se hace clic en un evento
              var event = info.event;
              document.getElementById('eventTitleInput').value = event.title;
              document.getElementById('eventDetails').value = event.extendedProps.description;
              document.getElementById('eventStart').value = event.start.toISOString().substring(0, 10); // Solo la fecha

              // Si tiene horas de inicio y fin
              if (event.start.getHours()) {
                  document.getElementById('startTime').value = event.start.toTimeString().substring(0, 5);
                  if (event.end) {
                      document.getElementById('endTime').value = event.end.toTimeString().substring(0, 5);
                  }
                  document.getElementById('allDayCheckbox').checked = false;  // Desmarcar "Todo el día"
              } else {
                  document.getElementById('allDayCheckbox').checked = true;  // Marcar "Todo el día"
                  document.getElementById('startTime').value = '';
                  document.getElementById('endTime').value = '';
              }

              toggleTimeInputs();  // Asegurarse de mostrar/ocultar las horas correctamente

              var myModal = new bootstrap.Modal(document.getElementById('interactiveEventModal'));
              myModal.show();
          },
          dateClick: function(info) {
              // Al hacer clic en una fecha, restablecer el formulario y mostrar el modal
              document.getElementById('eventForm').reset();
              document.getElementById('eventStart').value = info.dateStr;  // Establecer la fecha seleccionada
              document.getElementById('startTime').value = '';
              document.getElementById('endTime').value = '';
              document.getElementById('allDayCheckbox').checked = true;  // Marcar "Todo el día" por defecto

              toggleTimeInputs();  // Asegurarse de mostrar/ocultar las horas correctamente

              var myModal = new bootstrap.Modal(document.getElementById('interactiveEventModal'));
              myModal.show();
          }
      });

      calendar.render();  // Renderizar el calendario
  } else {
      console.error('FullCalendar no está disponible.');
  }

  // Escuchar el cambio del checkbox "Todo el día" para habilitar/deshabilitar los campos de hora
  var allDayCheckbox = document.getElementById('allDayCheckbox');
  var startTimeInput = document.getElementById('startTime');
  var endTimeInput = document.getElementById('endTime');
  var timeSelectors = document.getElementById('timeSelectors');

  function toggleTimeInputs() {
      if (allDayCheckbox.checked) {
          startTimeInput.disabled = true;
          endTimeInput.disabled = true;
          timeSelectors.classList.add('d-none');
      } else {
          startTimeInput.disabled = false;
          endTimeInput.disabled = false;
          timeSelectors.classList.remove('d-none');
      }
  }

  allDayCheckbox.addEventListener('change', toggleTimeInputs);
  toggleTimeInputs();  // Ejecutar la función al cargar la página

  // Guardar el evento
  document.getElementById('saveEventBtn').addEventListener('click', function() {
      var title = document.getElementById('eventTitleInput').value;
      var start = document.getElementById('eventStart').value;
      var description = document.getElementById('eventDetails').value;
      var repetition = document.getElementById('repetitionSelect').value;
      var allDay = allDayCheckbox.checked;

      var startTime = startTimeInput.value;
      var endTime = endTimeInput.value;

      if (!allDay && (!startTime || !endTime)) {
          alert('Debe especificar la hora de inicio y fin si no es un evento de todo el día.');
          return;
      }

      if (!allDay && startTime >= endTime) {
          alert('La hora de inicio debe ser anterior a la hora de fin.');
          return;
      }

      if (title) {
          // Configurar CSRF Token
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          // Hacer la solicitud AJAX para guardar el evento
          $.ajax({
              url: '/events',
              type: 'POST',
              data: {
                  title: title,
                  start: start,
                  description: description,
                  all_day: allDay ? 1 : 0,
                  repetition: repetition,
                  start_time: allDay ? null : startTime,
                  end_time: allDay ? null : endTime
              },
              success: function(response) {
                  console.log('Evento guardado correctamente');
                  calendar.refetchEvents(); // Refrescar el calendario

                  var myModal = bootstrap.Modal.getInstance(document.getElementById('interactiveEventModal'));
                  myModal.hide();
              },
              error: function(error) {
                  console.error('Error al guardar el evento:', error);
              }
          });
      } else {
          alert('El título del evento es obligatorio.');
      }
  });
});
