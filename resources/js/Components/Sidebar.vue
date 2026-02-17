<!-- resources/js/Components/Sidebar.vue -->
<script setup>
import { computed, ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';

// State untuk mengontrol sidebar mobile
const isSidebarOpen = ref(false);

// Mendapatkan URL saat ini untuk menentukan active state
const currentUrl = computed(() => usePage().url);

// Fungsi untuk menutup sidebar di mobile
const closeSidebar = () => {
    isSidebarOpen.value = false;
};

// Data menu navigasi
const navigationItems = [
    {
        name: 'Dashboard',
        href: '/dashboard',
        icon: `
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
        `
    },
    {
        name: 'Users',
        href: '/users',
        icon: `
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        `
    },
    {
        name: 'Kategori',
        href: '/categories',
        icon: `
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
            </svg>
        `
    },
    {
        name: 'Tag',
        href: '/tags',
        icon: `
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
            </svg>
        `
    },
    {
        name: 'Repositori',
        href: '/repositories',
        icon: `
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
            </svg>
        `
    },
    {
        name: 'Doa',
        href: '/doas',
        icon: `
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
            </svg>
        `
    },
    {
        name: 'Hadist',
        href: '/hadists',
        icon: `
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
            </svg>
        `
    },
    {
        name: 'Hijri',
        href: '/hijri',
        icon: `
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1M4.2 6.2l.7.7M19.1 17.1l.7.7M3 12h1m16 0h1M4.2 17.8l.7-.7M19.1 6.9l.7-.7" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8a4 4 0 100 8 4 4 0 000-8z" />
            </svg>
        `
    },
    {
        name: 'Favorit',
        href: '/favorit',
        icon: `
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
            </svg>
        `
    },
];
</script>

<template>
    <!-- Tombol toggle untuk mobile -->
    <button
        @click="isSidebarOpen = !isSidebarOpen"
        class="fixed top-4 left-4 z-50 p-2 rounded-md lg:hidden bg-gray-900 text-white"
        aria-label="Toggle sidebar"
    >
        <svg
            class="w-6 h-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                v-if="!isSidebarOpen"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
            />
            <path
                v-else
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
            />
        </svg>
    </button>

    <!-- Overlay untuk mobile -->
    <div
        v-if="isSidebarOpen"
        @click="closeSidebar"
        class="fixed inset-0 bg-gray-600 bg-opacity-75 z-30 lg:hidden"
    ></div>

    <!-- Sidebar -->
    <aside
        :class="[
            'fixed top-0 left-0 z-40 h-screen transition-transform bg-white dark:bg-gray-800',
            isSidebarOpen ? 'translate-x-0' : '-translate-x-full',
            'lg:translate-x-0 lg:static lg:z-auto'
        ]"
        class="w-64"
    >
        <!-- Logo/Brand Section -->
        <div class="h-16 flex items-center px-4 border-b border-gray-200 dark:border-gray-700">
            <Link href="/dashboard" class="flex items-center space-x-2">
                <span class="text-xl font-semibold text-gray-900 dark:text-white">Bersahaja</span>
            </Link>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-2 py-4 space-y-1 overflow-y-auto">
            <div v-for="item in navigationItems" :key="item.name">
                <NavLink
                    :href="item.href"
                    :active="currentUrl === item.href"
                    @click="closeSidebar"
                >
                    <div class="flex items-center space-x-3">
                        <span v-html="item.icon"></span>
                        <span>{{ item.name }}</span>
                    </div>
                </NavLink>
            </div>
        </nav>

        <!-- Footer/User Section -->
        <div class="absolute bottom-0 w-full p-4 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-3">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                        {{ $page.props.auth.user.name }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                        {{ $page.props.auth.user.email }}
                    </p>
                </div>
                <Link
                    href="/logout"
                    method="post"
                    as="button"
                    class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </Link>
            </div>
        </div>
    </aside>
</template>

<style scoped>
/* Tambahkan CSS custom jika diperlukan */
</style>
