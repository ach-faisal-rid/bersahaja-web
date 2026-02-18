<script setup>
import { computed, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';

const props = defineProps({
    bacaans: {
        type: [Array, Object],
        default: () => [],
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
});

const rows = computed(() => {
    if (Array.isArray(props.bacaans)) {
        return props.bacaans;
    }
    return props.bacaans?.data ?? [];
});

const search = ref(props.filters?.search ?? '');
const page = usePage();
const canManage = computed(() => Boolean(page.props?.auth?.user));

const submitSearch = () => {
    router.get(
        '/bacaan',
        { search: search.value },
        { preserveState: true, replace: true }
    );
};

const destroy = (id) => {
    if (!id) return;
    if (window.confirm('Hapus bacaan ini?')) {
        router.delete(`/bacaan/${id}`);
    }
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
</script>

<template>
    <Head title="Bacaan Shalat" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Bacaan Shalat
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Kelola doa-doa dan bacaan yang digunakan dalam shalat.
                </p>

                <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:items-center">
                    <form
                        class="flex w-full items-center gap-2 sm:w-72"
                        @submit.prevent="submitSearch"
                    >
                        <TextInput
                            v-model="search"
                            type="text"
                            class="block w-full text-sm"
                            placeholder="Cari bacaan..."
                        />
                        <button
                            type="submit"
                            class="inline-flex items-center rounded-md border bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 dark:border-gray-600"
                        >
                            Cari
                        </button>
                    </form>

                    <Link v-if="canManage" href="/bacaan/create">
                        <PrimaryButton>Tambah</PrimaryButton>
                    </Link>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white shadow dark:border-gray-700 dark:bg-gray-800">
                <table class="w-full table-auto">
                    <thead class="border-b border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-50">
                                #
                            </th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-50">
                                Nama Bacaan
                            </th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-50">
                                Kategori
                            </th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-50">
                                Deskripsi
                            </th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-50">
                                Dibuat
                            </th>
                            <th
                                v-if="canManage"
                                class="px-4 py-3 text-center text-sm font-semibold text-gray-900 dark:text-gray-50"
                            >
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <tr
                            v-for="(item, index) in rows"
                            :key="item.id"
                            class="hover:bg-gray-50 dark:hover:bg-gray-700"
                        >
                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                {{ index + 1 }}
                            </td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-50">
                                <Link :href="`/bacaan/${item.id}`" class="hover:underline">
                                    {{ item.nama_bacaan }}
                                </Link>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                <span v-if="item.kategori" class="inline-block rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                    {{ item.kategori }}
                                </span>
                                <span v-else class="text-gray-500">-</span>
                            </td>
                            <td class="max-w-xs truncate px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                {{ item.deskripsi ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                {{ formatDate(item.created_at) }}
                            </td>
                            <td v-if="canManage" class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <Link :href="`/bacaan/${item.id}`">
                                        <SecondaryButton>Lihat</SecondaryButton>
                                    </Link>
                                    <Link :href="`/bacaan/${item.id}/edit`">
                                        <SecondaryButton>Edit</SecondaryButton>
                                    </Link>
                                    <DangerButton @click="destroy(item.id)">
                                        Hapus
                                    </DangerButton>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="rows.length === 0">
                            <td :colspan="canManage ? 6 : 5" class="px-4 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                Tidak ada data.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div
                v-if="props.bacaans?.links"
                class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-3 dark:border-gray-700 dark:bg-gray-800"
            >
                <div class="text-sm text-gray-600 dark:text-gray-300">
                    Menampilkan
                    <span class="font-semibold">{{ props.bacaans?.from ?? 0 }}</span>
                    hingga
                    <span class="font-semibold">{{ props.bacaans?.to ?? 0 }}</span>
                    dari
                    <span class="font-semibold">{{ props.bacaans?.total ?? 0 }}</span>
                    hasil
                </div>
                <div class="flex gap-2">
                    <Link
                        v-for="link in props.bacaans?.links"
                        v-show="link.url"
                        :key="link.label"
                        :href="link.url || '#'"
                        :class="{ 'opacity-50': !link.url }"
                        class="rounded border border-gray-300 px-3 py-1 text-sm dark:border-gray-600"
                        v-html="link.label"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
