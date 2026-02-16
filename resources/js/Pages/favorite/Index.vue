<script setup>
import { computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    favorits: {
        type: Array,
        default: () => [],
    },
});

const rows = computed(() => {
    return props.favorits ?? [];
});

const removeFavorit = (favoritableType, favoritableId) => {
    if (confirm('Apakah Anda yakin ingin menghapus dari favorit?')) {
        router.delete('/favorit/remove', {
            data: {
                favoritable_type: favoritableType,
                favoritable_id: favoritableId,
            },
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="Favorit" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Favorit Saya
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Daftar hadist dan doa yang telah Anda tambahkan ke favorit.
                </p>
                <Link href="/favorit/create" class="self-start sm:self-auto">
                    <PrimaryButton type="button" class="text-xs px-3 py-1.5">
                        Tambah Favorit
                    </PrimaryButton>
                </Link>
            </div>

            <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900/20">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                        <thead class="bg-gray-50 dark:bg-gray-900/40">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Judul
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Jenis
                                </th>
                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                            <tr v-if="rows.length === 0">
                                <td class="px-4 py-10 text-center text-sm text-gray-500 dark:text-gray-400" colspan="3">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        <p>Belum ada favorit. Tambahkan hadist atau doa ke favorit untuk melihatnya di sini.</p>
                                    </div>
                                </td>
                            </tr>
                            <tr
                                v-for="item in rows"
                                :key="item.id"
                                class="text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors"
                            >
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ item.favoritable?.judul || '-' }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex rounded-full bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-700 dark:bg-gray-800 dark:text-gray-200">
                                        {{ item.favoritable_type === 'doa' ? 'Doa' : 'Hadist' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end">
                                        
                                        <DangerButton
                                            v-if="item.favoritable?.id"
                                            type="button"
                                            class="text-xs px-3 py-1.5"
                                            @click="removeFavorit(item.favoritable_type, item.favoritable.id)"
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
        </div>
    </AuthenticatedLayout>
</template>
