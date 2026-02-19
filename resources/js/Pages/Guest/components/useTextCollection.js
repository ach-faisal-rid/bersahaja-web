import { computed } from 'vue';

export function useTextCollection(options = {}) {
  const ACCENT_CLASSES = {
    teal: 'is-teal',
    amber: 'is-amber',
  };

  const accentClass = computed(() => ACCENT_CLASSES[options.accent] || ACCENT_CLASSES.teal);

  const itemCountLabel = computed(() => {
    const items = Array.isArray(options.items) ? options.items : [];
    const count = items.length;
    return `${count} ${count === 1 ? 'item' : 'item'}`;
  });

  const readText = (item, key) => {
    if (!item || typeof item !== 'object') return '-';
    const value = item[key];
    return value?.toString().trim() || '-';
  };

  const readCategory = (item) => {
    const categoryName = item?.category?.nama;
    return categoryName?.trim() || 'Umum';
  };

  const readTags = (item) => {
    const tags = item?.tags;
    if (!Array.isArray(tags)) return [];
    return tags.map(t => t?.nama).filter(Boolean).map(s => s.toString().trim());
  };

  const hasValidTags = (item) => {
    const showTags = options.showTags === true;
    return showTags && readTags(item).length > 0;
  };

  return {
    ACCENT_CLASSES,
    accentClass,
    itemCountLabel,
    readText,
    readCategory,
    readTags,
    hasValidTags,
  };
}
