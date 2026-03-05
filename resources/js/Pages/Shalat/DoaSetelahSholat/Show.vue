<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    doa: {
        type: Object,
        default: () => ({}),
    },
});
</script>

<template>
    <GuestLayout>
        <Head :title="doa.judul" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex items-center justify-between mb-6">
                            <h1 class="text-2xl font-bold text-gray-900">{{ doa.judul }}</h1>
                            <Link href="/doa-setelah-sholat" class="text-blue-600 hover:text-blue-800">← Kembali ke Daftar Doa</Link>
                        </div>

                        <div class="space-y-8">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Teks Arab</h3>
                                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-lg p-8 shadow-sm">
                                    <p class="text-right text-2xl leading-loose font-arabic text-gray-900 whitespace-pre-line tracking-wider">{{ doa.teks_arab }}</p>
                                </div>
                            </div>

                            <div v-if="doa.transliterasi">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Transliterasi</h3>
                                <div class="bg-gray-50 border-l-4 border-green-500 rounded-lg p-6 shadow-sm">
                                    <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ doa.transliterasi }}</p>
                                </div>
                            </div>

                            <div v-if="doa.terjemahan">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Terjemahan</h3>
                                <div class="bg-amber-50 border-l-4 border-amber-500 rounded-lg p-6 shadow-sm">
                                    <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ doa.terjemahan }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>