/**
 * Calendar Builder Utility
 * Membangun grid kalender berdasarkan bulan Gregorian
 */

import dateConverter from './dateConverter';

const HIJRI_MONTH_NAMES = [
  'Muharram', 'Safar', 'Rabiulawal', 'Rabiulakhir',
  'Jumadilawal', 'Jumadilakhir', 'Rajab', 'Sya\'ban',
  'Ramadhan', 'Syawwal', 'Dzulqa\'dah', 'Dzulhijjah'
];

export async function buildCalendarGrid(gregorianYear, gregorianMonth, eventsByDay = {}) {
  const daysInMonth = new Date(gregorianYear, gregorianMonth, 0).getDate();
  const firstDayOfWeek = new Date(gregorianYear, gregorianMonth - 1, 1).getDay();
  const cells = [];

  // Tambahkan sel kosong untuk hari sebelum tanggal 1
  for (let i = 0; i < firstDayOfWeek; i++) {
    cells.push({ gregorianDay: null, hijriDay: '', events: [] });
  }

  // Loop untuk setiap hari di bulan Gregorian
  for (let d = 1; d <= daysInMonth; d++) {
    try {
      const hijri = await dateConverter.gregorianToHijri(gregorianYear, gregorianMonth, d);
      const hijriDayStr = `${hijri.day} ${HIJRI_MONTH_NAMES[hijri.month - 1] || ''}`;
      
      const eventKey = `${hijri.year}-${hijri.month}-${hijri.day}`;
      const events = eventsByDay[eventKey] || [];

      cells.push({
        gregorianDay: d,
        hijriDay: hijriDayStr,
        events: events
      });
    } catch (error) {
      console.error(`Error converting date ${gregorianYear}-${gregorianMonth}-${d}:`, error);
      cells.push({
        gregorianDay: d,
        hijriDay: '',
        events: []
      });
    }
  }

  // Pad to full weeks (harus kelipatan 7)
  while (cells.length % 7 !== 0) {
    cells.push({ gregorianDay: null, hijriDay: '', events: [] });
  }

  return cells;
}
