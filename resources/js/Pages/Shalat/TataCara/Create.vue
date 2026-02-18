<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    gerakans: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    nama_langkah: '',
    urutan: '',
    deskripsi: '',
    gerakan_id: '',
    bacaan_arab: '',
    transliterasi: '',
    terjemahan: '',
});

const submit = () => {
    form.post('/tata-cara');
};
</script>

<template>
    <Head title="Tambah Tata Cara" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Tambah Tata Cara Shalat
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Tambahkan langkah baru dalam tata cara shalat.
                </p>
                <Link href="/tata-cara">
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
                        placeholder="Misal: Niat, Takbir, Ruku', etc"
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

                <!-- Gerakan -->
                <div class="space-y-2">
                    <InputLabel for="gerakan_id" value="Gerakan Shalat" />
                    <select
                        id="gerakan_id"
                        v-model="form.gerakan_id"
                        class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800"
                    >
                        <option value="">-- Pilih Gerakan --</option>
                        <option v-for="gerakan in gerakans" :key="gerakan.id" :value="gerakan.id">
                            {{ gerakan.nama_gerakan }}
                        </option>
                    </select>
                    <InputError :message="form.errors.gerakan_id" />
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

                <!-- Bacaan Arab -->
                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="bacaan_arab" value="Bacaan Arab" />
                    <textarea
                        id="bacaan_arab"
                        v-model="form.bacaan_arab"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800"
                        rows="3"
                        placeholder="Bacaan dalam bahasa Arab (opsional)"
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
                        rows="3"
                        placeholder="Bacaan transliterasi (opsional)"
                    />
                    <InputError :message="form.errors.transliterasi" />
                </div>

                <!-- Terjemahan -->
                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="terjemahan" value="Terjemahan" />
                    <textarea
                        id="terjemahan"
                        v-model="form.terjemahan"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800"
                        rows="3"
                        placeholder="Terjemahan dalam bahasa Indonesia (opsional)"
                    />
                    <InputError :message="form.errors.terjemahan" />
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
