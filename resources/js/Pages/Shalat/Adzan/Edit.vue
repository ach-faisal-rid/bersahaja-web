<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    adzan: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    waktu: props.adzan.waktu,
    teks_arab: props.adzan.teks_arab,
    transliterasi: props.adzan.transliterasi,
    terjemahan: props.adzan.terjemahan,
});

const submit = () => {
    form.put(`/adzan/${props.adzan.id}`);
};
</script>

<template>
    <Head title="Edit Adzan" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Edit Adzan
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Edit teks adzan untuk waktu sholat {{ adzan.waktu }}.
                </p>
                <Link href="/adzan">
                    <SecondaryButton>Kembali</SecondaryButton>
                </Link>
            </div>

            <form class="grid gap-6 md:grid-cols-2" @submit.prevent="submit">
                <!-- Waktu -->
                <div class="space-y-2">
                    <InputLabel for="waktu" value="Waktu Sholat" />
                    <select
                        id="waktu"
                        v-model="form.waktu"
                        class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    >
                        <option value="">Pilih Waktu</option>
                        <option value="subuh">Subuh</option>
                        <option value="dzuhur">Dzuhur</option>
                        <option value="ashar">Ashar</option>
                        <option value="maghrib">Maghrib</option>
                        <option value="isya">Isya</option>
                    </select>
                    <InputError :message="form.errors.waktu" />
                </div>

                <!-- Teks Arab -->
                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="teks_arab" value="Teks Arab" />
                    <textarea
                        id="teks_arab"
                        v-model="form.teks_arab"
                        class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                        rows="4"
                        placeholder="Masukkan teks adzan dalam bahasa Arab..."
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