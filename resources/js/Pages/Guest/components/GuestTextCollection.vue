<script setup>
defineProps({
  title: {
    type: String,
    required: true,
  },
  emptyText: {
    type: String,
    default: 'Belum ada data.',
  },
  items: {
    type: Array,
    default: () => [],
  },
  translationKey: {
    type: String,
    default: 'terjemahan',
  },
});
</script>

<template>
  <article class="panel">
    <h2 class="panel-title">{{ title }}</h2>
    <div v-if="items.length === 0" class="empty">{{ emptyText }}</div>
    <div v-else class="stack">
      <div v-for="item in items" :key="item.id" class="item-card">
        <h3 class="item-title">{{ item.judul }}</h3>
        <p class="item-arab" dir="rtl">{{ item.teks_arab }}</p>
        <p class="item-translation">{{ item[translationKey] }}</p>
      </div>
    </div>
  </article>
</template>

<style scoped>
.panel {
  margin-top: 0.8rem;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  background: #ffffff;
  padding: 0.9rem;
}

.panel-title {
  font-size: 1rem;
  font-weight: 700;
  color: #0f172a;
  margin-bottom: 0.6rem;
}

.stack {
  display: grid;
  gap: 0.55rem;
}

.item-card {
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  padding: 0.6rem;
  background: #f8fafc;
}

.item-title {
  font-size: 0.84rem;
  font-weight: 700;
  color: #0f172a;
}

.item-arab {
  margin-top: 0.35rem;
  font-size: 1rem;
  color: #0f172a;
}

.item-translation {
  margin-top: 0.35rem;
  font-size: 0.78rem;
  color: #475569;
}

.empty {
  font-size: 0.82rem;
  color: #64748b;
}
</style>
