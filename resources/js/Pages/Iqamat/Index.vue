<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import IqamatCard from './components/IqamatCard.vue';

const waktuIcons = {
    subuh: '🌅',
    dzuhur: '☀️',
    ashar: '🌤️',
    maghrib: '🌅',
    isya: '🌙',
};

const waktuColors = {
    subuh: 'from-orange-400 to-yellow-500',
    dzuhur: 'from-yellow-400 to-amber-500',
    ashar: 'from-blue-400 to-indigo-500',
    maghrib: 'from-red-400 to-orange-500',
    isya: 'from-indigo-400 to-purple-500',
};

const waktuGradients = {
    subuh: 'bg-gradient-to-br from-orange-50 to-yellow-50',
    dzuhur: 'bg-gradient-to-br from-yellow-50 to-amber-50',
    ashar: 'bg-gradient-to-br from-blue-50 to-indigo-50',
    maghrib: 'bg-gradient-to-br from-red-50 to-orange-50',
    isya: 'bg-gradient-to-br from-indigo-50 to-purple-50',
};

defineProps({
    iqamats: {
        type: Array,
        default: () => [],
    },
});

const waktuLabels = {
    subuh: 'Subuh',
    dzuhur: 'Dzuhur',
    ashar: 'Ashar',
    maghrib: 'Maghrib',
    isya: 'Isya',
};
</script>

<template>
    <GuestLayout>
        <Head title="Iqamat" />

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Header Section with Decoration -->
                <div class="mb-12 text-center">
                    <div class="inline-block mb-4">
                        <span class="inline-flex items-center justify-center w-16 h-16 text-3xl text-blue-600 bg-blue-100 shadow-lg rounded-2xl">
                            📿
                        </span>
                    </div>
                    <h1 class="mb-3 text-4xl font-bold text-gray-900">Iqamat</h1>
                    <p class="max-w-2xl mx-auto text-lg text-gray-600">
                        Teks iqamat untuk memulai sholat berjamaah. Klik pada waktu sholat untuk melihat teks lengkapnya.
                    </p>
                    
                    <!-- Quick Stats -->
                    <div class="flex justify-center gap-2 mt-6">
                        <span class="px-3 py-1 text-sm font-medium text-blue-700 rounded-full bg-blue-50">
                            {{ iqamats.length }} Waktu Sholat
                        </span>
                        <span class="px-3 py-1 text-sm font-medium text-green-700 rounded-full bg-green-50">
                            Teks Arab & Latin
                        </span>
                    </div>

                    <!-- Back Button -->
                    <div class="mt-8">
                        <Link href="/" class="inline-flex items-center font-medium text-blue-600 transition-all hover:text-blue-800 hover:gap-2 group">
                            <span class="mr-1 transition-transform group-hover:-translate-x-1">←</span>
                            Kembali ke Beranda
                        </Link>
                    </div>
                </div>

                <!-- Content Grid with improved cards -->
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <IqamatCard
                        v-for="iqamat in iqamats" 
                        :key="iqamat.id" 
                        :iqamat="iqamat"
                        :waktu-icons="waktuIcons"
                        :waktu-colors="waktuColors"
                        :waktu-gradients="waktuGradients"
                        :waktu-labels="waktuLabels"
                    />
                </div>

                <!-- Empty State -->
                <div v-if="iqamats.length === 0" class="py-16 text-center">
                    <div class="inline-block p-8 bg-gray-50 rounded-2xl">
                        <span class="block mb-4 text-6xl">📿</span>
                        <h3 class="mb-2 text-xl font-bold text-gray-900">Belum Ada Data Iqamat</h3>
                        <p class="text-gray-600">Data iqamat akan segera tersedia</p>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
