<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    category: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    nama: props.category?.nama ?? '',
});

const submit = () => {
    if (!props.category?.id) return;
    form.put(`/categories/${props.category.id}`);
};
</script>

<template>
    <Head title="Edit Kategori" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Edit Kategori
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Perbarui data kategori.
                </p>
                <Link href="/categories">
                    <SecondaryButton>Kembali</SecondaryButton>
                </Link>
            </div>

            <form class="grid gap-6 md:grid-cols-2" @submit.prevent="submit">
                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="nama" value="Nama Kategori" />
                    <TextInput
                        id="nama"
                        v-model="form.nama"
                        type="text"
                        class="block w-full"
                        autocomplete="off"
                        autofocus
                    />
                    <InputError :message="form.errors.nama" />
                </div>

                <div class="md:col-span-2 flex items-center justify-end gap-3">
                    <SecondaryButton type="button" @click="form.reset()">
                        Reset
                    </SecondaryButton>
                    <PrimaryButton :disabled="form.processing">
                        Simpan Perubahan
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
