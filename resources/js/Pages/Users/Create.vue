<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'user',
});

const submit = () => {
    form.post('/users');
};
</script>

<template>
    <Head title="Create User" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Create User
            </h2>
        </template>

        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Tambahkan user baru dan tentukan kredensialnya.
                </p>
                <Link href="/users">
                    <SecondaryButton>Kembali</SecondaryButton>
                </Link>
            </div>

            <form class="grid gap-6 md:grid-cols-2" @submit.prevent="submit">
                <div class="space-y-2">
                    <InputLabel for="name" value="Nama" />
                    <TextInput
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="block w-full"
                        autocomplete="name"
                        autofocus
                    />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="space-y-2">
                    <InputLabel for="email" value="Email" />
                    <TextInput
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="block w-full"
                        autocomplete="email"
                    />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="space-y-2">
                    <InputLabel for="role" value="Role" />
                    <select
                        id="role"
                        v-model="form.role"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                    <InputError :message="form.errors.role" />
                </div>

                <div class="space-y-2">
                    <InputLabel for="password" value="Password" />
                    <TextInput
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="block w-full"
                        autocomplete="new-password"
                    />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="space-y-2">
                    <InputLabel for="password_confirmation" value="Konfirmasi Password" />
                    <TextInput
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        class="block w-full"
                        autocomplete="new-password"
                    />
                    <InputError :message="form.errors.password_confirmation" />
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
