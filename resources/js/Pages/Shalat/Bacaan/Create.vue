<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    nama_bacaan: '',
    bacaan_arab: '',
    transliterasi: '',
    terjemahan: '',
    deskripsi: '',
    kategori: '',
});

const submit = () => {
    form.post('/bacaan');
};
</script>

<template>
    <Head title="Tambah Bacaan" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Tambah Bacaan Shalat
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Tambahkan bacaan/doa baru untuk shalat.
                </p>
                <Link href="/bacaan">
                    <SecondaryButton>Kembali</SecondaryButton>
                </Link>
            </div>

            <form class="grid gap-6 md:grid-cols-2" @submit.prevent="submit">
                <!-- Nama Bacaan -->
                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="nama_bacaan" value="Nama Bacaan" />
                    <TextInput
                        id="nama_bacaan"
                        v-model="form.nama_bacaan"
                        type="text"
                        class="block w-full"
                        placeholder="Misal: Al-Fatihah, Doa Ruku', Tasyahud, dll"
                        required
                    />
                    <InputError :message="form.errors.nama_bacaan" />
                </div>

                <!-- Kategori -->
                <div class="space-y-2">
                    <InputLabel for="kategori" value="Kategori (Opsional)" />
                    <TextInput
                        id="kategori"
                        v-model="form.kategori"
                        type="text"
                        class="block w-full"
                        placeholder="Misal: Doa, Surah, Tasbiih, dll"
                    />
                    <InputError :message="form.errors.kategori" />
                </div>

                <!-- Bacaan Arab -->
                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="bacaan_arab" value="Bacaan Arab" />
                    <textarea
                        id="bacaan_arab"
                        v-model="form.bacaan_arab"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800"
                        rows="5"
                        placeholder="Ketik bacaan dalam bahasa Arab"
                        required
                    />
                    <InputError :message="form.errors.bacaan_arab" />
                </div>

                <!-- Transliterasi -->
                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="transliterasi" value="Transliterasi" />
                    <textarea
                        id="transliterasi"
                        v-model="form.transliterasi"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800"
                        rows="5"
                        placeholder="Ketik bacaan dengan huruf latin"
                        required
                    />
                    <InputError :message="form.errors.transliterasi" />
                </div>

                <!-- Terjemahan -->
                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="terjemahan" value="Terjemahan Indonesia" />
                    <textarea
                        id="terjemahan"
                        v-model="form.terjemahan"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800"
                        rows="5"
                        placeholder="Terjemahan dalam bahasa Indonesia"
                        required
                    />
                    <InputError :message="form.errors.terjemahan" />
                </div>

                <!-- Deskripsi -->
                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="deskripsi" value="Deskripsi (Opsional)" />
                    <textarea
                        id="deskripsi"
                        v-model="form.deskripsi"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800"
                        rows="3"
                        placeholder="Penjelasan atau catatan tambahan tentang bacaan ini"
                    />
                    <InputError :message="form.errors.deskripsi" />
                </div>

                <!-- Buttons -->
                <div class="md:col-span-2 flex items-center justify-end gap-3">
                    <SecondaryButton type="button" @click="form.reset()">
                        Reset
                    </SecondaryButton>
                    <PrimaryButton :disabled="form.processing">
                        Simpan
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
