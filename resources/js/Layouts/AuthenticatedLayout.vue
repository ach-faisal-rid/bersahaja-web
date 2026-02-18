<script setup>
import Sidebar from '@/Components/Sidebar.vue';
import Topbar from '@/Components/Topbar.vue';
</script>

<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <Sidebar />

        <div class="flex-1 flex flex-col w-full lg:ml-64 min-h-screen">
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
            <main class="flex-1 px-4 pb-8 pt-6 sm:px-6 lg:px-8 overflow-y-auto bg-gray-100 dark:bg-gray-900 h-full">
                <div class="mx-auto w-full max-w-7xl h-full">
                    <div
                        class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900/70 h-full"
                    >
                        <slot />
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>
