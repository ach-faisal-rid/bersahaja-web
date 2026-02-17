<template>
  <div class="grid grid-cols-7 gap-2 text-center text-sm">
    <div v-for="d in weekDays" :key="d" class="week-day">{{ d }}</div>

    <div
      v-for="(cell, idx) in grid"
      :key="idx"
      class="day-cell"
      :class="{ 'has-event': cell.events && cell.events.length > 0 }"
    >
      <template v-if="cell.gregorianDay">
        <div class="gregorian-day">{{ cell.gregorianDay }}</div>
        <div class="hijri-day">{{ cell.hijriDay }} {{ cell.hijriMonthShort }}</div>

        <div v-if="cell.events && cell.events.length > 0" class="event-stack">
          <div
            v-for="(event, eventIdx) in cell.events.slice(0, 2)"
            :key="eventIdx"
            class="event-dot"
            :style="{ backgroundColor: event.color_hex || '#0ea5e9' }"
            :title="`${event.title} (${event.source || 'unknown'})`"
          ></div>
        </div>
        <div v-if="cell.events && cell.events.length > 0" class="event-title" :title="cell.events.map((e) => e.title).join(' | ')">
          {{ cell.events[0].title }}
        </div>
      </template>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CalendarGrid',
  props: {
    weekDays: {
      type: Array,
      required: true,
    },
    grid: {
      type: Array,
      required: true,
    },
  },
};
</script>

<style scoped>
.week-day {
  font-size: 0.75rem;
  color: #334155;
  font-weight: 700;
}

.day-cell {
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  min-height: 86px;
  padding: 0.45rem;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  background: #ffffff;
}

.day-cell.has-event {
  border-color: #bae6fd;
  background: #f8fcff;
}

.gregorian-day {
  font-size: 1rem;
  font-weight: 700;
  color: #0f172a;
}

.hijri-day {
  margin-top: 0.1rem;
  font-size: 0.67rem;
  color: #334155;
}

.event-stack {
  margin-top: auto;
  display: flex;
  gap: 0.25rem;
}

.event-dot {
  width: 0.43rem;
  height: 0.43rem;
  border-radius: 999px;
}

.event-title {
  margin-top: 0.24rem;
  font-size: 0.62rem;
  line-height: 1.1;
  color: #0f172a;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
