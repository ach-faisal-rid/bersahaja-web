<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    iqamat: {
        type: Object,
        required: true,
    },
    waktuIcons: {
        type: Object,
        required: true,
    },
    waktuColors: {
        type: Object,
        required: true,
    },
    waktuGradients: {
        type: Object,
        required: true,
    },
    waktuLabels: {
        type: Object,
        required: true,
    },
});

const truncateText = (value, limit = 80) => {
    const text = (value ?? '').trim();
    if (text.length <= limit) return text;

    return `${text.slice(0, limit).trimEnd()}...`;
};

const normalizeText = (value) => (value ?? '').trim();
</script>

<template>
    <Link
        :href="`/iqamat/${iqamat.waktu}`"
        class="relative w-full overflow-hidden transition-all duration-300 bg-white shadow-lg group rounded-2xl hover:shadow-2xl hover:-translate-y-2"
    >
        <div :class="`absolute top-0 left-0 right-0 h-1 bg-gradient-to-r ${waktuColors[iqamat.waktu]}`" />

        <div :class="`${waktuGradients[iqamat.waktu]} px-6 py-5`">
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <span class="text-4xl">{{ waktuIcons[iqamat.waktu] }}</span>
                    <div class="min-w-0">
                        <h3 class="text-xl font-bold text-gray-900 capitalize truncate">
                            {{ waktuLabels[iqamat.waktu] }}
                        </h3>
                        <p class="text-sm text-gray-600">Waktu {{ waktuLabels[iqamat.waktu] }}</p>
                    </div>
                </div>
                <span class="shrink-0 px-3 py-1 text-xs font-medium text-gray-600 rounded-full shadow-sm bg-white/80 backdrop-blur-sm">
                    Iqamat
                </span>
            </div>
        </div>

        <div class="relative px-6 py-5">
            <span class="absolute font-serif text-6xl text-gray-100 select-none top-2 right-8">"</span>

            <div class="relative z-10">
                <p class="mb-3 text-lg font-medium text-right text-gray-800 font-arabic arabic-preview" dir="rtl">
                    {{ normalizeText(iqamat.teks_arab) }}
                </p>

                <p v-if="iqamat.teks_latin" class="pt-3 text-sm italic text-gray-500 border-t border-gray-100 latin-preview">
                    {{ truncateText(iqamat.teks_latin, 70) }}
                </p>
            </div>
        </div>

        <div class="flex items-center justify-between px-6 py-4 transition-all duration-300 border-t border-gray-100 bg-gray-50/80 group-hover:bg-gradient-to-r group-hover:from-blue-50 group-hover:to-indigo-50">
            <span class="flex items-center gap-2 text-sm font-medium text-gray-600 group-hover:text-blue-700">
                <span class="flex items-center justify-center w-6 h-6 text-xs text-blue-600 transition-all bg-white rounded-full shadow-sm group-hover:bg-blue-600 group-hover:text-white">
                    📖
                </span>
                Lihat Teks Lengkap
            </span>
            <span class="text-lg text-gray-400 transition-transform group-hover:translate-x-1 group-hover:text-blue-600">→</span>
        </div>

        <div class="absolute inset-0 transition-all pointer-events-none rounded-2xl group-hover:ring-2 group-hover:ring-blue-200" />
    </Link>
</template>

<style scoped>
.font-arabic {
    font-family: 'Amiri', 'Traditional Arabic', 'Scheherazade', serif;
    line-height: 2;
}

.arabic-preview {
    display: -webkit-box;
    overflow: hidden;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 4;
}

.latin-preview {
    display: -webkit-box;
    overflow: hidden;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
}
</style>
