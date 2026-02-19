<script setup>
import { computed } from 'vue';
import { useTextCollection } from './useTextCollection';

const props = defineProps({
  item: {
    type: Object,
    required: true,
  },
  translationKey: {
    type: String,
    default: 'terjemahan',
  },
  transliterationKey: {
    type: String,
    default: 'transliterasi',
  },
  showTags: {
    type: Boolean,
    default: false,
  },
});

// We only need the helpers from the composable for item-level rendering
const { readText, readCategory, readTags, hasValidTags } = useTextCollection({ showTags: props.showTags });

const titleText = computed(() => props.item?.judul || 'Tanpa Judul');
const categoryText = computed(() => readCategory(props.item));
const tags = computed(() => readTags(props.item));
const hasTags = computed(() => hasValidTags(props.item));
</script>

<template>
  <div class="item-card" :class="{ 'has-tags': hasTags }">
    <div class="item-header">
      <h3 class="item-title">{{ titleText }}</h3>
      <span class="item-category">{{ categoryText }}</span>
    </div>

    <div class="item-content">
      <p v-if="readText(item, 'teks_arab') !== '-'" class="item-arabic" dir="rtl">
        {{ readText(item, 'teks_arab') }}
      </p>

      <p v-if="readText(item, transliterationKey) !== '-'" class="item-transliteration">
        {{ readText(item, transliterationKey) }}
      </p>

      <p v-if="readText(item, translationKey) !== '-'" class="item-translation">
        {{ readText(item, translationKey) }}
      </p>
    </div>

    <div v-if="showTags && tags.length > 0" class="tags-container">
      <span
        v-for="(tag, index) in tags"
        :key="`${item.id || item.judul}-tag-${index}`"
        class="tag"
      >
        #{{ tag }}
      </span>
    </div>
  </div>
</template>

<style scoped>
.item-card {
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  padding: 0.75rem;
  background: #f8fafc;
  transition: all 0.2s ease;
}

.item-card:hover {
  border-color: #cbd5e1;
  background: #ffffff;
  transform: translateY(-1px);
}

.item-header {
  display: flex;
  gap: 0.5rem;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 0.5rem;
}

.item-title {
  font-size: 0.875rem;
  font-weight: 700;
  color: #0f172a;
  line-height: 1.4;
  word-break: break-word;
}

.item-category {
  border-radius: 999px;
  font-size: 0.625rem;
  font-weight: 700;
  padding: 0.1875rem 0.5rem;
  background: #e2e8f0;
  color: #334155;
  white-space: nowrap;
}

.item-content { display: flex; flex-direction: column; gap: 0.25rem; }

.item-arabic { font-size: 1.125rem; color: #0f172a; line-height: 1.6; font-family: 'Amiri', 'Traditional Arabic', serif; }
.item-transliteration { font-size: 0.75rem; color: #475569; font-style: italic; line-height: 1.5; }
.item-translation { font-size: 0.8125rem; color: #1e293b; line-height: 1.5; }

.tags-container { margin-top: 0.5rem; display: flex; gap: 0.25rem; flex-wrap: wrap; }
.tag { border-radius: 999px; font-size: 0.625rem; font-weight: 700; padding: 0.1875rem 0.5rem; background: #dbeafe; color: #1e3a8a; transition: background-color 0.2s ease; }
.tag:hover { background: #bfdbfe; }

.item-card.has-tags { padding-bottom: 0.5rem; }
</style>
