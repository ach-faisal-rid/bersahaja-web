<script setup>
import { computed } from 'vue';
import GuestTextItem from './GuestTextItem.vue';
import { useTextCollection } from './useTextCollection';

const props = defineProps({
  title: { type: String, required: true },
  subtitle: { type: String, default: '' },
  emptyText: { type: String, default: 'Belum ada data.' },
  items: { type: Array, default: () => [] },
  translationKey: { type: String, default: 'terjemahan' },
  transliterationKey: { type: String, default: 'transliterasi' },
  accent: { type: String, default: 'teal', validator: (v) => ['teal', 'amber'].includes(v) },
  showTags: { type: Boolean, default: false },
});

const { accentClass, itemCountLabel } = useTextCollection({
  accent: props.accent,
  items: props.items,
  showTags: props.showTags,
});
</script>

<template>
  <article class="panel" :class="[accentClass]">
    <div class="panel-head">
      <div>
        <h2 class="panel-title">{{ title }}</h2>
        <p v-if="subtitle" class="panel-subtitle">{{ subtitle }}</p>
      </div>
      <span class="panel-count" :class="`count-${props.accent}`">{{ itemCountLabel }}</span>
    </div>

    <div v-if="items.length === 0" class="empty-state">
      <p class="empty-text">{{ emptyText }}</p>
    </div>
    
    <div v-else class="items-grid">
      <GuestTextItem
        v-for="item in props.items"
        :key="item.id || item.judul"
        :item="item"
        :translation-key="props.translationKey"
        :transliteration-key="props.transliterationKey"
        :show-tags="props.showTags"
      />
    </div>
  </article>
</template>

<style scoped>
/* CSS Variables untuk konsistensi */
:root {
  --spacing-xs: 0.25rem;
  --spacing-sm: 0.5rem;
  --spacing-md: 0.75rem;
  --spacing-lg: 1rem;
  --border-radius-sm: 8px;
  --border-radius-md: 12px;
  --border-radius-lg: 16px;
  --border-radius-full: 999px;
}

/* Panel Styles */
.panel {
  margin-top: var(--spacing-md);
  border: 1px solid #e2e8f0;
  border-radius: var(--border-radius-lg);
  background: #ffffff;
  padding: var(--spacing-md);
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
  transition: box-shadow 0.2s ease;
}

.panel:hover {
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.panel-head {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: var(--spacing-sm);
  margin-bottom: var(--spacing-md);
}

.panel-title {
  font-size: 1.125rem;
  font-weight: 700;
  color: #0f172a;
  line-height: 1.4;
}

.panel-subtitle {
  margin-top: 0.125rem;
  font-size: 0.75rem;
  color: #64748b;
}

/* Panel Count Variants */
.panel-count {
  flex-shrink: 0;
  border-radius: var(--border-radius-full);
  font-size: 0.6875rem;
  font-weight: 700;
  padding: 0.25rem 0.625rem;
  transition: background-color 0.2s ease;
}

.panel-count.count-teal {
  background: #ccfbf1;
  color: #0f766e;
}

.panel-count.count-amber {
  background: #fef3c7;
  color: #92400e;
}

/* Items Grid */
.items-grid {
  display: grid;
  gap: var(--spacing-sm);
}

.items-grid {
  display: grid;
  gap: var(--spacing-sm);
}

.empty-state {
  padding: var(--spacing-lg);
  text-align: center;
  background: #f8fafc;
  border-radius: var(--border-radius-md);
}

.empty-text {
  font-size: 0.875rem;
  color: #64748b;
  font-style: italic;
}
.empty-state {
  padding: var(--spacing-lg);
  text-align: center;
  background: #f8fafc;
  border-radius: var(--border-radius-md);
}

.empty-text {
  font-size: 0.875rem;
  color: #64748b;
  font-style: italic;
}

/* Utility Classes */
/* Utility: kept minimal — item styles moved to GuestTextItem.vue */
</style>