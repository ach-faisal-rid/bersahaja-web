<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    modelValue: {
        type: String,
        default: '',
    },
    statusValue: {
        type: String,
        default: 'all',
    },
});

defineEmits(['update:modelValue', 'update:statusValue', 'search']);
</script>

<template>
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-gray-600 dark:text-gray-300">
            Kelola data doa.
        </p>

        <div class="flex flex-col w-full gap-3 sm:w-auto sm:flex-row sm:items-center">
            <form
                class="flex items-center w-full gap-2 sm:w-72"
                @submit.prevent="$emit('search')"
            >
                <TextInput
                    :model-value="modelValue"
                    class="w-full"
                    placeholder="Cari judul doa"
                    @update:model-value="$emit('update:modelValue', $event)"
                />
                <select
                    :value="statusValue"
                    class="w-36 rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200"
                    @change="$emit('update:statusValue', $event.target.value)"
                >
                    <option value="all">Semua</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
                <SecondaryButton type="submit">Cari</SecondaryButton>
            </form>

            <Link href="/doas/create">
                <PrimaryButton>Tambah Doa</PrimaryButton>
            </Link>
        </div>
    </div>
</template>
