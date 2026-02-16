<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, watch } from 'vue';

const props = defineProps({
    hadists: {
        type: Array,
        default: () => [],
    },
    doas: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    favoritable_type: 'hadist',
    favoritable_id: '',
});

const titleOptions = computed(() => {
    return form.favoritable_type === 'hadist' ? props.hadists : props.doas;
});

const submit = () => {
    form.post('/favorit/add', {
        preserveScroll: true,
    });
};

watch(
    () => form.favoritable_type,
    () => {
        form.favoritable_id = '';
    }
);
</script>

<template>
    <Head title="Tambah Favorit" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Tambah Favorit
            </h2>
        </template>

        <div class="mx-auto max-w-2xl rounded-xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-900/20">
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <InputLabel for="favoritable_type" value="Jenis Favorit" />
                    <select
                        id="favoritable_type"
                        v-model="form.favoritable_type"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                        required
                    >
                        <option value="hadist">Hadist</option>
                        <option value="doa">Doa</option>
                    </select>
                </div>

                <div>
                    <InputLabel for="favoritable_id" value="Judul" />
                    <select
                        :key="form.favoritable_type"
                        id="favoritable_id"
                        v-model.number="form.favoritable_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
                        required
                    >
                        <option value="" disabled>Pilih judul</option>
                        <option
                            v-for="item in titleOptions"
                            :key="`${form.favoritable_type}-${item.id}`"
                            :value="item.id"
                        >
                            {{ item.judul }}
                        </option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.favoritable_id || form.errors.hadist_id || form.errors.doa_id" />
                </div>

                <div class="flex items-center justify-end gap-2">
                    <Link href="/favorit">
                        <PrimaryButton type="button" class="bg-gray-600 hover:bg-gray-500 focus:bg-gray-500 active:bg-gray-700">
                            Kembali
                        </PrimaryButton>
                    </Link>
                    <PrimaryButton :disabled="form.processing">
                        Simpan
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
