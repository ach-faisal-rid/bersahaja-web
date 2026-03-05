<script setup>
import { computed, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';

const props = defineProps({
    adzans: {
        type: Array,
        default: () => [],
    },
});

const search = ref('');
const page = usePage();
const canManage = computed(() => Boolean(page.props?.auth?.user));

const destroy = (id) => {
    if (!id) return;
    if (window.confirm('Hapus adzan ini?')) {
        router.delete(`/adzan/${id}`);
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Adzan" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex items-center justify-between mb-6">
                            <h1 class="text-2xl font-bold text-gray-900">Kelola Adzan</h1>
                            <PrimaryButton v-if="canManage">
                                <Link href="/adzan/create" class="text-white">Tambah Adzan</Link>
                            </PrimaryButton>
                        </div>

                        <div class="mb-4">
                            <TextInput
                                v-model="search"
                                @input="submitSearch"
                                placeholder="Cari adzan..."
                                class="w-full"
                            />
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teks Arab</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="adzan in adzans" :key="adzan.id">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 capitalize">
                                            {{ adzan.waktu }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                            {{ adzan.teks_arab.substring(0, 50) }}...
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <SecondaryButton>
                                                    <Link :href="`/adzan/${adzan.id}/edit`" class="text-blue-600">Edit</Link>
                                                </SecondaryButton>
                                                <DangerButton @click="destroy(adzan.id)">
                                                    Hapus
                                                </DangerButton>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>