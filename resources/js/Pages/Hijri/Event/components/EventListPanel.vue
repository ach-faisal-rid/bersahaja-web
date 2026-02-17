<template>
  <div class="event-list-card">
    <div class="event-list-head">Daftar Event (Tanggal Masehi)</div>
    <div v-if="eventList.length === 0" class="event-list-empty">Belum ada event pada bulan ini.</div>
    <div v-else class="event-list-group">
      <div v-for="(group, idx) in eventGroups" :key="idx" class="event-group">
        <div class="event-group-head">
          <div>
            <div class="event-group-date">{{ group.gregorianLabel }}</div>
            <div class="event-group-day">{{ group.weekday }}</div>
          </div>
          <div class="event-count">{{ group.items.length }} event</div>
        </div>

        <div class="event-items">
          <div v-for="(event, eventIdx) in group.items" :key="eventIdx" class="event-item">
            <span class="event-color" :style="{ backgroundColor: event.color_hex || '#0ea5e9' }"></span>
            <div class="event-body">
              <div class="event-title-main">{{ event.title }}</div>
              <div class="event-meta">
                <span class="event-hijri">{{ event.hijriLabel }}</span>
                <span class="event-source" :class="sourceClass(event.source)">{{ sourceLabel(event.source) }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'EventListPanel',
  props: {
    eventList: {
      type: Array,
      required: true,
    },
    eventGroups: {
      type: Array,
      required: true,
    },
  },
  methods: {
    sourceLabel(source) {
      if (source === 'libur.deno.dev') return 'libur nasional';
      if (source === 'aladhan') return 'aladhan';
      return source || '-';
    },
    sourceClass(source) {
      if (source === 'libur.deno.dev') return 'is-libur';
      if (source === 'aladhan') return 'is-aladhan';
      return 'is-default';
    },
  },
};
</script>

<style scoped>
.event-list-card {
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  padding: 0.9rem;
  background: #ffffff;
}

.event-list-head {
  font-size: 0.86rem;
  font-weight: 700;
  color: #0f172a;
  margin-bottom: 0.55rem;
}

.event-list-empty {
  font-size: 0.75rem;
  color: #64748b;
}

.event-list-group {
  display: grid;
  gap: 0.65rem;
}

.event-group {
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  overflow: hidden;
  background: #ffffff;
}

.event-group-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 0.5rem;
  padding: 0.55rem 0.65rem;
  background: #f8fafc;
  border-bottom: 1px solid #e2e8f0;
}

.event-group-date {
  font-size: 0.78rem;
  font-weight: 700;
  color: #0f172a;
}

.event-group-day {
  margin-top: 0.12rem;
  font-size: 0.68rem;
  color: #64748b;
  text-transform: capitalize;
}

.event-count {
  border-radius: 999px;
  background: #dbeafe;
  color: #1d4ed8;
  font-size: 0.66rem;
  font-weight: 700;
  padding: 0.18rem 0.52rem;
}

.event-items {
  padding: 0.5rem 0.6rem;
  display: grid;
  gap: 0.45rem;
}

.event-item {
  display: flex;
  align-items: flex-start;
  gap: 0.45rem;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  padding: 0.42rem 0.48rem;
  background: #ffffff;
}

.event-color {
  width: 0.42rem;
  height: 100%;
  min-height: 30px;
  border-radius: 999px;
  flex-shrink: 0;
}

.event-body {
  min-width: 0;
}

.event-title-main {
  font-size: 0.75rem;
  color: #0f172a;
  font-weight: 600;
}

.event-meta {
  margin-top: 0.18rem;
  display: flex;
  align-items: center;
  gap: 0.4rem;
  flex-wrap: wrap;
}

.event-hijri {
  font-size: 0.66rem;
  color: #475569;
}

.event-source {
  border-radius: 999px;
  font-size: 0.62rem;
  font-weight: 700;
  padding: 0.12rem 0.42rem;
  text-transform: lowercase;
}

.event-source.is-libur {
  background: #dcfce7;
  color: #166534;
}

.event-source.is-aladhan {
  background: #e0f2fe;
  color: #075985;
}

.event-source.is-default {
  background: #e2e8f0;
  color: #334155;
}

@media (max-width: 640px) {
  .event-group-head {
    align-items: flex-start;
  }
}
</style>
