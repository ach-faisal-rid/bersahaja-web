<script setup>
import { computed, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { iconMap } from '@/Config/sidebarMenu';
import SidebarMenuItem from './SidebarMenuItem.vue';

const props = defineProps({
    item: {
        type: Object,
        required: true,
    },
    defaultExpanded: {
        type: Boolean,
        default: false,
    },
    onNavigate: {
        type: Function,
        default: () => {},
    },
});

const isExpanded = ref(props.defaultExpanded);
const page = usePage();
const currentUrl = computed(() => page.url);
const authUser = computed(() => page.props?.auth?.user ?? null);

const visibleChildren = computed(() => {
    return (props.item.children ?? []).filter(child => {
        if (child.requiresAuth && !authUser.value) return false;
        if (child.requiresRole && authUser.value?.role !== child.requiresRole) return false;
        return true;
    });
});

// Check if any child menu is currently active
const isChildActive = computed(() => {
    return visibleChildren.value.some(child => currentUrl.value === child.href);
});

// Auto-expand if child is active
const shouldBeExpanded = computed(() => {
    return isExpanded.value || isChildActive.value;
});

const toggleExpand = () => {
    isExpanded.value = !isExpanded.value;
};

const handleChildNavigate = () => {
    props.onNavigate();
};

const icon = computed(() => iconMap[props.item.icon] || '');
const chevronIcon = computed(() => iconMap.chevronRight || '');
</script>

<template>
    <div class="space-y-1">
        <!-- Parent Menu Button -->
        <button
            @click="toggleExpand"
            :aria-expanded="shouldBeExpanded"
            class="w-full flex items-center justify-between px-3 py-2 rounded-md text-sm font-medium transition-colors duration-150 min-w-0"
            :class="[
                isChildActive
                    ? 'bg-blue-100 dark:bg-blue-900 text-blue-900 dark:text-blue-100'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
            ]"
        >
            <div class="flex items-center space-x-2 min-w-0">
                <span v-html="icon" class="w-5 h-5 flex-shrink-0"></span>
                <span class="truncate">{{ item.name }}</span>
            </div>
            <svg
                :class="[
                    'w-4 h-4 transition-transform duration-200 flex-shrink-0',
                    shouldBeExpanded ? 'rotate-90' : 'rotate-0'
                ]"
                v-html="chevronIcon"
            ></svg>
        </button>

        <!-- Child Menu Items -->
        <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95 -translate-y-1"
            enter-to-class="transform opacity-100 scale-100 translate-y-0"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100 translate-y-0"
            leave-to-class="transform opacity-0 scale-95 -translate-y-1"
        >
            <div v-show="shouldBeExpanded" class="pl-4 space-y-1">
                <SidebarMenuItem
                    v-for="child in visibleChildren"
                    :key="child.id"
                    :item="child"
                    @navigate="handleChildNavigate"
                />
            </div>
        </transition>
    </div>
</template>
