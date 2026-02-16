<script setup>
import { computed, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    doas: {
        type: [Array, Object],
        default: () => [],
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
});

const rows = computed(() => {
    if (Array.isArray(props.doas)) {
        return props.doas;
    }
    return props.doas?.data ?? [];
});

const pagination = computed(() => {
    if (Array.isArray(props.doas)) {
        return null;
    }
    return props.doas?.links ?? null;
});

const truncate = (text, length = 30) => {
    if (!text) return '-';
    if (text.length <= length) return text;
    return text.substring(0, length) + '...';
};

const search = ref(props.filters?.search ?? '');

const submitSearch = () => {
    router.get(
        '/doas',
        { search: search.value },
        { preserveState: true, replace: true }
    );
};

const formatDate = (value) => {
    if (!value) return '-';
    const date = new Date(value);
    if (Number.isNaN(date.getTime())) return '-';
    return new Intl.DateTimeFormat('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    }).format(date);
};

const deleteDoa = (doaId) => {
    if (confirm('Apakah Anda yakin ingin menghapus doa ini?')) {
        router.delete(`/doas/${doaId}`, {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="Doa" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Doa
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Kelola data doa.
                </p>

                <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:items-center">
                    <form
                        class="flex w-full items-center gap-2 sm:w-72"
                        @submit.prevent="submitSearch"
                    >
                        <TextInput
                            v-model="search"
                            class="w-full"
                            placeholder="Cari judul doa"
                        />
                        <SecondaryButton type="submit">Cari</SecondaryButton>
                    </form>

                    <Link href="/doas/create">
                        <PrimaryButton>Tambah Doa</PrimaryButton>
                    </Link>
                </div>
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
                                    Remote ID
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Source
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Kategori
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Status
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Dibuat
                                </th>
                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                            <tr v-if="rows.length === 0">
                                <td class="px-4 py-10 text-center text-sm text-gray-500 dark:text-gray-400" colspan="7">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p>Belum ada doa. Tambahkan doa pertama.</p>
                                    </div>
                                </td>
                            </tr>
                            <tr
                                v-for="doa in rows"
                                :key="doa.id"
                                class="text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors"
                            >
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900 dark:text-gray-100 max-w-xs">
                                        <div class="truncate" :title="doa.judul">
                                            {{ doa.judul }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-gray-500 dark:text-gray-400 max-w-xs">
                                        <div class="truncate font-mono text-xs" :title="doa.remote_id">
                                            {{ doa.remote_id || '-' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-gray-500 dark:text-gray-400 max-w-xs">
                                        <div class="truncate text-xs" :title="doa.source">
                                            {{ doa.source || '-' }}
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
                                <td class="px-4 py-3 text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                    {{ formatDate(doa.created_at) }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <Link :href="`/doas/${doa.id}/edit`">
                                            <SecondaryButton class="text-xs px-3 py-1.5">
                                                Edit
                                            </SecondaryButton>
                                        </Link>
                                        <DangerButton
                                            type="button"
                                            class="text-xs px-3 py-1.5"
                                            @click="deleteDoa(doa.id)"
                                        >
                                            Hapus
                                        </DangerButton>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div v-if="pagination && pagination.length > 3" class="border-t border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/40 px-4 py-3 sm:px-6">
                    <div class="flex flex-1 justify-between sm:hidden">
                        <Link
                            v-if="pagination[0]?.url"
                            :href="pagination[0].url"
                            class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                        >
                            Sebelumnya
                        </Link>
                        <Link
                            v-if="pagination[pagination.length - 1]?.url"
                            :href="pagination[pagination.length - 1].url"
                            class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                        >
                            Selanjutnya
                        </Link>
                    </div>
                    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                Menampilkan
                                <span class="font-medium">{{ props.doas?.from ?? 0 }}</span>
                                sampai
                                <span class="font-medium">{{ props.doas?.to ?? 0 }}</span>
                                dari
                                <span class="font-medium">{{ props.doas?.total ?? 0 }}</span>
                                hasil
                            </p>
                        </div>
                        <div>
                            <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
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
            </div>
        </div>
    </AuthenticatedLayout>
</template>
