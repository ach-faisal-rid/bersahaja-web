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

        <CalendarGrid
          :week-days="weekDays"
          :grid="grid"
          :pin-enabled="pinEnabled"
          @pin-click="openPinDialog"
        />

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

    <PinNoteDialog
      :open="pinDialogOpen"
      :cell="selectedPinCell"
      :model-value="pinNoteInput"
      @update:modelValue="pinNoteInput = $event"
      @close="closePinDialog"
      @save="savePinNote"
      @remove="removePin"
    />
  </section>
</template>

<script>
import { toHijri, toGregorian } from 'hijri-converter';
import CalendarHeader from './components/CalendarHeader.vue';
import CalendarGrid from './components/CalendarGrid.vue';
import EventListPanel from './components/EventListPanel.vue';
import PinNoteDialog from './components/PinNoteDialog.vue';

export default {
  name: 'HijriCalendar',
  components: {
    CalendarHeader,
    CalendarGrid,
    EventListPanel,
    PinNoteDialog,
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
    pinEnabled: {
      type: Boolean,
      default: true,
    },
    pinnedEndpoint: {
      type: String,
      default: '/hijri/pinned-days',
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
      pinError: '',
      eventsByGregorianDay: {},
      rawEvents: [],
      pinsByKey: {},
      pinDialogOpen: false,
      selectedPinCell: null,
      pinNoteInput: '',
      pinBusy: false,
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
      
      // Add empty cells untuk padding hari pertama bulan
      for (let i = 0; i < startWeekday; i++) {
        cells.push({
          weekdayIndex: i,
          isWeekend: i === 0 || i === 6, // Minggu atau Sabtu
          isFriday: i === 5, // Jumat
        });
      }

      // Add hari-hari di bulan ini
      for (let d = 1; d <= daysInMonth; d++) {
        const h = this.gregorianToHijri(this.gregorianYear, this.gregorianMonth, d);
        const pin = this.pinsByKey[this.pinKey(h.year, h.month, h.day)] || null;
        const weekdayIndex = (startWeekday + d - 1) % 7; // 0=Sunday, 5=Friday, 6=Saturday
        
        cells.push({
          gregorianDay: d,
          hijriDay: h.day,
          hijriMonth: h.month,
          hijriYear: h.year,
          hijriMonthName: this.hijriMonthNames[h.month - 1] || '',
          hijriMonthShort: (this.hijriMonthNames[h.month - 1] || '').slice(0, 3),
          events: this.eventsByGregorianDay[d] || [],
          isPinned: Boolean(pin),
          pinnedId: pin?.id || null,
          pinnedNote: pin?.note || '',
          weekdayIndex: weekdayIndex,
          isWeekend: weekdayIndex === 0 || weekdayIndex === 6, // Minggu atau Sabtu
          isFriday: weekdayIndex === 5, // Jumat
        });
      }

      // Add empty cells untuk padding akhir bulan
      while (cells.length % 7 !== 0) {
        const nextWeekdayIndex = cells.length % 7;
        cells.push({
          weekdayIndex: nextWeekdayIndex,
          isWeekend: nextWeekdayIndex === 0 || nextWeekdayIndex === 6,
          isFriday: nextWeekdayIndex === 5,
        });
      }
      
      return cells;
    },
    eventList() {
      const eventRows = this.rawEvents
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

      if (!this.pinEnabled) {
        return eventRows;
      }

      const pinnedRows = Object.values(this.pinsByKey)
        .map((pin) => {
          const year = Number(pin.year);
          const month = Number(pin.month);
          const day = Number(pin.day);
          const g = this.hijriToGregorian(year, month, day);
          return {
            id: `pin-${pin.id}`,
            year,
            month,
            day,
            title: pin.note && String(pin.note).trim() !== '' ? `Pin: ${pin.note}` : 'Pinned Day',
            source: 'pinned-day',
            color_hex: '#0f766e',
            gYear: g.year,
            gMonth: g.month,
            gDay: g.day,
            gTs: new Date(g.year, g.month - 1, g.day).getTime(),
            gregorianLabel: new Date(g.year, g.month - 1, g.day).toLocaleDateString('id-ID', {
              day: '2-digit',
              month: 'short',
              year: 'numeric',
            }),
            hijriLabel: `${day}/${month}/${year} H`,
          };
        })
        .filter((event) => event.gYear === this.gregorianYear && event.gMonth === this.gregorianMonth);

      return [...eventRows, ...pinnedRows].sort((a, b) => a.gTs - b.gTs);
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
      this.pinError = '';
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
        if (this.pinEnabled) {
          await this.fetchPinnedDaysForCurrentGregorianMonth();
        } else {
          this.pinsByKey = {};
        }

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
      const uniqueHijriMonths = this.getHijriMonthsForCurrentGregorianMonth();

      const allRows = [];
      const keys = new Set();
      for (const period of uniqueHijriMonths) {
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
    getHijriMonthsForCurrentGregorianMonth() {
      const uniqueHijriMonths = {};
      const daysInMonth = new Date(this.gregorianYear, this.gregorianMonth, 0).getDate();
      for (let d = 1; d <= daysInMonth; d++) {
        const h = this.gregorianToHijri(this.gregorianYear, this.gregorianMonth, d);
        uniqueHijriMonths[`${h.year}-${h.month}`] = { year: h.year, month: h.month };
      }
      return Object.values(uniqueHijriMonths);
    },
    async fetchPinnedDaysForCurrentGregorianMonth() {
      if (!this.pinEnabled) return;

      const months = this.getHijriMonthsForCurrentGregorianMonth();
      const map = {};
      for (const period of months) {
        const response = await fetch(`${this.pinnedEndpoint}?year=${period.year}&month=${period.month}`, {
          headers: { Accept: 'application/json' },
        });
        if (!response.ok) continue;
        const payload = await response.json();
        const rows = Array.isArray(payload?.data) ? payload.data : [];
        rows.forEach((row) => {
          const key = this.pinKey(Number(row.year), Number(row.month), Number(row.day));
          map[key] = row;
        });
      }
      this.pinsByKey = map;
    },
    pinKey(year, month, day) {
      return `${year}-${month}-${day}`;
    },
    openPinDialog(cell) {
      if (!this.pinEnabled || !cell?.gregorianDay) return;
      this.selectedPinCell = cell;
      this.pinNoteInput = cell.pinnedNote || '';
      this.pinDialogOpen = true;
    },
    closePinDialog() {
      this.pinDialogOpen = false;
      this.selectedPinCell = null;
      this.pinNoteInput = '';
    },
    async savePinNote() {
      if (!this.selectedPinCell || this.pinBusy) return;
      this.pinBusy = true;
      try {
        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const response = await fetch(this.pinnedEndpoint, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
            ...(csrf ? { 'X-CSRF-TOKEN': csrf } : {}),
          },
          body: JSON.stringify({
            year: this.selectedPinCell.hijriYear,
            month: this.selectedPinCell.hijriMonth,
            day: this.selectedPinCell.hijriDay,
            note: this.pinNoteInput || null,
          }),
        });
        if (!response.ok) throw new Error('Gagal menyimpan pin.');
        await this.fetchPinnedDaysForCurrentGregorianMonth();
        this.closePinDialog();
        this.eventInfo = 'Pin tanggal berhasil disimpan.';
      } catch (error) {
        this.pinError = error?.message || 'Gagal menyimpan pin.';
        this.eventError = this.pinError;
      } finally {
        this.pinBusy = false;
      }
    },
    async removePin() {
      if (!this.selectedPinCell || !this.selectedPinCell.pinnedId || this.pinBusy) return;
      this.pinBusy = true;
      try {
        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const response = await fetch(`${this.pinnedEndpoint}/${this.selectedPinCell.pinnedId}`, {
          method: 'DELETE',
          headers: {
            Accept: 'application/json',
            ...(csrf ? { 'X-CSRF-TOKEN': csrf } : {}),
          },
        });
        if (!response.ok) throw new Error('Gagal menghapus pin.');
        await this.fetchPinnedDaysForCurrentGregorianMonth();
        this.closePinDialog();
        this.eventInfo = 'Pin tanggal berhasil dihapus.';
      } catch (error) {
        this.pinError = error?.message || 'Gagal menghapus pin.';
        this.eventError = this.pinError;
      } finally {
        this.pinBusy = false;
      }
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
