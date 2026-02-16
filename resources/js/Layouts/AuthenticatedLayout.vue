<script setup>
import Sidebar from '@/Components/Sidebar.vue';
import Topbar from '@/Components/Topbar.vue';
</script>

<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 lg:flex">
        <Sidebar />

        <div class="flex-1">
            <Topbar>
                <template #title>
                    <div
                        v-if="$slots.header"
                        class="text-base font-semibold text-gray-900 dark:text-gray-100"
                    >
                        <slot name="header" />
                    </div>
                </template>
            </Topbar>

            <!-- Page Content -->
            <main class="px-4 pb-8 pt-6 sm:px-6 lg:px-8">
                <div class="mx-auto w-full max-w-7xl">
                    <div
                        class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900/70"
                    >
                        <slot />
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>
