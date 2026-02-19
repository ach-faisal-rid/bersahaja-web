<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
    content: {
        type: Object,
        required: true,
    },
});

const page = usePage();

const deepCopy = (value) => JSON.parse(JSON.stringify(value ?? null));

const normalizeDocument = (doc) => ({
    page_title: doc?.page_title ?? '',
    heading: doc?.heading ?? '',
    last_updated: doc?.last_updated ?? '',
    intro: doc?.intro ?? '',
    sections: Array.isArray(doc?.sections) ? deepCopy(doc.sections) : [],
});

const form = useForm({
    project: deepCopy({
        project_name: props.content?.project?.project_name ?? '',
        developed_by: props.content?.project?.developed_by ?? '',
        team_members: Array.isArray(props.content?.project?.team_members) ? deepCopy(props.content.project.team_members) : [],
        upcoming_plans: Array.isArray(props.content?.project?.upcoming_plans) ? deepCopy(props.content.project.upcoming_plans) : [],
    }),
    documents: {
        terms: deepCopy(normalizeDocument(props.content?.documents?.terms)),
        privacy: deepCopy(normalizeDocument(props.content?.documents?.privacy)),
    },
});

const addTeamMember = () => {
    form.project.team_members.push({ name: '', role: '' });
};

const removeTeamMember = (index) => {
    form.project.team_members.splice(index, 1);
};

const addPlan = () => {
    form.project.upcoming_plans.push('');
};

const removePlan = (index) => {
    form.project.upcoming_plans.splice(index, 1);
};

const addSection = (docType) => {
    form.documents[docType].sections.push({ title: '', paragraphs: [''] });
};

const removeSection = (docType, sectionIndex) => {
    form.documents[docType].sections.splice(sectionIndex, 1);
};

const addParagraph = (docType, sectionIndex) => {
    if (!Array.isArray(form.documents[docType].sections[sectionIndex].paragraphs)) {
        form.documents[docType].sections[sectionIndex].paragraphs = [];
    }
    form.documents[docType].sections[sectionIndex].paragraphs.push('');
};

const removeParagraph = (docType, sectionIndex, paragraphIndex) => {
    form.documents[docType].sections[sectionIndex].paragraphs.splice(paragraphIndex, 1);
};

const submit = () => {
    form.put(route('admin.legal.update'));
};
</script>

<template>
    <Head title="Kelola Legal Content" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Kelola Terms, Privacy, dan Profil Proyek
            </h2>
        </template>

        <div class="space-y-6">
            <div v-if="page.props?.flash?.status" class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ page.props.flash.status }}
            </div>

            <form class="space-y-8" @submit.prevent="submit">
                <section class="space-y-4 rounded-xl border border-gray-200 p-4">
                    <h3 class="text-lg font-semibold">Profil Proyek</h3>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="space-y-2">
                            <InputLabel for="project_name" value="Nama Proyek" />
                            <TextInput id="project_name" v-model="form.project.project_name" type="text" class="block w-full" />
                            <InputError :message="form.errors['project.project_name']" />
                        </div>

                        <div class="space-y-2">
                            <InputLabel for="developed_by" value="Dikembangkan Oleh" />
                            <TextInput id="developed_by" v-model="form.project.developed_by" type="text" class="block w-full" />
                            <InputError :message="form.errors['project.developed_by']" />
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <h4 class="font-medium">Tim Pengembang</h4>
                            <SecondaryButton type="button" @click="addTeamMember">Tambah Anggota</SecondaryButton>
                        </div>
                        <div v-for="(member, memberIndex) in form.project.team_members" :key="`member-${memberIndex}`" class="grid gap-3 rounded-lg border border-gray-200 p-3 md:grid-cols-3">
                            <TextInput v-model="member.name" type="text" class="block w-full" placeholder="Nama" />
                            <TextInput v-model="member.role" type="text" class="block w-full" placeholder="Role" />
                            <SecondaryButton type="button" @click="removeTeamMember(memberIndex)">Hapus</SecondaryButton>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <h4 class="font-medium">Rencana ke Depan</h4>
                            <SecondaryButton type="button" @click="addPlan">Tambah Rencana</SecondaryButton>
                        </div>
                        <div v-for="(plan, planIndex) in form.project.upcoming_plans" :key="`plan-${planIndex}`" class="grid gap-3 rounded-lg border border-gray-200 p-3 md:grid-cols-6">
                            <TextInput v-model="form.project.upcoming_plans[planIndex]" type="text" class="block w-full md:col-span-5" placeholder="Isi rencana pengembangan" />
                            <SecondaryButton type="button" @click="removePlan(planIndex)">Hapus</SecondaryButton>
                        </div>
                    </div>
                </section>

                <section v-for="docType in ['terms', 'privacy']" :key="docType" class="space-y-4 rounded-xl border border-gray-200 p-4">
                    <h3 class="text-lg font-semibold capitalize">{{ docType }} Document</h3>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="space-y-2">
                            <InputLabel :for="`${docType}_page_title`" value="Page Title" />
                            <TextInput :id="`${docType}_page_title`" v-model="form.documents[docType].page_title" type="text" class="block w-full" />
                            <InputError :message="form.errors[`documents.${docType}.page_title`]" />
                        </div>

                        <div class="space-y-2">
                            <InputLabel :for="`${docType}_heading`" value="Heading" />
                            <TextInput :id="`${docType}_heading`" v-model="form.documents[docType].heading" type="text" class="block w-full" />
                            <InputError :message="form.errors[`documents.${docType}.heading`]" />
                        </div>

                        <div class="space-y-2">
                            <InputLabel :for="`${docType}_last_updated`" value="Last Updated" />
                            <TextInput :id="`${docType}_last_updated`" v-model="form.documents[docType].last_updated" type="text" class="block w-full" />
                            <InputError :message="form.errors[`documents.${docType}.last_updated`]" />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <InputLabel :for="`${docType}_intro`" value="Intro" />
                        <textarea
                            :id="`${docType}_intro`"
                            v-model="form.documents[docType].intro"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            rows="3"
                        />
                        <InputError :message="form.errors[`documents.${docType}.intro`]" />
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <h4 class="font-medium">Sections</h4>
                            <SecondaryButton type="button" @click="addSection(docType)">Tambah Section</SecondaryButton>
                        </div>

                        <div v-for="(section, sectionIndex) in form.documents[docType].sections" :key="`${docType}-section-${sectionIndex}`" class="space-y-3 rounded-lg border border-gray-200 p-3">
                            <div class="grid gap-3 md:grid-cols-6">
                                <TextInput v-model="section.title" type="text" class="block w-full md:col-span-5" placeholder="Judul section" />
                                <SecondaryButton type="button" @click="removeSection(docType, sectionIndex)">Hapus Section</SecondaryButton>
                            </div>

                            <div class="space-y-2">
                                <div
                                    v-for="(paragraph, paragraphIndex) in section.paragraphs"
                                    :key="`${docType}-section-${sectionIndex}-paragraph-${paragraphIndex}`"
                                    class="grid gap-3 md:grid-cols-6"
                                >
                                    <textarea
                                        v-model="section.paragraphs[paragraphIndex]"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 md:col-span-5"
                                        rows="2"
                                        placeholder="Isi paragraf"
                                    />
                                    <SecondaryButton type="button" @click="removeParagraph(docType, sectionIndex, paragraphIndex)">Hapus</SecondaryButton>
                                </div>
                                <SecondaryButton type="button" @click="addParagraph(docType, sectionIndex)">Tambah Paragraf</SecondaryButton>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="flex justify-end">
                    <PrimaryButton :disabled="form.processing">
                        Simpan Perubahan
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
