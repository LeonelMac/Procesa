    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');

        if (calendarEl) {
            var today = new Date();
            today.setHours(0, 0, 0, 0); // Asegura que el día actual no tenga problemas con zonas horarias

            // Fechas importantes o festivos
            var importantDates = [
                {
                    date: '2024-12-25',
                    title: 'Navidad',
                    className: 'bg-warning text-dark'
                },
                {
                    date: '2024-09-16',
                    title: 'Independencia de México',
                    className: 'bg-danger text-white'
                }
            ];

            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'es',
                initialView: 'dayGridMonth',
                editable: true,
                selectable: true,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día'
                },
                titleFormat: {
                    year: 'numeric',
                    month: 'long'
                },
                themeSystem: 'standard',

                // Modificar estilo para fechas anteriores a hoy, pero dejarlas visibles
                dayCellClassNames: function (info) {
                    var date = new Date(info.date);
                    if (date < today) {
                        return ['fc-day-past']; // Añadir una clase para días anteriores
                    }
                },

                // Deshabilitar selección de fechas anteriores pero mostrarlas opacas
                selectAllow: function (selectInfo) {
                    return selectInfo.start >= today; // No permitir selección de fechas pasadas
                },

                // Añadir las fechas importantes o festivos y eventos del servidor
                events: function (fetchInfo, successCallback, failureCallback) {
                    // Cargar eventos del servidor (base de datos)
                    $.ajax({
                        url: '/events',
                        method: 'GET',
                        success: function (serverEvents) {
                            // Añadir eventos importantes
                            let importantEvents = importantDates.map(dateObj => ({
                                title: dateObj.title,
                                start: dateObj.date,
                                allDay: true,
                                className: dateObj.className
                            }));

                            // Combinar eventos del servidor y fechas importantes
                            let allEvents = serverEvents.concat(importantEvents);

                            successCallback(allEvents);
                        },
                        error: function (xhr) {
                            console.log('Error al cargar eventos del servidor:', xhr.responseText);
                            failureCallback(xhr);
                        }
                    });
                },

                select: function (info) {
                    if (info.start < today) {
                        alert('No puedes crear eventos en días anteriores.');
                        return;
                    }
                    $('#eventForm')[0].reset();
                    $('#eventId').val('');
                    $('#eventStart').val(info.startStr);
                    $('#eventEnd').val(info.endStr);
                    $('#eventInfo').addClass('d-none');
                    $('#eventForm').removeClass('d-none');

                    // Abrir el modal de agregar evento
                    $('#interactiveEventModal').modal('show');
                    $('#interactiveEventModalLabel').html('<i class="fas fa-plus-circle"></i> Agregar Evento');

                    // Mostrar opciones de repetición y todo el día
                    $('#repetitionOptions').removeClass('d-none');
                    $('#allDayCheckbox').prop('checked', true); // Por defecto, todo el día

                    // Mostrar u ocultar el selector de horas según si es todo el día o no
                    $('#allDayCheckbox').change(function () {
                        if ($(this).is(':checked')) {
                            $('#timeSelectors').addClass('d-none'); // Ocultar selección de horas
                        } else {
                            $('#timeSelectors').removeClass('d-none'); // Mostrar selección de horas
                        }
                    });

                    $('#saveEventBtn').off('click').on('click', function () {
                        var newEvent = {
                            title: $('#eventTitleInput').val(),
                            all_day: $('#allDayCheckbox').is(':checked'),
                            repeat: $('#repetitionSelect').val() // Repetición seleccionada
                        };

                        // Validar que las fechas de inicio y fin sean válidas antes de convertirlas
                        var startDate = $('#eventStart').val();
                        var endDate = $('#eventEnd').val();

                        if (!startDate || !endDate) {
                            alert('Las fechas de inicio y fin son obligatorias.');
                            return;
                        }

                        // Convertir las fechas en el formato correcto
                        newEvent.start = new Date(startDate).toISOString().slice(0, 19).replace('T', ' ');
                        newEvent.end = new Date(endDate).toISOString().slice(0, 19).replace('T', ' ');

                        // Agregar hora de inicio y fin si no es un evento de todo el día
                        if (!newEvent.all_day) {
                            newEvent.start += ' ' + $('#startTime').val();
                            newEvent.end += ' ' + $('#endTime').val();
                        }

                        // Lógica para repetición de eventos
                        let events = [];
                        if (newEvent.repeat === 'daily') {
                            for (let d = new Date(newEvent.start); d <= new Date(newEvent.end); d.setDate(d.getDate() + 1)) {
                                events.push({
                                    title: newEvent.title,
                                    start: new Date(d),
                                    allDay: newEvent.all_day
                                });
                            }
                        } else if (newEvent.repeat === 'weekdays') {
                            for (let d = new Date(newEvent.start); d <= new Date(newEvent.end); d.setDate(d.getDate() + 1)) {
                                if (d.getDay() !== 0 && d.getDay() !== 6) { // Solo lunes a viernes
                                    events.push({
                                        title: newEvent.title,
                                        start: new Date(d),
                                        allDay: newEvent.all_day
                                    });
                                }
                            }
                        } else {
                            events.push(newEvent); // No repetir
                        }

                        // Enviar eventos creados al servidor
                        $.ajax({
                            url: '/events',
                            method: 'POST',
                            contentType: 'application/json',
                            data: JSON.stringify(events),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                response.forEach(function (event) {
                                    calendar.addEvent(event); // Añadir eventos al calendario
                                });
                                $('#interactiveEventModal').modal('hide');
                                alert('Evento creado con éxito');
                            },
                            error: function (xhr) {
                                console.log(xhr.responseText);
                                alert('Hubo un error al crear el evento');
                            }
                        });
                    });
                },

                // Clic en evento para ver detalles, editar o eliminar
                eventClick: function (info) {
                    $('#eventTitle').text(info.event.title);
                    $('#eventDateTime').text(info.event.start.toLocaleDateString('es-ES') + ' - ' +
                        (info.event.end ? info.event.end.toLocaleDateString('es-ES') : ''));
                    $('#eventDetails').text(info.event.extendedProps.details || 'Sin detalles adicionales');
                    $('#eventId').val(info.event.id);
                    $('#eventInfo').removeClass('d-none');
                    $('#eventForm').addClass('d-none');

                    // Abrir el modal de detalles del evento
                    $('#interactiveEventModal').modal('show');
                    $('#interactiveEventModalLabel').html('<i class="fas fa-calendar-alt"></i> Detalles del Evento');

                    // Editar evento
                    $('#editEventBtn').off('click').on('click', function () {
                        $('#eventForm').removeClass('d-none');
                        $('#eventInfo').addClass('d-none');
                        $('#eventTitleInput').val(info.event.title);
                    });

                    // Eliminar evento
                    $('#deleteEventBtn').off('click').on('click', function () {
                        if (confirm('¿Estás seguro de que deseas eliminar este evento?')) {
                            $.ajax({
                                url: '/events/' + info.event.id,
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function (response) {
                                    info.event.remove();
                                    $('#interactiveEventModal').modal('hide');
                                    alert('Evento eliminado con éxito');
                                },
                                error: function (xhr) {
                                    console.log(xhr.responseText);
                                    alert('Hubo un error al eliminar el evento');
                                }
                            });
                        }
                    });

                    // Guardar cambios en evento
                    $('#saveEventBtn').off('click').on('click', function () {
                        var updatedEvent = {
                            title: $('#eventTitleInput').val(),
                            all_day: true
                        };

                        // Validar que las fechas de inicio y fin sean válidas antes de convertirlas
                        var startDate = info.event.startStr;
                        var endDate = info.event.endStr;

                        if (!startDate || !endDate) {
                            alert('Las fechas de inicio y fin son obligatorias.');
                            return;
                        }

                        updatedEvent.start = startDate.slice(0, 19).replace('T', ' ');
                        updatedEvent.end = endDate.slice(0, 19).replace('T', ' ');

                        $.ajax({
                            url: '/events/' + info.event.id,
                            method: 'PUT',
                            contentType: 'application/json',
                            data: JSON.stringify(updatedEvent),
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                info.event.setProp('title', updatedEvent.title);
                                $('#interactiveEventModal').modal('hide');
                                alert('Evento actualizado con éxito');
                            },
                            error: function (xhr) {
                                console.log(xhr.responseText);
                                alert('Hubo un error al actualizar el evento');
                            }
                        });
                    });
                }
            });

            calendar.render();
        }
    });
