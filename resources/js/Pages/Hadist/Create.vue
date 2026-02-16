<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    categories: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    judul: '',
    teks_arab: '',
    transliterasi: '',
    terjemah: '',
    kategori_id: '',
    audio_url: '',
    gambar_url: '',
    hadist_sources: [],
});

const addHadistSource = () => {
    form.hadist_sources.push({
        book: '',
        number: '',
        narrator: '',
        status: '',
        notes: '',
    });
};

const removeHadistSource = (index) => {
    form.hadist_sources.splice(index, 1);
};

const submit = () => {
    form.post('/hadists');
};
</script>

<template>
    <Head title="Tambah Hadist" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Tambah Hadist
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Tambahkan Hadist baru.
                </p>
                <Link href="/hadists">
                    <SecondaryButton>Kembali</SecondaryButton>
                </Link>
            </div>

            <form class="grid gap-6 md:grid-cols-2" @submit.prevent="submit">
                <div class="space-y-2">
                    <InputLabel for="kategori_id" value="Kategori" />
                    <select
                        id="kategori_id"
                        v-model="form.kategori_id"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required
                    >
                        <option value="">Pilih kategori</option>
                        <option v-for="category in props.categories" :key="category.id" :value="category.id">
                            {{ category.nama }}
                        </option>
                    </select>
                    <InputError :message="form.errors.kategori_id" />
                </div>

                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="judul" value="Judul Hadist" />
                    <TextInput
                        id="judul"
                        v-model="form.judul"
                        type="text"
                        class="block w-full"
                        autocomplete="off"
                        autofocus
                    />
                    <InputError :message="form.errors.judul" />
                </div>

                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="teks_arab" value="Teks Arab" />
                    <textarea
                        id="teks_arab"
                        v-model="form.teks_arab"
                        rows="4"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    />
                    <InputError :message="form.errors.teks_arab" />
                </div>

                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="transliterasi" value="Transliterasi" />
                    <textarea
                        id="transliterasi"
                        v-model="form.transliterasi"
                        rows="4"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    />
                    <InputError :message="form.errors.transliterasi" />
                </div>

                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="terjemah" value="Terjemah" />
                    <textarea
                        id="terjemah"
                        v-model="form.terjemah"
                        rows="4"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    />
                    <InputError :message="form.errors.terjemah" />
                </div>

                <div class="space-y-2">
                    <InputLabel for="audio_url" value="URL Audio (Opsional)" />
                    <TextInput id="audio_url" v-model="form.audio_url" type="url" class="block w-full" />
                    <InputError :message="form.errors.audio_url" />
                </div>

                <div class="space-y-2">
                    <InputLabel for="gambar_url" value="URL Gambar (Opsional)" />
                    <TextInput id="gambar_url" v-model="form.gambar_url" type="url" class="block w-full" />
                    <InputError :message="form.errors.gambar_url" />
                </div>

                <div class="space-y-2 md:col-span-2">
                    <div class="flex items-center justify-between">
                        <InputLabel for="hadist_sources" value="Sumber Hadist (Opsional)" />
                        <SecondaryButton type="button" @click="addHadistSource" class="text-xs">
                            + Tambah Sumber
                        </SecondaryButton>
                    </div>

                    <div v-if="form.hadist_sources.length === 0" class="text-sm text-gray-500 dark:text-gray-400 py-2">
                        Belum ada sumber hadist. Klik "Tambah Sumber" untuk menambahkan.
                    </div>

                    <div v-for="(source, index) in form.hadist_sources" :key="index" class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 space-y-3">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Sumber #{{ index + 1 }}</span>
                            <SecondaryButton type="button" @click="removeHadistSource(index)" class="text-xs bg-red-600 hover:bg-red-700 text-white">
                                Hapus
                            </SecondaryButton>
                        </div>

                        <div class="grid gap-3 md:grid-cols-2">
                            <div>
                                <InputLabel :for="`book_${index}`" value="Kitab *" />
                                <TextInput
                                    :id="`book_${index}`"
                                    v-model="source.book"
                                    type="text"
                                    class="block w-full"
                                    placeholder="Contoh: Bukhari, Muslim"
                                />
                                <InputError :message="form.errors[`hadist_sources.${index}.book`]" />
                            </div>

                            <div>
                                <InputLabel :for="`number_${index}`" value="Nomor (Opsional)" />
                                <TextInput
                                    :id="`number_${index}`"
                                    v-model="source.number"
                                    type="number"
                                    class="block w-full"
                                    placeholder="Contoh: 123"
                                />
                                <InputError :message="form.errors[`hadist_sources.${index}.number`]" />
                            </div>

                            <div>
                                <InputLabel :for="`narrator_${index}`" value="Perawi *" />
                                <TextInput
                                    :id="`narrator_${index}`"
                                    v-model="source.narrator"
                                    type="text"
                                    class="block w-full"
                                    placeholder="Nama perawi"
                                />
                                <InputError :message="form.errors[`hadist_sources.${index}.narrator`]" />
                            </div>

                            <div>
                                <InputLabel :for="`status_${index}`" value="Status *" />
                                <TextInput
                                    :id="`status_${index}`"
                                    v-model="source.status"
                                    type="text"
                                    class="block w-full"
                                    placeholder="Contoh: Sahih, Hasan"
                                />
                                <InputError :message="form.errors[`hadist_sources.${index}.status`]" />
                            </div>

                            <div class="md:col-span-2">
                                <InputLabel :for="`notes_${index}`" value="Catatan (Opsional)" />
                                <textarea
                                    :id="`notes_${index}`"
                                    v-model="source.notes"
                                    rows="2"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Catatan tambahan"
                                />
                                <InputError :message="form.errors[`hadist_sources.${index}.notes`]" />
                            </div>
                        </div>
                    </div>
                </div>

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
