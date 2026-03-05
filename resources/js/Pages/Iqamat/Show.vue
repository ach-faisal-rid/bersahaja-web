<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    iqamat: {
        type: Object,
        default: () => ({}),
    },
});
</script>

<template>
    <GuestLayout>
        <Head :title="`Iqamat ${iqamat.waktu}`" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex items-center justify-between mb-6">
                            <h1 class="text-2xl font-bold text-gray-900 capitalize">Iqamat {{ iqamat.waktu }}</h1>
                            <Link href="/iqamat" class="text-blue-600 hover:text-blue-800">← Kembali ke Daftar Iqamat</Link>
                        </div>

                        <div class="space-y-8">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Teks Arab</h3>
                                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-lg p-8 shadow-sm">
                                    <p class="text-right text-2xl leading-loose font-arabic text-gray-900 whitespace-pre-line tracking-wider">{{ iqamat.teks_arab }}</p>
                                </div>
                            </div>

                            <div v-if="iqamat.transliterasi">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Transliterasi</h3>
                                <div class="bg-gray-50 border-l-4 border-green-500 rounded-lg p-6 shadow-sm">
                                    <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ iqamat.transliterasi }}</p>
                                </div>
                            </div>

                            <div v-if="iqamat.terjemahan">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Terjemahan</h3>
                                <div class="bg-amber-50 border-l-4 border-amber-500 rounded-lg p-6 shadow-sm">
                                    <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ iqamat.terjemahan }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>