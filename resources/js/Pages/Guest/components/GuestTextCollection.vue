<script setup>
import { computed } from 'vue';

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  subtitle: {
    type: String,
    default: '',
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
  transliterationKey: {
    type: String,
    default: 'transliterasi',
  },
  accent: {
    type: String,
    default: 'teal',
  },
  showTags: {
    type: Boolean,
    default: false,
  },
});

const itemCountLabel = computed(() => `${props.items.length} item`);
const accentClass = computed(() => (props.accent === 'amber' ? 'is-amber' : 'is-teal'));

const readText = (item, key) => {
  const value = item?.[key];
  return typeof value === 'string' && value.trim() !== '' ? value : '-';
};

const readCategory = (item) => {
  const name = item?.category?.nama;
  return typeof name === 'string' && name.trim() !== '' ? name : 'Umum';
};

const readTags = (item) => {
  if (!Array.isArray(item?.tags)) return [];
  return item.tags
    .map((tag) => tag?.nama)
    .filter((name) => typeof name === 'string' && name.trim() !== '');
};
</script>

<template>
  <article class="panel" :class="[accentClass]">
    <div class="panel-head">
      <div>
        <h2 class="panel-title">{{ title }}</h2>
        <p v-if="subtitle" class="panel-subtitle">{{ subtitle }}</p>
      </div>
      <span class="panel-count">{{ itemCountLabel }}</span>
    </div>

    <div v-if="items.length === 0" class="empty">{{ emptyText }}</div>
    <div v-else class="stack">
      <div v-for="item in items" :key="item.id" class="item-card">
        <div class="item-top">
          <h3 class="item-title">{{ item.judul }}</h3>
          <span class="item-tag">{{ readCategory(item) }}</span>
        </div>
        <p class="item-arab" dir="rtl">{{ readText(item, 'teks_arab') }}</p>
        <p class="item-transliteration">{{ readText(item, transliterationKey) }}</p>
        <p class="item-translation">{{ readText(item, translationKey) }}</p>
        <div v-if="showTags && readTags(item).length > 0" class="tag-list">
          <span v-for="(tag, idx) in readTags(item)" :key="idx" class="tag-chip">
            #{{ tag }}
          </span>
        </div>
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

.panel-head {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 0.6rem;
  margin-bottom: 0.6rem;
}

.panel-title {
  font-size: 1rem;
  font-weight: 700;
  color: #0f172a;
}

.panel-subtitle {
  margin-top: 0.18rem;
  font-size: 0.73rem;
  color: #64748b;
}

.panel-count {
  flex-shrink: 0;
  border-radius: 999px;
  font-size: 0.65rem;
  font-weight: 700;
  padding: 0.14rem 0.5rem;
}

.panel.is-teal .panel-count {
  background: #ccfbf1;
  color: #0f766e;
}

.panel.is-amber .panel-count {
  background: #fef3c7;
  color: #92400e;
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

.item-top {
  display: flex;
  gap: 0.5rem;
  justify-content: space-between;
  align-items: flex-start;
}

.item-title {
  font-size: 0.84rem;
  font-weight: 700;
  color: #0f172a;
  line-height: 1.25;
}

.item-tag {
  border-radius: 999px;
  font-size: 0.61rem;
  font-weight: 700;
  padding: 0.12rem 0.46rem;
  background: #e2e8f0;
  color: #334155;
}

.item-arab {
  margin-top: 0.35rem;
  font-size: 1rem;
  color: #0f172a;
  line-height: 1.5;
}

.item-transliteration {
  margin-top: 0.28rem;
  font-size: 0.74rem;
  color: #475569;
  font-style: italic;
  line-height: 1.45;
}

.item-translation {
  margin-top: 0.28rem;
  font-size: 0.78rem;
  color: #475569;
  line-height: 1.45;
}

.tag-list {
  margin-top: 0.35rem;
  display: flex;
  gap: 0.3rem;
  flex-wrap: wrap;
}

.tag-chip {
  border-radius: 999px;
  font-size: 0.62rem;
  font-weight: 700;
  padding: 0.1rem 0.42rem;
  background: #dbeafe;
  color: #1e3a8a;
}

.empty {
  font-size: 0.82rem;
  color: #64748b;
}
</style>
