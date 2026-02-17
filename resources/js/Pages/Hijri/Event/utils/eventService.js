/**
 * Event Service Utility
 * Menangani semua API calls untuk event
 */

import dateConverter from './dateConverter';

export async function fetchEventsForMonth(gregorianYear, gregorianMonth) {
  const firstDay = new Date(gregorianYear, gregorianMonth - 1, 1);
  const lastDay = new Date(gregorianYear, gregorianMonth, 0);

  const firstHijri = await dateConverter.gregorianToHijri(
    firstDay.getFullYear(),
    firstDay.getMonth() + 1,
    firstDay.getDate()
  );
  const lastHijri = await dateConverter.gregorianToHijri(
    lastDay.getFullYear(),
    lastDay.getMonth() + 1,
    lastDay.getDate()
  );

  const allEvents = [];
  const processedMonths = new Set();
  const eventKeys = new Set();

  for (let y = firstHijri.year; y <= lastHijri.year; y++) {
    const startMonth = (y === firstHijri.year) ? firstHijri.month : 1;
    const endMonth = (y === lastHijri.year) ? lastHijri.month : 12;
    for (let m = startMonth; m <= endMonth; m++) {
      const monthKey = `${y}-${m}`;
      if (processedMonths.has(monthKey)) continue;
      processedMonths.add(monthKey);

      try {
        const response = await fetch(`/hijri/events?year=${y}&month=${m}`, {
          headers: { Accept: 'application/json' }
        });
        if (response.ok) {
          const payload = await response.json();
          if (Array.isArray(payload?.data)) {
            payload.data.forEach(event => {
              const eventKey = `${event.year}-${event.month}-${event.day}-${event.title}`;
              if (!eventKeys.has(eventKey)) {
                eventKeys.add(eventKey);
                allEvents.push(event);
              }
            });
          }
        }
      } catch (error) {
        console.warn(`Error fetching events for ${y}/${m}:`, error);
      }
    }
  }

  return allEvents.sort((a, b) => {
    if (a.year !== b.year) return a.year - b.year;
    if (a.month !== b.month) return a.month - b.month;
    return a.day - b.day;
  });
}

export async function createEvent(eventData) {
  const response = await fetch('/hijri/events', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
    },
    body: JSON.stringify(eventData)
  });
  return response.json();
}

export async function deleteEvent(id) {
  const response = await fetch(`/hijri/events/${id}`, {
    method: 'DELETE',
    headers: {
      'Accept': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
    }
  });
  return response.json();
}

export async function fetchExternalEvents() {
  const response = await fetch('/hijri/events/fetch-external', {
    method: 'POST',
    headers: {
      'Accept': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
    }
  });
  return response.json();
}
