<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    tataCara: {
        type: Object,
        default: () => ({}),
    },
});

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
    <Head :title="`${tataCara.nama_langkah}`" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ tataCara.nama_langkah }}
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Detail tata cara shalat.
                </p>
                <Link href="/tata-cara">
                    <SecondaryButton>Kembali</SecondaryButton>
                </Link>
            </div>

            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow dark:border-gray-700 dark:bg-gray-800">
                <div class="grid gap-6 md:grid-cols-2">
                    <!-- Urutan -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Urutan
                        </label>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ tataCara.urutan }}
                        </p>
                    </div>

                    <!-- Gerakan -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Gerakan Shalat
                        </label>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ tataCara.gerakan?.nama_gerakan ?? '-' }}
                        </p>
                    </div>

                    <!-- Deskripsi -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Deskripsi
                        </label>
                        <p class="mt-2 whitespace-pre-wrap text-sm text-gray-600 dark:text-gray-400">
                            {{ tataCara.deskripsi }}
                        </p>
                    </div>

                    <!-- Bacaan Arab -->
                    <div v-if="tataCara.bacaan_arab" class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Bacaan Arab
                        </label>
                        <p class="mt-2 whitespace-pre-wrap text-sm text-gray-600 dark:text-gray-400">
                            {{ tataCara.bacaan_arab }}
                        </p>
                    </div>

                    <!-- Transliterasi -->
                    <div v-if="tataCara.transliterasi" class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Transliterasi
                        </label>
                        <p class="mt-2 whitespace-pre-wrap text-sm text-gray-600 dark:text-gray-400">
                            {{ tataCara.transliterasi }}
                        </p>
                    </div>

                    <!-- Terjemahan -->
                    <div v-if="tataCara.terjemahan" class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Terjemahan
                        </label>
                        <p class="mt-2 whitespace-pre-wrap text-sm text-gray-600 dark:text-gray-400">
                            {{ tataCara.terjemahan }}
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
                                    {{ formatDate(tataCara.created_at) }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300">
                                    Diperbarui pada
                                </label>
                                <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                                    {{ formatDate(tataCara.updated_at) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
