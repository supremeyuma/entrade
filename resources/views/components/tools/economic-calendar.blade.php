<section id="economic-calendar">
    <h2 class="text-2xl font-semibold mb-4">Economic Calendar for Today</h2>
    <input type="text" id="calendar-search" placeholder="Search events..." class="border p-2 rounded w-full mt-4" />

    <div class="mt-4 h-[600px] overflow-y-auto rounded border p-4 bg-white shadow" id="calendar-list"></div>


    <script>
    let allEvents = [];

    fetch('/api/calendar')
    .then(res => res.json())
    .then(events => {
        console.log('Calendar data:', events);
        allEvents = Array.isArray(events) ? events : [];
        renderCalendar(allEvents);
    })
    .catch(err => {
        console.error('Error loading calendar:', err);
        document.getElementById('calendar-list').innerHTML =
        '<p class="text-red-600">Failed to load calendar data.</p>';
    });

    document.getElementById('calendar-search').addEventListener('input', e => {
    const keyword = e.target.value.toLowerCase();
    const filtered = allEvents.filter(ev =>
        (ev.title || '').toLowerCase().includes(keyword) ||
        (ev.country || '').toLowerCase().includes(keyword) ||
        (ev.comment || '').toLowerCase().includes(keyword)
    );
    renderCalendar(filtered);
    });

    function renderCalendar(events) {
    const container = document.getElementById('calendar-list');

    if (!Array.isArray(events) || events.length === 0) {
        container.innerHTML = '<p class="text-gray-600">No matching events.</p>';
        return;
    }

    const html = events.map(event => `
        <div class="border p-4 rounded shadow bg-white mb-3">
        <h3 class="text-lg font-semibold">${event.title || event.event}</h3>
        <p class="text-sm text-gray-500">${event.country} • ${event.date}</p>
        ${event.indicator ? `<p class="mt-1 text-sm">${event.indicator}</p>` : ''}
        ${event.comment ? `<p class="mt-1 text-xs text-gray-700">${event.comment}</p>` : ''}
        <div class="mt-2 text-sm">
            <span class="font-medium">Previous:</span> ${event.previous || 'N/A'}<br>
            <span class="font-medium">Forecast:</span> ${event.forecast || 'N/A'}<br>
            <span class="font-medium">Actual:</span> ${event.actual || 'N/A'}
        </div>
        </div>
    `).join('');

    container.innerHTML = html;
    }
    </script>


</section>
