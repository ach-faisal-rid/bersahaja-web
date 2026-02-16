<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    user: {
        type: Object,
        required: true
    }
});

// Format tanggal
const formatDate = (date) => {
    return new Date(date).toLocaleDateString('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

// Status badge class
const roleBadgeClass = computed(() => {
    return props.user.role === 'admin' 
        ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200'
        : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
});

// Initial badge class
const initialBadgeClass = (initial) => {
    return initial
        ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'
        : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
};

// Ambil flash message dari session
const flash = computed(() => usePage().props.flash || {});
</script>

<template>
    <Head :title="`User Details: ${user.name}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    User Details
                </h2>
                <div class="flex gap-2">
                    <Link
                        :href="route('users.edit', user.id)"
                        class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 flex items-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit User
                    </Link>
                    <Link
                        :href="route('users.index')"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 flex items-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to List
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Flash Message -->
                <div v-if="flash.success" class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ flash.success }}
                </div>
                <div v-if="flash.error" class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                    {{ flash.error }}
                </div>

                <!-- User Profile Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- Header with Avatar -->
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="flex-shrink-0">
                                <div class="w-20 h-20 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold">
                                    {{ user.name.charAt(0).toUpperCase() }}
                                </div>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ user.name }}
                                </h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span :class="['px-2 py-1 text-xs font-semibold rounded-full', roleBadgeClass]">
                                        {{ user.role || 'user' }}
                                    </span>
                                    <span v-if="user.email_verified_at" class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Verified
                                    </span>
                                    <span v-else class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        Unverified
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- User Information Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-4">
                                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                                        Contact Information
                                    </h4>
                                    <div class="space-y-3">
                                        <div class="flex items-start">
                                            <div class="w-8 flex-shrink-0">
                                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Email Address</p>
                                                <p class="text-base text-gray-900 dark:text-white">{{ user.email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                                        Account Details
                                    </h4>
                                    <div class="space-y-3">
                                        <div class="flex items-start">
                                            <div class="w-8 flex-shrink-0">
                                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">User ID</p>
                                                <p class="text-base text-gray-900 dark:text-white">#{{ user.id }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start">
                                            <div class="w-8 flex-shrink-0">
                                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Member Since</p>
                                                <p class="text-base text-gray-900 dark:text-white">{{ formatDate(user.created_at) }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-start">
                                            <div class="w-8 flex-shrink-0">
                                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Last Updated</p>
                                                <p class="text-base text-gray-900 dark:text-white">{{ formatDate(user.updated_at) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-4">
                                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                                        Activity Summary
                                    </h4>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Posts</p>
                                            <p class="text-2xl font-bold text-gray-900 dark:text-white">0</p>
                                        </div>
                                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Comments</p>
                                            <p class="text-2xl font-bold text-gray-900 dark:text-white">0</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                                        Security
                                    </h4>
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                </svg>
                                                <span class="text-sm text-gray-700 dark:text-gray-300">2FA Status</span>
                                            </div>
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                Not Enabled
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Info (bisa diisi dengan custom fields) -->
                                <div v-if="user.metadata || user.custom_fields" class="border-b border-gray-200 dark:border-gray-700 pb-4">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">
                                        Additional Information
                                    </h4>
                                    <!-- Tambahkan custom fields di sini -->
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <Link
                                :href="route('users.edit', user.id)"
                                class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                            >
                                Edit User
                            </Link>
                            <Link
                                :href="route('users.index')"
                                class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500"
                            >
                                Back to List
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>