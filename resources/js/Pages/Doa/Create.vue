<script setup>
import { watch } from 'vue';
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
    repositories: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    repository_id: '',
    kategori_id: '',
    judul: '',
    teks_arab: '',
    transliterasi: '',
    terjemahan: '',
    description: '',
    is_active: true,
    source: '',
    fetched_at: '',
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

watch(
    () => form.repository_id,
    (repositoryId) => {
        const repository = props.repositories.find((item) => String(item.id) === String(repositoryId));
        if (repository && !form.source) {
            form.source = repository.url;
        }
    }
);

const submit = () => {
    form.post('/doas');
};
</script>

<template>
    <Head title="Tambah Doa" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Tambah Doa
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Tambahkan data doa baru.
                </p>
                <Link href="/doas">
                    <SecondaryButton>Kembali</SecondaryButton>
                </Link>
            </div>

            <form class="grid gap-6 md:grid-cols-2" @submit.prevent="submit">
                <div class="space-y-2">
                    <InputLabel for="repository_id" value="Repository (Opsional)" />
                    <select
                        id="repository_id"
                        v-model="form.repository_id"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option value="">Pilih repository</option>
                        <option v-for="repository in props.repositories" :key="repository.id" :value="repository.id">
                            {{ repository.nama }}
                        </option>
                    </select>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        `remote_id` akan dibuat otomatis dari repository + judul.
                    </p>
                    <InputError :message="form.errors.repository_id" />
                </div>

                <div class="space-y-2">
                    <InputLabel for="kategori_id" value="Kategori" />
                    <select
                        id="kategori_id"
                        v-model="form.kategori_id"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option value="">Pilih kategori</option>
                        <option v-for="category in props.categories" :key="category.id" :value="category.id">
                            {{ category.nama }}
                        </option>
                    </select>
                    <InputError :message="form.errors.kategori_id" />
                </div>

                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="judul" value="Judul Doa" />
                    <TextInput id="judul" v-model="form.judul" type="text" class="block w-full" />
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
                        rows="3"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    />
                    <InputError :message="form.errors.transliterasi" />
                </div>

                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="terjemahan" value="Terjemahan" />
                    <textarea
                        id="terjemahan"
                        v-model="form.terjemahan"
                        rows="3"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    />
                    <InputError :message="form.errors.terjemahan" />
                </div>

                <div class="space-y-2 md:col-span-2">
                    <InputLabel for="description" value="Deskripsi (Opsional)" />
                    <textarea
                        id="description"
                        v-model="form.description"
                        rows="2"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    />
                    <InputError :message="form.errors.description" />
                </div>

                <div class="space-y-2">
                    <InputLabel for="source" value="Sumber (Opsional)" />
                    <TextInput id="source" v-model="form.source" type="text" class="block w-full" />
                    <InputError :message="form.errors.source" />
                </div>

                <div class="space-y-2">
                    <InputLabel for="fetched_at" value="Fetched At (Opsional)" />
                    <TextInput id="fetched_at" v-model="form.fetched_at" type="datetime-local" class="block w-full" />
                    <InputError :message="form.errors.fetched_at" />
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

                <div class="space-y-2 md:col-span-2">
                    <label for="is_active" class="flex items-center gap-3 text-sm text-gray-700 dark:text-gray-300">
                        <input
                            id="is_active"
                            v-model="form.is_active"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        >
                        <span>Aktifkan doa</span>
                    </label>
                    <InputError :message="form.errors.is_active" />
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

