<!-- resources/js/Components/Sidebar.vue -->
<script setup>
import { computed, ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { sidebarMenu } from '@/Config/sidebarMenu';
import SidebarMenuItem from '@/Components/SidebarMenuItem.vue';
import SidebarMenuGroup from '@/Components/SidebarMenuGroup.vue';

// State untuk mengontrol sidebar mobile
const isSidebarOpen = ref(false);

// Fungsi untuk menutup sidebar di mobile
const closeSidebar = () => {
    isSidebarOpen.value = false;
};

const page = usePage();

const authUser = computed(() => page.props?.auth?.user ?? null);

const visibleMenus = computed(() => {
    return sidebarMenu.filter(item => {
        if (item.requiresAuth && !authUser.value) return false;
        if (item.requiresRole && authUser.value?.role !== item.requiresRole) return false;
        return true;
    });
});

// Filter menu berdasarkan tipe (untuk rendering yang lebih efisien)
const linkMenus = computed(() => visibleMenus.value.filter(item => item.type === 'link'));
const groupMenus = computed(() => visibleMenus.value.filter(item => item.type === 'group'));
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
            'fixed top-0 left-0 z-40 h-screen transition-transform bg-white dark:bg-gray-800 flex flex-col',
            isSidebarOpen ? 'translate-x-0' : '-translate-x-full',
            'lg:translate-x-0 lg:fixed lg:z-40'
        ]"
        class="w-64"
    >
        <!-- Logo/Brand Section -->
        <div class="flex-shrink-0 h-16 flex items-center px-4 border-b border-gray-200 dark:border-gray-700">
            <Link :href="authUser ? '/dashboard' : '/'" class="flex items-center space-x-2">
                <span class="text-xl font-semibold text-gray-900 dark:text-white">Bersahaja</span>
            </Link>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-2 py-4 space-y-1 overflow-y-auto overflow-x-hidden">
            <!-- Single Link Items -->
            <SidebarMenuItem
                v-for="item in linkMenus"
                :key="item.id"
                :item="item"
                @navigate="closeSidebar"
            />

            <!-- Group Items (Parent-Child) -->
            <SidebarMenuGroup
                v-for="item in groupMenus"
                :key="item.id"
                :item="item"
                :defaultExpanded="item.defaultExpanded ?? false"
                @navigate="closeSidebar"
            />
        </nav>

        <!-- Footer/User Section -->
        <div class="flex-shrink-0 p-4 border-t border-gray-200 dark:border-gray-700">
            <div v-if="authUser" class="flex items-center space-x-3">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                        {{ authUser.name }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                        {{ authUser.email }}
                    </p>
                </div>
                <Link
                    href="/logout"
                    method="post"
                    as="button"
                    class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 flex-shrink-0"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </Link>
            </div>

            <div v-else class="flex items-center justify-between gap-2">
                <Link href="/login" class="rounded-md bg-gray-900 px-3 py-2 text-xs font-semibold text-white">
                    Login
                </Link>
                <Link href="/register" class="rounded-md border border-gray-300 px-3 py-2 text-xs font-semibold text-gray-700 dark:border-gray-600 dark:text-gray-300">
                    Register
                </Link>
            </div>
        </div>
    </aside>
</template>

<style scoped>
/* Tambahkan CSS custom jika diperlukan */
</style>
