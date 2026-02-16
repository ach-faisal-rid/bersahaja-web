<script setup>
import { computed, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    users: {
        type: [Array, Object],
        default: () => [],
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
});

const rows = computed(() => {
    if (Array.isArray(props.users)) {
        return props.users;
    }
    return props.users?.data ?? [];
});

const search = ref(props.filters?.search ?? '');

const submitSearch = () => {
    router.get(
        '/users',
        { search: search.value },
        { preserveState: true, replace: true }
    );
};

const destroy = (id) => {
    if (!id) return;
    if (window.confirm('Hapus user ini?')) {
        router.delete(`/users/${id}`);
    }
};

// Format tanggal (aman untuk nilai kosong/invalid)
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
    <Head title="Users" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Users
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        Kelola data pengguna, akses, dan status akun.
                    </p>
                </div>

                <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:items-center">
                    <form
                        class="flex w-full items-center gap-2 sm:w-72"
                        @submit.prevent="submitSearch"
                    >
                        <TextInput
                            v-model="search"
                            class="w-full"
                            placeholder="Cari nama atau email"
                        />
                        <SecondaryButton type="submit">Cari</SecondaryButton>
                    </form>

                    <Link href="/users/create">
                        <PrimaryButton>Tambah User</PrimaryButton>
                    </Link>
                </div>
            </div>

            <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                        <thead class="bg-gray-50 dark:bg-gray-900/40">
                            <tr class="text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Role</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Dibuat</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-800 dark:bg-gray-900/20">
                            <tr v-if="rows.length === 0">
                                <td class="px-4 py-10 text-center text-sm text-gray-500 dark:text-gray-400" colspan="6">
                                    Belum ada user. Tambahkan user pertama kamu.
                                </td>
                            </tr>
                            <tr v-for="user in rows" :key="user.id" class="text-sm text-gray-700 dark:text-gray-200">
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ user.name }}
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    {{ user.email }}
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"
                                        :class="user.role === 'admin'
                                            ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300'
                                            : 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300'"
                                    >
                                        {{ user.role || 'user' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"
                                        :class="user.email_verified_at
                                            ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300'
                                            : 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300'"
                                    >
                                        {{ user.email_verified_at ? 'Aktif' : 'Pending' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                                    {{formatDate( user.created_at ?? '-' )}}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-2">
                                        <Link :href="`/users/${user.id}`">
                                            <SecondaryButton>Lihat</SecondaryButton>
                                        </Link>
                                        <Link :href="`/users/${user.id}/edit`">
                                            <SecondaryButton>Edit</SecondaryButton>
                                        </Link>
                                        <DangerButton @click="destroy(user.id)">Hapus</DangerButton>
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
