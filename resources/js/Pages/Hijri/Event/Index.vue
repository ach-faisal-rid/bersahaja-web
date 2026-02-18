<script setup>
import { computed } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import HijriCalendar from './Calendar.vue';

const page = usePage();
const isAuthenticated = computed(() => Boolean(page.props?.auth?.user));
</script>

<template>
  <Head title="Kalender Hijriah" />

  <AuthenticatedLayout v-if="isAuthenticated">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
        Kalender Hijriah
      </h2>
    </template>

    <div class="page-wrap">
      <div class="page-head">
        <p class="caption">Sinkron event dari sumber global dan nasional.</p>
      </div>
      <HijriCalendar />
    </div>
  </AuthenticatedLayout>

  <div v-else class="page-wrap">
    <div class="page-head">
      <h1 class="title">Kalender Hijriah</h1>
      <p class="caption">Sinkron event dari sumber global dan nasional.</p>
    </div>
    <HijriCalendar
      events-endpoint="/guest/hijri/events"
      :sync-enabled="false"
      :pin-enabled="false"
    />
  </div>
</template>

<style scoped>
.page-wrap {
  min-height: 100vh;
  padding: 1.5rem;
  background: linear-gradient(180deg, #f1f5f9 0%, #f8fafc 100%);
}

.page-head {
  max-width: 760px;
  margin: 0 auto 0.9rem;
}

.title {
  font-size: 1.6rem;
  font-weight: 800;
  color: #0f172a;
  letter-spacing: -0.01em;
}

.caption {
  font-size: 0.9rem;
  color: #475569;
  margin-top: 0.25rem;
}
</style>
