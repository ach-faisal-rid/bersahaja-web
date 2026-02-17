<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    rows: {
        type: Array,
        default: () => [],
    },
});

defineEmits(['delete']);
</script>

<template>
    <div class="overflow-hidden bg-white border border-gray-200 rounded-xl dark:border-gray-800 dark:bg-gray-900/20">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                <thead class="bg-gray-50 dark:bg-gray-900/40">
                    <tr>
                        <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            Judul
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            Kategori
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase dark:text-gray-400">
                            Status
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    <tr v-if="rows.length === 0">
                        <td class="px-4 py-10 text-sm text-center text-gray-500 dark:text-gray-400" colspan="4">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p>Belum ada doa. Tambahkan doa pertama.</p>
                            </div>
                        </td>
                    </tr>
                    <tr
                        v-for="doa in rows"
                        :key="doa.id"
                        class="text-sm text-gray-700 transition-colors dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800/50"
                    >
                        <td class="px-4 py-3">
                            <div class="max-w-xs font-medium text-gray-900 dark:text-gray-100">
                                <div class="truncate" :title="doa.judul">
                                    {{ doa.judul }}
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-gray-500 dark:text-gray-400">
                                {{ doa.category?.nama || '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span
                                class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"
                                :class="doa.is_active
                                    ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300'
                                    : 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300'"
                            >
                                {{ doa.is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <Link :href="`/doas/${doa.id}`">
                                    <SecondaryButton class="text-xs px-3 py-1.5">
                                        Lihat
                                    </SecondaryButton>
                                </Link>
                                <Link :href="`/doas/${doa.id}/edit`">
                                    <SecondaryButton class="text-xs px-3 py-1.5">
                                        Edit
                                    </SecondaryButton>
                                </Link>
                                <DangerButton
                                    type="button"
                                    class="text-xs px-3 py-1.5"
                                    @click="$emit('delete', doa.id)"
                                >
                                    Hapus
                                </DangerButton>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
