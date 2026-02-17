<template>
  <div>
    <div class="header">
      <button class="nav-btn" @click="$emit('prev')" aria-label="Bulan sebelumnya">‹</button>
      <div class="title-wrap">
        <div class="title-main">{{ gregorianMonthTitle }}</div>
        <div class="title-sub">{{ hijriRangeTitle }}</div>
      </div>
      <button class="nav-btn" @click="$emit('next')" aria-label="Bulan berikutnya">›</button>
    </div>

    <div class="legend">
      <span class="chip chip-main">Utama: Masehi</span>
      <span class="chip chip-sub">Bawah: Hijriah</span>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CalendarHeader',
  props: {
    gregorianMonthTitle: {
      type: String,
      required: true,
    },
    hijriRangeTitle: {
      type: String,
      required: true,
    },
  },
  emits: ['prev', 'next'],
};
</script>

<style scoped>
.header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 0.75rem;
  margin-bottom: 0.8rem;
}

.nav-btn {
  border: 0;
  width: 2rem;
  height: 2rem;
  border-radius: 999px;
  font-size: 1.3rem;
  background: #0f172a;
  color: #f8fafc;
  cursor: pointer;
}

.title-wrap {
  text-align: center;
}

.title-main {
  font-size: 1.12rem;
  font-weight: 700;
  color: #0f172a;
  text-transform: capitalize;
}

.title-sub {
  font-size: 0.8rem;
  color: #475569;
}

.legend {
  display: flex;
  gap: 0.45rem;
  margin-bottom: 0.75rem;
}

.chip {
  border-radius: 999px;
  font-size: 0.7rem;
  padding: 0.22rem 0.6rem;
  font-weight: 600;
}

.chip-main {
  background: #e2e8f0;
  color: #0f172a;
}

.chip-sub {
  background: #dcfce7;
  color: #166534;
}
</style>
