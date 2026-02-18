<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { iconMap } from '@/Config/sidebarMenu';

const props = defineProps({
    item: {
        type: Object,
        required: true,
    },
    onNavigate: {
        type: Function,
        default: () => {},
    },
});

const currentUrl = computed(() => usePage().url);

const isActive = computed(() => {
    return currentUrl.value === props.item.href;
});

const handleNavigate = () => {
    props.onNavigate();
};

const icon = computed(() => iconMap[props.item.icon] || '');
</script>

<template>
    <Link
        :href="item.href"
        @click="handleNavigate"
        class="flex items-center space-x-2 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150 min-w-0"
        :class="[
            isActive
                ? 'bg-blue-100 dark:bg-blue-900 text-blue-900 dark:text-blue-100'
                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
        ]"
    >
        <span v-html="icon" class="w-5 h-5 flex-shrink-0"></span>
        <span class="truncate">{{ item.name }}</span>
    </Link>
</template>
