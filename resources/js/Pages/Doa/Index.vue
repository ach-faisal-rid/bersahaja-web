<script setup>
import { computed, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DoaListToolbar from './components/DoaListToolbar.vue';
import DoaTable from './components/DoaTable.vue';
import DoaPagination from './components/DoaPagination.vue';
import { Head, router, usePage } from '@inertiajs/vue3';

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

const search = ref(props.filters?.search ?? '');
const status = ref(props.filters?.status ?? 'all');
const page = usePage();
const canManage = computed(() => Boolean(page.props?.auth?.user));

const submitSearch = () => {
    router.get(
        '/doas',
        { search: search.value, status: status.value },
        { preserveState: true, replace: true }
    );
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
            <DoaListToolbar
                v-model="search"
                :status-value="status"
                :can-manage="canManage"
                @update:status-value="status = $event"
                @search="submitSearch"
            />

            <DoaTable :rows="rows" :can-manage="canManage" @delete="deleteDoa" />

            <DoaPagination
                :pagination="pagination"
                :from="props.doas?.from ?? 0"
                :to="props.doas?.to ?? 0"
                :total="props.doas?.total ?? 0"
            />
        </div>
    </AuthenticatedLayout>
</template>
