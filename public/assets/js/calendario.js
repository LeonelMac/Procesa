document.addEventListener("DOMContentLoaded", function () {
    var calendarEl = document.getElementById("calendar");
    var calendar;
    var selectedEvent = null;
    var previousEventCount = null;
    var previousGeneralEventCount = null;
    var today = new Date();
    today.setHours(0, 0, 0, 0);
    var holidays = [
        {
            title: "Año Nuevo",
            start: "2024-01-01",
            allDay: true,
            color: "#FF0000",
        },
        {
            title: "Día de la Constitución",
            start: "2024-02-05",
            allDay: true,
            color: "#FF0000",
        },
        {
            title: "Natalicio de Benito Juárez",
            start: "2024-03-18",
            allDay: true,
            color: "#FF0000",
        },
        {
            title: "Día del Trabajo",
            start: "2024-05-01",
            allDay: true,
            color: "#FF0000",
        },
        {
            title: "Día de la Independencia",
            start: "2024-09-15",
            allDay: true,
            color: "#FF0000",
        },
        {
            title: "Día de la Revolución",
            start: "2024-11-20",
            allDay: true,
            color: "#FF0000",
        },
        {
            title: "Navidad",
            start: "2024-12-25",
            allDay: true,
            color: "#FF0000",
        },
        {
            title: "Año Nuevo",
            start: "2025-01-01",
            allDay: true,
            color: "#FF0000",
        },
    ];

    if (typeof FullCalendar !== "undefined") {
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: "dayGridMonth",
            selectable: true,
            editable: true,
            locale: "es",
            dayCellDidMount: function (info) {
                var cellDate = info.date;
                cellDate.setHours(0, 0, 0, 0);
                if (cellDate < today) {
                    info.el.style.backgroundImage =
                        "linear-gradient(45deg, rgba(0, 123, 255, 0.1) 25%, transparent 25%, transparent 50%, rgba(0, 123, 255, 0.1) 50%, rgba(0, 123, 255, 0.1) 75%, transparent 75%, transparent)";
                    info.el.style.backgroundSize = "8px 8px";
                    info.el.style.pointerEvents = "none";
                    info.el.style.opacity = "0.8";
                }
            },
            eventSources: [
                {
                    url: "/events",
                    method: "GET",
                    failure: function () {
                        alert("Error al cargar los eventos!");
                    },
                },
                {
                    events: holidays,
                },
            ],
            headerToolbar: {
                left: "prev,today,next",
                center: "title",
                right: "dayGridMonth",
            },
            titleFormat: {
                year: "numeric",
                month: "long",
            },
            buttonText: {
                today: "Hoy",
                month: "Mes",
            },
            eventClassNames: function (arg) {
                let className = "";
                if (arg.event.extendedProps.allDay === 1) {
                } else {
                    switch (arg.event.extendedProps.repetition_type) {
                        case "monthly":
                            className = "event-monthly";
                            break;
                        case "weekdays":
                            className = "event-weekdays";
                            break;
                        case "none":
                            className = "event-none";
                            break;
                        default:
                            className = "";
                            break;
                    }
                }
                return className;
            },
            eventClick: function (info) {
                var event = info.event;
                selectedEvent = event;
                document.getElementById("eventId").value = event.id;
                document.getElementById("viewEventTitle").textContent =
                    event.title;
                document.getElementById("viewEventDetails").textContent =
                    event.extendedProps.description;
                var startDate = new Date(event.start);
                var endDate = event.end ? new Date(event.end) : null;
                var options = {
                    year: "numeric",
                    month: "long",
                    day: "numeric",
                    hour: "2-digit",
                    minute: "2-digit",
                };
                if (event.allDay) {
                    document.getElementById("viewEventTime").textContent =
                        startDate.toLocaleDateString("es-ES", {
                            year: "numeric",
                            month: "long",
                            day: "numeric",
                        }) + " (Todo el día)";
                } else {
                    var formattedStart = startDate.toLocaleDateString(
                        "es-ES",
                        options
                    );
                    var formattedEnd = endDate
                        ? endDate.toLocaleDateString("es-ES", options)
                        : "";
                    document.getElementById("viewEventTime").textContent =
                        formattedStart +
                        (formattedEnd ? " - " + formattedEnd : "");
                }
                var repetitionType =
                    event.extendedProps.repetition_type || "none";
                switch (repetitionType) {
                    case "monthly":
                        document.getElementById("viewRepetition").textContent =
                            "Cada mes";
                        break;
                    case "weekdays":
                        document.getElementById("viewRepetition").textContent =
                            "De lunes a viernes";
                        break;
                    default:
                        document.getElementById("viewRepetition").textContent =
                            "No hay repetición";
                        break;
                }
                var viewModal = new bootstrap.Modal(
                    document.getElementById("viewEventModal")
                );
                viewModal.show();
            },
            dateClick: function (info) {
                var clickedDate = info.date;
                clickedDate.setHours(0, 0, 0, 0);
                if (clickedDate < today) {
                } else {
                    document.getElementById("eventForm").reset();
                    document.getElementById("eventStart").value = info.dateStr;
                    document.getElementById("startTime").value = "";
                    document.getElementById("endTime").value = "";
                    document.getElementById("allDayCheckbox").checked = true;
                    document.getElementById("eventId").value = "";
                    toggleTimeInputs();
                    var myModal = new bootstrap.Modal(
                        document.getElementById("interactiveEventModal")
                    );
                    myModal.show();
                }
            },
        });
        calendar.render();
    } else {
        console.error("FullCalendar no está disponible.");
    }
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
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
    function updateEventCount() {
        $.ajax({
            url: "/events/today/count",
            type: "GET",
            success: function (response) {
                document.getElementById("eventCount").textContent =
                    response.count;
                if (
                    previousEventCount === null ||
                    response.count !== previousEventCount
                ) {
                    if (response.count === 0) {
                        toastr.info(
                            "No tienes ninguna notificación el día de hoy."
                        );
                    } else if (response.count === 1) {
                        toastr.info("Tienes 1 notificación el día de hoy.");
                    } else {
                        toastr.info(
                            "Tienes " +
                                response.count +
                                " notificaciones el día de hoy."
                        );
                    }
                }
                previousEventCount = response.count;
            },
            error: function (error) {
                console.error(
                    "Error al obtener el conteo de eventos de hoy:",
                    error
                );
            },
        });
    }
    function updateGeneralEventCount() {
        $.ajax({
            url: "/events/upcoming/count",
            type: "GET",
            success: function (response) {
                document.getElementById("generalEventCount").textContent =
                    response.count;
                if (
                    previousGeneralEventCount === null ||
                    response.count !== previousGeneralEventCount
                ) {
                    if (response.count === 0) {
                        toastr.info("No tienes notificaciones generales.");
                    } else if (response.count === 1) {
                        toastr.info("Tienes 1 notificación general.");
                    } else {
                        toastr.info(
                            "Tienes " +
                                response.count +
                                " notificaciones generales."
                        );
                    }
                }
                previousGeneralEventCount = response.count;
            },
            error: function (error) {
                console.error(
                    "Error al obtener el conteo de eventos generales:",
                    error
                );
            },
        });
    }
    updateEventCount();
    updateGeneralEventCount();
    setInterval(updateEventCount, 1000);
    setInterval(updateGeneralEventCount, 1000);
    document
        .getElementById("allDayCheckbox")
        .addEventListener("change", toggleTimeInputs);
    toggleTimeInputs();
    flatpickr("#startTime", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
    });
    flatpickr("#endTime", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
    });
    document
        .getElementById("saveEventBtn")
        .addEventListener("click", function () {
            var title = document.getElementById("eventTitleInput").value;
            var startDate = document.getElementById("eventStart").value;
            var description = document.getElementById("eventDetails").value;
            var allDay = document.getElementById("allDayCheckbox").checked;
            var repetition = document.getElementById("repetitionSelect").value;
            var startTime = document.getElementById("startTime").value;
            var endTime = document.getElementById("endTime").value;
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
            var eventId = document.getElementById("eventId").value;
            var ajaxUrl = eventId ? "/events/" + eventId : "/events";
            var ajaxType = eventId ? "PUT" : "POST";
            $.ajax({
                url: ajaxUrl,
                type: ajaxType,
                data: {
                    title: title,
                    start: startDate,
                    description: description,
                    all_day: allDay ? 1 : 0,
                    repetition_type: repetition,
                    start_time: allDay ? null : startTime,
                    end_time: allDay ? null : endTime,
                },
                success: function (response) {
                    calendar.refetchEvents();
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

                    if (xhr.responseJSON && xhr.responseJSON.errors) {

                    }
                },
            });
        });
    document
        .getElementById("editEventBtn")
        .addEventListener("click", function () {
            if (!selectedEvent) {
                console.error("No se ha seleccionado ningún evento.");
                return;
            }
            var title = selectedEvent.title;
            var description = selectedEvent.extendedProps.description;
            var allDay = selectedEvent.allDay;
            var repetitionType = selectedEvent.extendedProps.repetition_type;
            document.getElementById("eventTitleInput").value = title;
            document.getElementById("eventDetails").value = description;
            document.getElementById("eventStart").value = selectedEvent.start
                .toISOString()
                .substring(0, 10);
            if (allDay) {
                document.getElementById("allDayCheckbox").checked = true;
                document.getElementById("startTime").value = "";
                document.getElementById("endTime").value = "";
                document.getElementById("startTime").disabled = true;
                document.getElementById("endTime").disabled = true;
                document
                    .getElementById("timeSelectors")
                    .classList.add("d-none");
            } else {
                document.getElementById("allDayCheckbox").checked = false;
                document.getElementById("startTime").disabled = false;
                document.getElementById("endTime").disabled = false;
                document
                    .getElementById("timeSelectors")
                    .classList.remove("d-none");
                document.getElementById("startTime").value = selectedEvent.start
                    .toTimeString()
                    .substring(0, 5);
                if (selectedEvent.end) {
                    document.getElementById("endTime").value = selectedEvent.end
                        .toTimeString()
                        .substring(0, 5);
                }
            }
            switch (repetitionType) {
                case "monthly":
                    document.getElementById("repetitionSelect").value =
                        "monthly";
                    break;
                case "weekdays":
                    document.getElementById("repetitionSelect").value =
                        "weekdays";
                    break;
                default:
                    document.getElementById("repetitionSelect").value = "none";
                    break;
            }
            var viewModal = bootstrap.Modal.getInstance(
                document.getElementById("viewEventModal")
            );
            viewModal.hide();
            var editModal = new bootstrap.Modal(
                document.getElementById("interactiveEventModal")
            );
            editModal.show();
        });
    document
        .getElementById("deleteEventBtn")
        .addEventListener("click", function () {
            var eventId = document.getElementById("eventId").value;

            if (!eventId) {
                toastr.error("El evento no tiene un ID válido para eliminar.");
                return;
            }
            $.ajax({
                url: "/events/check-repetition/" + eventId,
                type: "GET",
                success: function (response) {
                    if (response.hasRepetition) {
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
                                eliminarEvento(eventId, false);
                            } else if (result.isDenied) {
                                eliminarEvento(eventId, true);
                            }
                        });
                    } else {
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
    function eliminarEvento(eventId, eliminarTodos) {
        $.ajax({
            url: "/events/" + eventId,
            type: "DELETE",
            data: { eliminar_todos: eliminarTodos },
            success: function (response) {
                calendar.refetchEvents();
                Swal.fire(
                    "Eliminado",
                    "El evento ha sido eliminado correctamente.",
                    "success"
                );
                var viewModal = bootstrap.Modal.getInstance(
                    document.getElementById("viewEventModal")
                );
                viewModal.hide();
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
