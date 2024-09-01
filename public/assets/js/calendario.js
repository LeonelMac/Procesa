// script.js
document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#calendar", {
        inline: true, // Muestra el calendario completo en la página
        locale: "es", // Cambia el idioma del calendario a español
        dateFormat: "Y-m-d", // Formato de la fecha
        minDate: "today", // Deshabilitar fechas anteriores al día actual
        disable: [
            function(date) {
                // Deshabilitar los fines de semana (Saturday=6, Sunday=0)
                return (date.getDay() === 0 || date.getDay() === 6);
            },
            "2024-12-25", // Navidad
            "2024-01-01", // Año Nuevo
            "2024-05-01", // Día del Trabajo
            "2024-09-16"  // Día de la Independencia de México
        ],
        onDayCreate: function(dObj, dStr, fp, dayElem) {
            const dateStr = dayElem.dateObj.toISOString().split('T')[0];
            // Resalta las fechas que son eventos importantes o festivos
            if (["2024-12-25", "2024-01-01", "2024-05-01", "2024-09-16"].includes(dateStr)) {
                dayElem.className += " highlight";
            }
        },
        onChange: function(selectedDates, dateStr, instance) {
            if (selectedDates.length > 0) {
                Swal.fire({
                    icon: 'success',
                    title: 'Fecha seleccionada',
                    text: `Has seleccionado: ${dateStr}`,
                });
            }
        }
    });
});
