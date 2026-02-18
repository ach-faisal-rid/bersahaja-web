<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    gerakan: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    nama_gerakan: props.gerakan?.nama_gerakan ?? '',
    urutan_global: props.gerakan?.urutan_global ?? '',
    deskripsi_singkat: props.gerakan?.deskripsi_singkat ?? '',
    kategori: props.gerakan?.kategori ?? 'Wajib',
    icon_url: props.gerakan?.icon_url ?? '',
});

const submit = () => {
    if (!props.gerakan?.id) return;
    form.put(`/gerakan-shalat/${props.gerakan.id}`);
};
</script>

<template>
    <Head title="Edit Gerakan Shalat" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Edit Gerakan Shalat
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Perbarui data gerakan shalat.
                </p>
                <Link href="/gerakan-shalat">
                    <SecondaryButton>Kembali</SecondaryButton>
                </Link>
            </div>

            <form class="grid gap-6 md:grid-cols-2" @submit.prevent="submit">
                <!-- Nama Gerakan -->
                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="nama_gerakan" value="Nama Gerakan" />
                    <TextInput
                        id="nama_gerakan"
                        v-model="form.nama_gerakan"
                        type="text"
                        class="block w-full"
                        placeholder="Misal: Niat, Takbir, Ruku', etc"
                        required
                    />
                    <InputError :message="form.errors.nama_gerakan" />
                </div>

                <!-- Urutan -->
                <div class="space-y-2">
                    <InputLabel for="urutan_global" value="Urutan Global" />
                    <TextInput
                        id="urutan_global"
                        v-model="form.urutan_global"
                        type="number"
                        class="block w-full"
                        min="1"
                        required
                    />
                    <InputError :message="form.errors.urutan_global" />
                </div>

                <!-- Kategori -->
                <div class="space-y-2">
                    <InputLabel for="kategori" value="Kategori" />
                    <select
                        id="kategori"
                        v-model="form.kategori"
                        class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800"
                        required
                    >
                        <option value="Wajib">Wajib</option>
                        <option value="Sunnah">Sunnah</option>
                        <option value="makruh">Makruh</option>
                        <option value="haram">Haram</option>
                    </select>
                    <InputError :message="form.errors.kategori" />
                </div>

                <!-- Deskripsi Singkat -->
                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="deskripsi_singkat" value="Deskripsi Singkat" />
                    <textarea
                        id="deskripsi_singkat"
                        v-model="form.deskripsi_singkat"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-800"
                        rows="4"
                        placeholder="Penjelasan singkat tentang gerakan ini"
                        required
                    />
                    <InputError :message="form.errors.deskripsi_singkat" />
                </div>

                <!-- Icon URL (Opsional) -->
                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="icon_url" value="Icon URL (Opsional)" />
                    <TextInput
                        id="icon_url"
                        v-model="form.icon_url"
                        type="text"
                        class="block w-full"
                        placeholder="URL untuk icon gerakan"
                    />
                    <InputError :message="form.errors.icon_url" />
                </div>

                <!-- Buttons -->
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
