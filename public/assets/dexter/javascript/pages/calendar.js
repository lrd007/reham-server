document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'ar'
    });
    calendar.render();
    /* HOOK IF DAY HAVE EVENT */
    const eventDay = '2023-08-16';
    const dayHaveEvent = document.querySelector(`[data-date='${eventDay}']`)
    dayHaveEvent.classList.add('--event');
    const openModal = document.createElement("button");
    openModal.setAttribute('data-toggle', 'modal');
    openModal.setAttribute('data-target', '#exampleModalCenter');
    openModal.setAttribute('type', 'button');
    openModal.setAttribute('class', 'btn btn-primary');
    dayHaveEvent.appendChild(openModal);
  });


