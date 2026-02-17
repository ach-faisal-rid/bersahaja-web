<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    pagination: {
        type: Array,
        default: null,
    },
    from: {
        type: Number,
        default: 0,
    },
    to: {
        type: Number,
        default: 0,
    },
    total: {
        type: Number,
        default: 0,
    },
});
</script>

<template>
    <div v-if="pagination && pagination.length > 3" class="px-4 py-3 border-t border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/40 sm:px-6">
        <div class="flex justify-between flex-1 sm:hidden">
            <Link
                v-if="pagination[0]?.url"
                :href="pagination[0].url"
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
            >
                Sebelumnya
            </Link>
            <Link
                v-if="pagination[pagination.length - 1]?.url"
                :href="pagination[pagination.length - 1].url"
                class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
            >
                Selanjutnya
            </Link>
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    Menampilkan
                    <span class="font-medium">{{ from }}</span>
                    sampai
                    <span class="font-medium">{{ to }}</span>
                    dari
                    <span class="font-medium">{{ total }}</span>
                    hasil
                </p>
            </div>
            <div>
                <nav class="inline-flex -space-x-px rounded-md shadow-sm isolate" aria-label="Pagination">
                    <Link
                        v-for="(link, index) in pagination"
                        :key="index"
                        :href="link.url || '#'"
                        :class="[
                            'relative inline-flex items-center px-4 py-2 text-sm font-semibold',
                            index === 0 ? 'rounded-l-md' : '',
                            index === pagination.length - 1 ? 'rounded-r-md' : '',
                            link.active
                                ? 'z-10 bg-indigo-600 text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600'
                                : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-700 dark:hover:bg-gray-700',
                            !link.url ? 'pointer-events-none opacity-50' : ''
                        ]"
                    >
                        <span v-html="link.label"></span>
                    </Link>
                </nav>
            </div>
        </div>
    </div>
</template>
