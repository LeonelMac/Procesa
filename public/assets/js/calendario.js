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

                // Llenar los campos del modal de visualización
                document.getElementById("viewEventTitle").textContent =
                    event.title;
                document.getElementById("viewEventDetails").textContent =
                    event.extendedProps.description;
                document.getElementById("viewEventTime").textContent =
                    event.start.toISOString().substring(0, 16); // Fecha y hora
                document.getElementById("viewRepetition").textContent =
                    event.extendedProps.repetition || "Ninguna";

                // Guardar el ID del evento en el campo oculto
                document.getElementById("eventId").value = event.id;

                // Mostrar el modal de visualización
                var viewModal = new bootstrap.Modal(
                    document.getElementById("viewEventModal")
                );
                viewModal.show();
            },
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

    // Botón para "Guardar" el evento (nuevo o editado)
    document
        .getElementById("saveEventBtn")
        .addEventListener("click", function () {
            var title = document.getElementById("eventTitleInput").value;
            var start = document.getElementById("eventStart").value;
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
            if (!start) {
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

            $.ajax({
                url: ajaxUrl,
                type: ajaxType,
                data: {
                    title: title,
                    start: start,
                    description: description,
                    all_day: allDay ? 1 : 0,
                    repetition: repetition, // Asegurarse de enviar el valor de repetición
                    start_time: allDay ? null : startTime,
                    end_time: allDay ? null : endTime,
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
    document
        .getElementById("editEventBtn")
        .addEventListener("click", function () {
            // Obtener los datos del evento actual y pasarlos al modal de edición
            var title = document.getElementById("viewEventTitle").textContent;
            var description =
                document.getElementById("viewEventDetails").textContent;
            var startTime =
                document.getElementById("viewEventTime").textContent;

            document.getElementById("eventTitleInput").value = title;
            document.getElementById("eventDetails").value = description;
            document.getElementById("eventStart").value = startTime;
            document.getElementById("eventId").value =
                document.getElementById("eventId").value; // Mantener el ID del evento

            toggleTimeInputs();

            // Cerrar el modal de visualización y abrir el modal de edición
            var viewModal = bootstrap.Modal.getInstance(
                document.getElementById("viewEventModal")
            );
            viewModal.hide();

            var editModal = new bootstrap.Modal(
                document.getElementById("interactiveEventModal")
            );
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

            // Usar SweetAlert para confirmación antes de eliminar
            Swal.fire({
                title: "¿Estás seguro?",
                text: "¡No podrás revertir esta acción!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, eliminarlo",
            }).then((result) => {
                if (result.isConfirmed) {
                    // Confirmación aprobada, enviar la solicitud AJAX para eliminar
                    $.ajax({
                        url: "/events/" + eventId,
                        type: "DELETE",
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
                            console.error(
                                "Error al eliminar el evento:",
                                error
                            );
                        },
                    });
                }
            });
        });
});
