<script setup>
import { computed } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import HijriCalendar from '@/Pages/Hijri/Event/Calendar.vue';
import GuestHero from './components/GuestHero.vue';
import GuestTextCollection from './components/GuestTextCollection.vue';

const page = usePage();
const isAuthenticated = computed(() => Boolean(page.props?.auth?.user));
const activeUserName = computed(() => page.props?.auth?.user?.name || '');

defineProps({
  doas: {
    type: Array,
    default: () => [],
  },
  hadists: {
    type: Array,
    default: () => [],
  },
});
</script>

<template>
  <Head title="Beranda Islami" />

  <div class="guest-shell">
    <GuestHero :is-authenticated="isAuthenticated" :user-name="activeUserName" />

    <section class="panel guest-calendar-panel">
      <h2 class="panel-title">Kalender Hijriah</h2>
      <HijriCalendar
        :sync-enabled="false"
        :pin-enabled="false"
        events-endpoint="/guest/hijri/events"
        list-position="side"
        :compact="true"
      />
    </section>

    <section class="grid-2">
    
    <GuestTextCollection
        title="Doa Pilihan"
        subtitle="Ringkasan doa aktif terbaru"
        empty-text="Belum ada data doa."
        :items="doas"
        translation-key="terjemahan"
        transliteration-key="transliterasi"
        accent="teal"
        :show-tags="true"
    />
      
    <GuestTextCollection
        title="Hadist Pilihan"
        subtitle="Ringkasan hadist terbaru"
        empty-text="Belum ada data hadist."
        :items="hadists"
        translation-key="terjemah"
        transliteration-key="transliterasi"
        accent="amber"
    />
    </section>
  </div>
</template>

<style scoped>
.guest-shell {
  min-height: 100vh;
  max-width: 1200px;
  margin: 0 auto;
  padding: 1.25rem;
  background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
}

.panel {
  margin-top: 0.8rem;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  background: #ffffff;
  padding: 0.9rem;
}

.panel-title {
  font-size: 1rem;
  font-weight: 700;
  color: #0f172a;
  margin-bottom: 0.6rem;
}

.guest-calendar-panel :deep(.calendar-shell) {
  max-width: 820px;
}

.grid-2 {
  display: grid;
  grid-template-columns: 1fr;
  gap: 0.8rem;
}

@media (min-width: 960px) {
  .grid-2 {
    grid-template-columns: 1fr 1fr;
  }
}
</style>
