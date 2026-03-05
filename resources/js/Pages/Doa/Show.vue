<script setup>
import { computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

const props = defineProps({
    doa: {
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
    <Head title="Detail Doa" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Detail Doa
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Informasi lengkap doa dan relasi tag.
                </p>
                <div class="flex items-center gap-2">
                    <Link v-if="canManage" :href="`/doas/${props.doa?.id}/tags`">
                        <SecondaryButton>Kelola Tag</SecondaryButton>
                    </Link>
                    <Link href="/doas">
                        <SecondaryButton>Kembali</SecondaryButton>
                    </Link>
                </div>
            </div>

            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900/20">
                <div class="grid gap-4 p-6 md:grid-cols-2">
                    <div>
                        <p class="text-xs uppercase tracking-wider text-gray-500">Judul</p>
                        <p class="text-base font-semibold text-gray-900 dark:text-gray-100">{{ props.doa?.judul || '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider text-gray-500">Kategori</p>
                        <p class="text-base text-gray-900 dark:text-gray-100">{{ props.doa?.category?.nama || '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider text-gray-500">Remote ID</p>
                        <p class="text-sm font-mono text-gray-900 dark:text-gray-100">{{ props.doa?.remote_id || '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider text-gray-500">Sumber</p>
                        <p class="text-sm text-gray-900 dark:text-gray-100 break-all">{{ props.doa?.source || '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider text-gray-500">Status</p>
                        <span
                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"
                            :class="props.doa?.is_active
                                ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300'
                                : 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300'"
                        >
                            {{ props.doa?.is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider text-gray-500">Dibuat</p>
                        <p class="text-sm text-gray-900 dark:text-gray-100">{{ formatDate(props.doa?.created_at) }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs uppercase tracking-wider text-gray-500">Tags</p>
                        <div class="mt-1 flex flex-wrap gap-2">
                            <span
                                v-if="!props.doa?.tags || props.doa.tags.length === 0"
                                class="text-sm text-gray-500"
                            >
                                -
                            </span>
                            <span
                                v-for="tag in (props.doa?.tags || [])"
                                :key="tag.id"
                                class="inline-flex items-center rounded-full bg-slate-100 px-2 py-1 text-xs font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-200"
                            >
                                {{ tag.nama }}
                            </span>
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs uppercase tracking-wider text-gray-500 mb-3">Teks Arab</p>
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-l-4 border-blue-500 dark:from-gray-700 dark:to-gray-600 dark:border-blue-400 rounded-lg p-6 shadow-sm">
                            <p class="text-right text-xl leading-loose font-arabic text-gray-900 dark:text-gray-100 whitespace-pre-wrap tracking-wider">{{ props.doa?.teks_arab || '-' }}</p>
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs uppercase tracking-wider text-gray-500 mb-3">Transliterasi</p>
                        <div class="bg-gray-50 border-l-4 border-green-500 dark:bg-gray-700 dark:border-green-400 rounded-lg p-6 shadow-sm">
                            <p class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap leading-relaxed">{{ props.doa?.transliterasi || '-' }}</p>
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs uppercase tracking-wider text-gray-500 mb-3">Terjemahan</p>
                        <div class="bg-amber-50 border-l-4 border-amber-500 dark:bg-gray-700 dark:border-amber-400 rounded-lg p-6 shadow-sm">
                            <p class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap leading-relaxed">{{ props.doa?.terjemahan || '-' }}</p>
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs uppercase tracking-wider text-gray-500">Deskripsi</p>
                        <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ props.doa?.description || '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
