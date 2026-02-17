/**
 * Event Fetcher Utility
 * Mengambil event dari API berdasarkan bulan Hijriah
 */

import dateConverter from './dateConverter';

export async function fetchEventsForGregorianMonth(gregorianYear, gregorianMonth) {
  try {
    // Tentukan range bulan Hijriah dari bulan Gregorian
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

    // Ambil event untuk semua bulan Hijriah yang relevan
    const allEvents = {};
    const processedMonths = new Set();

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
            const rows = Array.isArray(payload?.data) ? payload.data : [];
            
            rows.forEach((event) => {
              const day = Number(event.day);
              if (!Number.isInteger(day) || day <= 0) return;
              const eventKey = `${y}-${m}-${day}`;
              if (!allEvents[eventKey]) allEvents[eventKey] = [];
              allEvents[eventKey].push(event);
            });
          }
        } catch (error) {
          console.warn(`Error fetching events for ${y}/${m}:`, error);
        }
      }
    }

    return allEvents;
  } catch (error) {
    console.error('Error fetching events:', error);
    return {};
  }
}
