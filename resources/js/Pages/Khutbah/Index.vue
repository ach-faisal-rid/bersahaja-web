<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    khutbahs: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <GuestLayout>
        <Head title="Khutbah" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Header Section -->
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">Khutbah</h1>
                            <p class="text-gray-600">Khutbah Jumat dan nasihat keagamaan dari para ulama</p>
                        </div>
                        <Link href="/" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition-colors">
                            ← Kembali ke Beranda
                        </Link>
                    </div>
                </div>

                <!-- Content Grid -->
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <Link 
                        v-for="khutbah in khutbahs" 
                        :key="khutbah.id" 
                        :href="`/khutbah/${khutbah.id}`"
                        class="group bg-white overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 hover:-translate-y-1"
                    >
                        <!-- Card Icon & Title -->
                        <div class="bg-gradient-to-br from-emerald-50 to-teal-50 px-6 py-4 border-b border-emerald-100">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="text-3xl">📖</span>
                                <h3 class="text-lg font-bold text-gray-900 line-clamp-2">{{ khutbah.judul }}</h3>
                            </div>
                        </div>

                        <!-- Arabic Text -->
                        <div class="px-6 py-5">
                            <p class="text-right text-sm leading-relaxed font-arabic text-gray-800 line-clamp-5 mb-4 group-hover:text-emerald-700 transition-colors">
                                {{ khutbah.teks_arab }}
                            </p>
                        </div>

                        <!-- Footer -->
                        <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between group-hover:bg-emerald-50 transition-colors">
                            <span class="text-sm text-gray-600 group-hover:text-emerald-700 font-medium">Lihat Lengkap</span>
                            <span class="text-lg group-hover:translate-x-1 transition-transform">→</span>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>