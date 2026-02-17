<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { computed } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
    doa: {
        type: Object,
        default: () => ({}),
    },
    tags: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    tag_ids: Array.isArray(props.doa?.tags) ? props.doa.tags.map((tag) => tag.id) : [],
});

const flash = computed(() => usePage().props.flash || {});

const submit = () => {
    if (!props.doa?.id) return;
    form
        .transform((data) => ({
            ...data,
            tag_ids: (data.tag_ids ?? [])
                .map((id) => Number(id))
                .filter((id) => Number.isInteger(id) && id > 0),
        }))
        .put(`/doas/${props.doa.id}/tags`, {
            preserveScroll: true,
        });
};
</script>

<template>
    <Head title="Kelola Tag Doa" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Kelola Tag Doa
            </h2>
        </template>

        <div class="space-y-6">
            <div v-if="flash.success" class="rounded-md bg-green-100 p-3 text-sm text-green-700">
                {{ flash.success }}
            </div>

            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        Atur relasi tag untuk doa.
                    </p>
                    <p class="text-base font-medium text-gray-900 dark:text-gray-100">
                        {{ props.doa?.judul || '-' }}
                    </p>
                </div>
                <Link href="/doas">
                    <SecondaryButton>Kembali</SecondaryButton>
                </Link>
            </div>

            <form class="grid gap-6" @submit.prevent="submit">
                <div class="space-y-2">
                    <InputLabel for="tag_ids" value="Pilih Tag" />
                    <select
                        id="tag_ids"
                        v-model="form.tag_ids"
                        multiple
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option v-for="tag in props.tags" :key="tag.id" :value="tag.id">
                            {{ tag.nama }}
                        </option>
                    </select>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Gunakan Ctrl/Cmd + klik untuk memilih lebih dari satu tag.
                    </p>
                    <InputError :message="form.errors.tag_ids" />
                    <InputError :message="form.errors['tag_ids.0']" />
                </div>

                <div class="flex items-center justify-end gap-3">
                    <SecondaryButton type="button" @click="form.reset()">
                        Reset
                    </SecondaryButton>
                    <PrimaryButton :disabled="form.processing">
                        Simpan Tag
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
