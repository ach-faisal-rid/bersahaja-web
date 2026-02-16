<script setup>
import { computed, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    repositories: {
        type: [Array, Object],
        default: () => [],
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
});

const rows = computed(() => {
    if (Array.isArray(props.repositories)) {
        return props.repositories;
    }
    return props.repositories?.data ?? [];
});

const search = ref(props.filters?.search ?? '');

const submitSearch = () => {
    router.get(
        '/repositories',
        { search: search.value },
        { preserveState: true, replace: true }
    );
};

const destroy = (id) => {
    if (!id) return;
    if (window.confirm('Hapus Repositori ini?')) {
        router.delete(`/repositories/${id}`);
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
    <Head title="Repositori" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Repositori
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Kelola data Repositori.
                </p>

                <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:items-center">
                    <form
                        class="flex w-full items-center gap-2 sm:w-72"
                        @submit.prevent="submitSearch"
                    >
                        <TextInput
                            v-model="search"
                            class="w-full"
                            placeholder="Cari nama Repositori"
                        />
                        <SecondaryButton type="submit">Cari</SecondaryButton>
                    </form>

                    <Link href="/repositories/create">
                        <PrimaryButton>Tambah Repositori</PrimaryButton>
                    </Link>
                </div>
            </div>

            <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                        <thead class="bg-gray-50 dark:bg-gray-900/40">
                            <tr class="text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Dibuat</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-800 dark:bg-gray-900/20">
                            <tr v-if="rows.length === 0">
                                <td class="px-4 py-10 text-center text-sm text-gray-500 dark:text-gray-400" colspan="3">
                                    Belum ada Repositori. Tambahkan Repositori pertama.
                                </td>
                            </tr>
                            <tr
                                v-for="Repositori in rows"
                                :key="Repositori.id"
                                class="text-sm text-gray-700 dark:text-gray-200"
                            >
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ Repositori.nama }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                                    {{ formatDate(Repositori.created_at ?? '-') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-2">
                                        <Link :href="`/repositories/${Repositori.id}/edit`">
                                            <SecondaryButton>Edit</SecondaryButton>
                                        </Link>
                                        <DangerButton @click="destroy(Repositori.id)">Hapus</DangerButton>
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
