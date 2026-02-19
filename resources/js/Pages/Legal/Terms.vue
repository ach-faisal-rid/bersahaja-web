<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import LegalDocumentContent from './components/LegalDocumentContent.vue';

const props = defineProps({
    content: {
        type: Object,
        required: true,
    },
});

const pageTitle = computed(() => props.content?.documents?.terms?.page_title || 'Terms & Conditions');
</script>

<template>
    <GuestLayout>
        <Head :title="pageTitle" />
        <LegalDocumentContent :content="content" document-key="terms" />
    </GuestLayout>
</template>
