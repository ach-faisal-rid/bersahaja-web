<script setup>
import { computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

const props = defineProps({
    bacaan: {
        type: Object,
        default: () => ({}),
    },
});

const page = usePage();
const canManage = computed(() => Boolean(page.props?.auth?.user));

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
    <Head :title="`${bacaan.nama_bacaan}`" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ bacaan.nama_bacaan }}
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Detail bacaan shalat lengkap.
                </p>
                <div class="flex gap-2">
                    <Link v-if="canManage" :href="`/bacaan/${bacaan.id}/edit`">
                        <SecondaryButton>Edit</SecondaryButton>
                    </Link>
                    <Link href="/bacaan">
                        <SecondaryButton>Kembali</SecondaryButton>
                    </Link>
                </div>
            </div>

            <div class="space-y-4">
                <!-- Kategori -->
                <div v-if="bacaan.kategori" class="rounded-lg border border-gray-200 bg-white p-4 shadow dark:border-gray-700 dark:bg-gray-800">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Kategori
                    </label>
                    <p class="mt-1 inline-block rounded-full bg-indigo-100 px-3 py-1 text-sm font-semibold text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                        {{ bacaan.kategori }}
                    </p>
                </div>

                <!-- Deskripsi -->
                <div v-if="bacaan.deskripsi" class="rounded-lg border border-gray-200 bg-white p-4 shadow dark:border-gray-700 dark:bg-gray-800">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Deskripsi
                    </label>
                    <p class="mt-2 whitespace-pre-wrap text-sm text-gray-600 dark:text-gray-400">
                        {{ bacaan.deskripsi }}
                    </p>
                </div>

                <!-- Bacaan Arab -->
                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow dark:border-gray-700 dark:bg-gray-800">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Bacaan Arab
                    </label>
                    <div class="mt-2 rounded bg-gray-50 p-4 text-right dark:bg-gray-700">
                        <p class="whitespace-pre-wrap text-lg text-gray-800 dark:text-gray-100">
                            {{ bacaan.bacaan_arab }}
                        </p>
                    </div>
                </div>

                <!-- Transliterasi -->
                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow dark:border-gray-700 dark:bg-gray-800">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Transliterasi (Latin)
                    </label>
                    <div class="mt-2 rounded bg-gray-50 p-4 dark:bg-gray-700">
                        <p class="whitespace-pre-wrap text-sm italic text-gray-800 dark:text-gray-100">
                            {{ bacaan.transliterasi }}
                        </p>
                    </div>
                </div>

                <!-- Terjemahan -->
                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow dark:border-gray-700 dark:bg-gray-800">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Terjemahan Indonesia
                    </label>
                    <div class="mt-2 rounded bg-gray-50 p-4 dark:bg-gray-700">
                        <p class="whitespace-pre-wrap text-sm text-gray-800 dark:text-gray-100">
                            {{ bacaan.terjemahan }}
                        </p>
                    </div>
                </div>

                <!-- Metadata -->
                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow dark:border-gray-700 dark:bg-gray-800">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300">
                                Dibuat pada
                            </label>
                            <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                                {{ formatDate(bacaan.created_at) }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300">
                                Diperbarui pada
                            </label>
                            <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                                {{ formatDate(bacaan.updated_at) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
