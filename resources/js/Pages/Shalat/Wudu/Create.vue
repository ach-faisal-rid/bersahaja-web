<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    nama_langkah: '',
    urutan: '',
    deskripsi: '',
    doa_arab: '',
    transliterasi: '',
    terjemahan: '',
    tips_penting: '',
});

const submit = () => {
    form.post('/wudu');
};
</script>

<template>
    <Head title="Tambah Langkah Wudu" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Tambah Langkah Wudu
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Tambahkan langkah wudu baru.
                </p>
                <Link href="/wudu">
                    <SecondaryButton>Kembali</SecondaryButton>
                </Link>
            </div>

            <form class="grid gap-6 md:grid-cols-2" @submit.prevent="submit">
                <!-- Nama Langkah -->
                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="nama_langkah" value="Nama Langkah" />
                    <TextInput
                        id="nama_langkah"
                        v-model="form.nama_langkah"
                        type="text"
                        class="block w-full"
                        placeholder="Misal: Niat, Cuci Tangan, Berkumur, etc"
                        required
                    />
                    <InputError :message="form.errors.nama_langkah" />
                </div>

                <!-- Urutan -->
                <div class="space-y-2">
                    <InputLabel for="urutan" value="Urutan" />
                    <TextInput
                        id="urutan"
                        v-model="form.urutan"
                        type="number"
                        class="block w-full"
                        min="1"
                        required
                    />
                    <InputError :message="form.errors.urutan" />
                </div>

                <!-- Deskripsi -->
                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="deskripsi" value="Deskripsi" />
                    <textarea
                        id="deskripsi"
                        v-model="form.deskripsi"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800"
                        rows="5"
                        placeholder="Penjelasan detail tentang langkah ini"
                        required
                    />
                    <InputError :message="form.errors.deskripsi" />
                </div>

                <!-- Doa Arab -->
                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="doa_arab" value="Doa Arab (Opsional)" />
                    <textarea
                        id="doa_arab"
                        v-model="form.doa_arab"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800"
                        rows="3"
                        placeholder="Doa dalam bahasa Arab yang terkait dengan langkah ini"
                    />
                    <InputError :message="form.errors.doa_arab" />
                </div>

                <!-- Transliterasi -->
                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="transliterasi" value="Transliterasi (Opsional)" />
                    <textarea
                        id="transliterasi"
                        v-model="form.transliterasi"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800"
                        rows="3"
                        placeholder="Bacaan dengan huruf latin"
                    />
                    <InputError :message="form.errors.transliterasi" />
                </div>

                <!-- Terjemahan -->
                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="terjemahan" value="Terjemahan (Opsional)" />
                    <textarea
                        id="terjemahan"
                        v-model="form.terjemahan"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800"
                        rows="3"
                        placeholder="Terjemahan dalam bahasa Indonesia"
                    />
                    <InputError :message="form.errors.terjemahan" />
                </div>

                <!-- Tips Penting -->
                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="tips_penting" value="Tips Penting (Opsional)" />
                    <textarea
                        id="tips_penting"
                        v-model="form.tips_penting"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800"
                        rows="3"
                        placeholder="Hal-hal penting yang perlu diperhatikan"
                    />
                    <InputError :message="form.errors.tips_penting" />
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
