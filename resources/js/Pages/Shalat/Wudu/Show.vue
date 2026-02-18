<script setup>
import { computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

const props = defineProps({
    wudu: {
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
    <Head :title="`${wudu.nama_langkah}`" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ wudu.nama_langkah }}
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Detail langkah wudu lengkap.
                </p>
                <div class="flex gap-2">
                    <Link v-if="canManage" :href="`/wudu/${wudu.id}/edit`">
                        <SecondaryButton>Edit</SecondaryButton>
                    </Link>
                    <Link href="/wudu">
                        <SecondaryButton>Kembali</SecondaryButton>
                    </Link>
                </div>
            </div>

            <div class="space-y-4">
                <!-- Urutan -->
                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow dark:border-gray-700 dark:bg-gray-800">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Urutan Langkah
                    </label>
                    <p class="mt-2 text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                        {{ wudu.urutan }}
                    </p>
                </div>

                <!-- Deskripsi -->
                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow dark:border-gray-700 dark:bg-gray-800">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Deskripsi
                    </label>
                    <p class="mt-2 whitespace-pre-wrap text-sm text-gray-600 dark:text-gray-400">
                        {{ wudu.deskripsi }}
                    </p>
                </div>

                <!-- Doa Arab -->
                <div v-if="wudu.doa_arab" class="rounded-lg border border-gray-200 bg-white p-4 shadow dark:border-gray-700 dark:bg-gray-800">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Doa Arab
                    </label>
                    <div class="mt-2 rounded bg-gray-50 p-4 text-right dark:bg-gray-700">
                        <p class="whitespace-pre-wrap text-lg text-gray-800 dark:text-gray-100">
                            {{ wudu.doa_arab }}
                        </p>
                    </div>
                </div>

                <!-- Transliterasi -->
                <div v-if="wudu.transliterasi" class="rounded-lg border border-gray-200 bg-white p-4 shadow dark:border-gray-700 dark:bg-gray-800">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Transliterasi (Latin)
                    </label>
                    <div class="mt-2 rounded bg-gray-50 p-4 dark:bg-gray-700">
                        <p class="whitespace-pre-wrap text-sm italic text-gray-800 dark:text-gray-100">
                            {{ wudu.transliterasi }}
                        </p>
                    </div>
                </div>

                <!-- Terjemahan -->
                <div v-if="wudu.terjemahan" class="rounded-lg border border-gray-200 bg-white p-4 shadow dark:border-gray-700 dark:bg-gray-800">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Terjemahan Indonesia
                    </label>
                    <div class="mt-2 rounded bg-gray-50 p-4 dark:bg-gray-700">
                        <p class="whitespace-pre-wrap text-sm text-gray-800 dark:text-gray-100">
                            {{ wudu.terjemahan }}
                        </p>
                    </div>
                </div>

                <!-- Tips Penting -->
                <div v-if="wudu.tips_penting" class="rounded-lg border border-amber-200 bg-amber-50 p-4 shadow dark:border-amber-900 dark:bg-amber-900/20">
                    <label class="block text-sm font-semibold text-amber-900 dark:text-amber-200">
                        💡 Tips Penting
                    </label>
                    <div class="mt-2 rounded bg-white p-3 dark:bg-gray-800">
                        <p class="whitespace-pre-wrap text-sm text-gray-800 dark:text-gray-100">
                            {{ wudu.tips_penting }}
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
                                {{ formatDate(wudu.created_at) }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300">
                                Diperbarui pada
                            </label>
                            <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">
                                {{ formatDate(wudu.updated_at) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
