<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    gerakan: {
        type: Object,
        default: () => ({}),
    },
});

const getCategoryColor = (kategori) => {
    switch (kategori) {
        case 'Wajib':
            return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
        case 'Sunnah':
            return 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
        case 'makruh':
            return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
        case 'haram':
            return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
        default:
            return 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
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
    <Head :title="`${gerakan.nama_gerakan}`" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ gerakan.nama_gerakan }}
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Detail gerakan shalat.
                </p>
                <Link href="/gerakan-shalat">
                    <SecondaryButton>Kembali</SecondaryButton>
                </Link>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow dark:border-gray-700 dark:bg-gray-800">
                <div class="grid gap-6 md:grid-cols-2">
                    <!-- Urutan -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Urutan Global
                        </label>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ gerakan.urutan_global }}
                        </p>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Kategori
                        </label>
                        <div class="mt-2">
                            <span
                                :class="getCategoryColor(gerakan.kategori)"
                                class="inline-block rounded-full px-4 py-2 text-sm font-semibold"
                            >
                                {{ gerakan.kategori }}
                            </span>
                        </div>
                    </div>

                    <!-- Deskripsi Singkat -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Deskripsi Singkat
                        </label>
                        <p class="mt-2 whitespace-pre-wrap text-sm text-gray-600 dark:text-gray-400">
                            {{ gerakan.deskripsi_singkat }}
                        </p>
                    </div>

                    <!-- Icon URL -->
                    <div v-if="gerakan.icon_url" class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Icon URL
                        </label>
                        <p class="mt-2 break-all text-sm text-gray-600 dark:text-gray-400">
                            {{ gerakan.icon_url }}
                        </p>
                    </div>

                    <!-- Metadata -->
                    <div class="border-t border-gray-200 pt-4 dark:border-gray-700 md:col-span-2">
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300">
                                    Dibuat pada
                                </label>
                                <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                                    {{ formatDate(gerakan.created_at) }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300">
                                    Diperbarui pada
                                </label>
                                <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                                    {{ formatDate(gerakan.updated_at) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
