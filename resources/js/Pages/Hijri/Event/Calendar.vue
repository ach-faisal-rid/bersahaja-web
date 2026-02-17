<template>
  <section class="calendar-shell" :class="{ 'is-compact': compact }">
    <div class="calendar-layout" :class="{ 'is-side': listPosition === 'side' }">
      <div class="calendar-card">
        <CalendarHeader
          :gregorian-month-title="gregorianMonthTitle"
          :hijri-range-title="hijriRangeTitle"
          @prev="prevMonth"
          @next="nextMonth"
        />

        <CalendarGrid :week-days="weekDays" :grid="grid" />

        <div v-if="loadingEvents" class="status status-loading">
          Menyinkronkan data kalender...
        </div>
        <div v-if="eventInfo" class="status status-info">
          {{ eventInfo }}
        </div>
        <div v-if="eventError" class="status status-error">
          {{ eventError }}
        </div>
      </div>

      <EventListPanel :event-list="eventList" :event-groups="eventGroups" />
    </div>
  </section>
</template>

<script>
import { toHijri, toGregorian } from 'hijri-converter';
import CalendarHeader from './components/CalendarHeader.vue';
import CalendarGrid from './components/CalendarGrid.vue';
import EventListPanel from './components/EventListPanel.vue';

export default {
  name: 'HijriCalendar',
  components: {
    CalendarHeader,
    CalendarGrid,
    EventListPanel,
  },
  props: {
    eventsEndpoint: {
      type: String,
      default: '/hijri/events',
    },
    syncEndpoint: {
      type: String,
      default: '/hijri/events/fetch-external',
    },
    syncEnabled: {
      type: Boolean,
      default: true,
    },
    listPosition: {
      type: String,
      default: 'bottom',
    },
    compact: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    const today = new Date();
    return {
      gregorianYear: today.getFullYear(),
      gregorianMonth: today.getMonth() + 1,
      loadingEvents: false,
      eventError: '',
      eventInfo: '',
      eventsByGregorianDay: {},
      rawEvents: [],
      weekDays: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
      hijriMonthNames: [
        'Muharram', 'Safar', 'Rabiulawal', 'Rabiulakhir', 'Jumadilawal', 'Jumadilakhir',
        'Rajab', 'Sya\'ban', 'Ramadhan', 'Syawwal', 'Dzulqa\'dah', 'Dzulhijjah',
      ],
    };
  },
  computed: {
    gregorianMonthTitle() {
      const date = new Date(this.gregorianYear, this.gregorianMonth - 1, 1);
      return date.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
    },
    hijriRangeTitle() {
      const first = this.gregorianToHijri(this.gregorianYear, this.gregorianMonth, 1);
      const daysInMonth = new Date(this.gregorianYear, this.gregorianMonth, 0).getDate();
      const last = this.gregorianToHijri(this.gregorianYear, this.gregorianMonth, daysInMonth);
      const firstMonth = this.hijriMonthNames[first.month - 1] || '';
      const lastMonth = this.hijriMonthNames[last.month - 1] || '';

      if (first.year === last.year && first.month === last.month) {
        return `${firstMonth} ${first.year} H`;
      }
      if (first.year === last.year) {
        return `${firstMonth} - ${lastMonth} ${first.year} H`;
      }
      return `${firstMonth} ${first.year} H - ${lastMonth} ${last.year} H`;
    },
    grid() {
      const firstDate = new Date(this.gregorianYear, this.gregorianMonth - 1, 1);
      const startWeekday = firstDate.getDay();
      const daysInMonth = new Date(this.gregorianYear, this.gregorianMonth, 0).getDate();

      const cells = [];
      for (let i = 0; i < startWeekday; i++) cells.push({});

      for (let d = 1; d <= daysInMonth; d++) {
        const h = this.gregorianToHijri(this.gregorianYear, this.gregorianMonth, d);
        cells.push({
          gregorianDay: d,
          hijriDay: h.day,
          hijriMonthShort: (this.hijriMonthNames[h.month - 1] || '').slice(0, 3),
          events: this.eventsByGregorianDay[d] || [],
        });
      }

      while (cells.length % 7 !== 0) cells.push({});
      return cells;
    },
    eventList() {
      return this.rawEvents
        .map((event) => {
          const g = this.hijriToGregorian(Number(event.year), Number(event.month), Number(event.day));
          return {
            ...event,
            gYear: g.year,
            gMonth: g.month,
            gDay: g.day,
            gTs: new Date(g.year, g.month - 1, g.day).getTime(),
            gregorianLabel: new Date(g.year, g.month - 1, g.day).toLocaleDateString('id-ID', {
              day: '2-digit',
              month: 'short',
              year: 'numeric',
            }),
            hijriLabel: `${event.day}/${event.month}/${event.year} H`,
          };
        })
        .filter((event) => event.gYear === this.gregorianYear && event.gMonth === this.gregorianMonth)
        .sort((a, b) => a.gTs - b.gTs);
    },
    eventGroups() {
      const groups = {};
      this.eventList.forEach((event) => {
        const key = `${event.gYear}-${event.gMonth}-${event.gDay}`;
        if (!groups[key]) {
          groups[key] = {
            gTs: event.gTs,
            gregorianLabel: event.gregorianLabel,
            weekday: new Date(event.gYear, event.gMonth - 1, event.gDay).toLocaleDateString('id-ID', { weekday: 'long' }),
            items: [],
          };
        }
        groups[key].items.push(event);
      });

      return Object.values(groups)
        .sort((a, b) => a.gTs - b.gTs)
        .map((group) => ({
          ...group,
          items: group.items.sort((a, b) => String(a.title).localeCompare(String(b.title))),
        }));
    },
  },
  watch: {
    gregorianYear: 'fetchEvents',
    gregorianMonth: 'fetchEvents',
  },
  mounted() {
    this.fetchEvents();
  },
  methods: {
    prevMonth() {
      this.gregorianMonth -= 1;
      if (this.gregorianMonth < 1) {
        this.gregorianMonth = 12;
        this.gregorianYear -= 1;
      }
    },
    nextMonth() {
      this.gregorianMonth += 1;
      if (this.gregorianMonth > 12) {
        this.gregorianMonth = 1;
        this.gregorianYear += 1;
      }
    },
    async fetchEvents() {
      this.loadingEvents = true;
      this.eventError = '';
      this.eventInfo = '';
      try {
        if (this.syncEnabled) {
          const syncOk = await this.syncExternalEvents();
          if (!syncOk) {
            this.eventInfo = 'Offline mode: menampilkan data terakhir dari database lokal.';
          }
        } else {
          this.eventInfo = 'Mode publik: data dibaca dari database lokal.';
        }

        const rows = await this.fetchHijriRowsForCurrentGregorianMonth();
        this.rawEvents = rows;

        const grouped = {};
        rows.forEach((event) => {
          const g = this.hijriToGregorian(Number(event.year), Number(event.month), Number(event.day));
          if (g.year !== this.gregorianYear || g.month !== this.gregorianMonth) return;
          if (!grouped[g.day]) grouped[g.day] = [];
          grouped[g.day].push(event);
        });
        this.eventsByGregorianDay = grouped;
      } catch (error) {
        this.rawEvents = [];
        this.eventsByGregorianDay = {};
        this.eventError = error?.message || 'Gagal memuat event.';
      } finally {
        this.loadingEvents = false;
      }
    },
    async fetchHijriRowsForCurrentGregorianMonth() {
      const uniqueHijriMonths = {};
      const daysInMonth = new Date(this.gregorianYear, this.gregorianMonth, 0).getDate();
      for (let d = 1; d <= daysInMonth; d++) {
        const h = this.gregorianToHijri(this.gregorianYear, this.gregorianMonth, d);
        uniqueHijriMonths[`${h.year}-${h.month}`] = { year: h.year, month: h.month };
      }

      const allRows = [];
      const keys = new Set();
      for (const period of Object.values(uniqueHijriMonths)) {
        const response = await fetch(`${this.eventsEndpoint}?year=${period.year}&month=${period.month}`, {
          headers: { Accept: 'application/json' },
        });
        if (!response.ok) continue;
        const payload = await response.json();
        const rows = Array.isArray(payload?.data) ? payload.data : [];
        rows.forEach((row) => {
          const key = `${row.year}-${row.month}-${row.day}-${row.title}`;
          if (keys.has(key)) return;
          keys.add(key);
          allRows.push(row);
        });
      }
      return allRows;
    },
    async syncExternalEvents() {
      if (!this.syncEnabled) return true;
      const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
      try {
        const response = await fetch(this.syncEndpoint, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
            ...(csrf ? { 'X-CSRF-TOKEN': csrf } : {}),
          },
          body: JSON.stringify({
            periods: [{ year: this.gregorianYear, month: this.gregorianMonth }],
          }),
        });
        return response.ok;
      } catch (_) {
        return false;
      }
    },
    gregorianToHijri(gy, gm, gd) {
      const result = toHijri(gy, gm, gd);
      return { year: result.hy, month: result.hm, day: result.hd };
    },
    hijriToGregorian(hy, hm, hd) {
      const result = toGregorian(hy, hm, hd);
      return { year: result.gy, month: result.gm, day: result.gd };
    },
  },
};
</script>

<style scoped>
.calendar-shell {
  max-width: 960px;
  margin: 0 auto;
}

.calendar-shell.is-compact {
  max-width: 820px;
}

.calendar-layout {
  display: grid;
  gap: 0.75rem;
}

.calendar-layout.is-side {
  grid-template-columns: 1.05fr 0.95fr;
  align-items: start;
}

.calendar-card {
  border: 1px solid #e2e8f0;
  border-radius: 18px;
  background: #ffffff;
  box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
  padding: 1rem;
}

.calendar-shell.is-compact .calendar-card {
  padding: 0.8rem;
}

.status {
  margin-top: 0.75rem;
  font-size: 0.75rem;
}

.status-loading {
  color: #0369a1;
}

.status-info {
  color: #0369a1;
}

.status-error {
  color: #dc2626;
}

.calendar-shell.is-compact :deep(.event-list-card) {
  padding: 0.75rem;
}

@media (max-width: 980px) {
  .calendar-layout.is-side {
    grid-template-columns: 1fr;
  }
}
</style>
