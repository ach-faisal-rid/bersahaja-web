<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    doa: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    judul: props.doa.judul,
    teks_arab: props.doa.teks_arab,
    transliterasi: props.doa.transliterasi,
    terjemahan: props.doa.terjemahan,
});

const submit = () => {
    form.put(`/doa-setelah-sholat/${props.doa.id}`);
};
</script>

<template>
    <Head title="Edit Doa Setelah Sholat" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Edit Doa Setelah Sholat
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Edit doa "{{ doa.judul }}".
                </p>
                <Link href="/doa-setelah-sholat">
                    <SecondaryButton>Kembali</SecondaryButton>
                </Link>
            </div>

            <form class="grid gap-6 md:grid-cols-2" @submit.prevent="submit">
                <!-- Judul -->
                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="judul" value="Judul Doa" />
                    <TextInput
                        id="judul"
                        v-model="form.judul"
                        type="text"
                        class="block w-full"
                        placeholder="Masukkan judul doa..."
                    />
                    <InputError :message="form.errors.judul" />
                </div>

                <!-- Teks Arab -->
                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="teks_arab" value="Teks Arab" />
                    <textarea
                        id="teks_arab"
                        v-model="form.teks_arab"
                        class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        rows="4"
                        placeholder="Masukkan teks doa dalam bahasa Arab..."
                    ></textarea>
                    <InputError :message="form.errors.teks_arab" />
                </div>

                <!-- Transliterasi -->
                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="transliterasi" value="Transliterasi" />
                    <textarea
                        id="transliterasi"
                        v-model="form.transliterasi"
                        class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        rows="4"
                        placeholder="Masukkan transliterasi..."
                    ></textarea>
                    <InputError :message="form.errors.transliterasi" />
                </div>

                <!-- Terjemahan -->
                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="terjemahan" value="Terjemahan" />
                    <textarea
                        id="terjemahan"
                        v-model="form.terjemahan"
                        class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        rows="4"
                        placeholder="Masukkan terjemahan..."
                    ></textarea>
                    <InputError :message="form.errors.terjemahan" />
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end md:col-span-2">
                    <PrimaryButton :disabled="form.processing">
                        Simpan Perubahan
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>