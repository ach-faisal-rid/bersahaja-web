<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import HijriCalendar from '@/Pages/Hijri/Event/Calendar.vue';
import GuestHero from './components/GuestHero.vue';
import GuestTextCollection from './components/GuestTextCollection.vue';

const page = usePage();
const isAuthenticated = computed(() => Boolean(page.props?.auth?.user));
const activeUserName = computed(() => page.props?.auth?.user?.name || '');
const shalatModules = [
  {
    id: 'tata-cara',
    title: 'Tata Cara Shalat',
    description: 'Urutan langkah pelaksanaan shalat dari awal sampai akhir.',
    href: '/tata-cara',
    badge: 'Panduan',
  },
  {
    id: 'gerakan-shalat',
    title: 'Gerakan Shalat',
    description: 'Detail setiap gerakan, urutan global, dan kategori gerakan.',
    href: '/gerakan-shalat',
    badge: 'Gerakan',
  },
  {
    id: 'bacaan',
    title: 'Bacaan Shalat',
    description: 'Kumpulan bacaan arab, transliterasi, dan terjemahan.',
    href: '/bacaan',
    badge: 'Bacaan',
  },
  {
    id: 'wudu',
    title: 'Panduan Wudu',
    description: 'Tahapan wudu berurutan, termasuk doa dan tips penting.',
    href: '/wudu',
    badge: 'Wudu',
  },
];

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

    <section class="panel shalat-panel">
      <div class="panel-head">
        <div>
          <h2 class="panel-title">Pusat Shalat</h2>
          <p class="panel-subtitle">Akses cepat ke panduan shalat yang sudah tersedia untuk publik.</p>
        </div>
        <span class="panel-pill">Read-only untuk guest</span>
      </div>

      <div class="shalat-grid">
        <article v-for="module in shalatModules" :key="module.id" class="shalat-card">
          <div class="shalat-top">
            <h3 class="shalat-title">{{ module.title }}</h3>
            <span class="shalat-badge">{{ module.badge }}</span>
          </div>
          <p class="shalat-desc">{{ module.description }}</p>
          <Link :href="module.href" class="shalat-link">Buka</Link>
        </article>
      </div>
    </section>

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
      translation-key="terjemahan"
        transliteration-key="transliterasi"
        accent="amber"
    />
    
    </section>

    <footer class="home-footer">
      <p class="home-footer-text">Dengan menggunakan layanan ini, Anda menyetujui ketentuan kami.</p>
      <div class="home-footer-links">
        <Link :href="route('legal.terms')" class="home-footer-link">Terms &amp; Conditions</Link>
        <span class="home-footer-separator">|</span>
        <Link :href="route('legal.privacy')" class="home-footer-link">Privacy Policy</Link>
      </div>
    </footer>
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

.panel-head {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 0.75rem;
}

.panel-subtitle {
  margin-top: -0.2rem;
  font-size: 0.8rem;
  color: #64748b;
}

.panel-pill {
  border-radius: 999px;
  background: #cffafe;
  color: #0f766e;
  padding: 0.22rem 0.55rem;
  font-size: 0.66rem;
  font-weight: 700;
  white-space: nowrap;
}

.shalat-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 0.65rem;
}

.shalat-card {
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
  padding: 0.7rem;
}

.shalat-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 0.5rem;
}

.shalat-title {
  font-size: 0.9rem;
  font-weight: 700;
  color: #0f172a;
}

.shalat-badge {
  border-radius: 999px;
  background: #e2e8f0;
  color: #334155;
  padding: 0.12rem 0.45rem;
  font-size: 0.62rem;
  font-weight: 700;
}

.shalat-desc {
  margin-top: 0.35rem;
  font-size: 0.77rem;
  line-height: 1.4;
  color: #475569;
}

.shalat-link {
  margin-top: 0.5rem;
  display: inline-flex;
  text-decoration: none;
  border-radius: 9px;
  border: 1px solid #cbd5e1;
  background: #ffffff;
  color: #0f172a;
  font-size: 0.72rem;
  font-weight: 700;
  padding: 0.3rem 0.55rem;
}

.shalat-link:hover {
  background: #0f172a;
  color: #ffffff;
  border-color: #0f172a;
}

.guest-calendar-panel ::v-deep(.calendar-shell) {
  max-width: 820px;
  margin: 0 auto;
}

.grid-2 {
  display: grid;
  grid-template-columns: 1fr;
  gap: 0.8rem;
}

.home-footer {
  margin-top: 0.85rem;
  padding: 0.85rem 0.75rem;
  border-top: 1px solid #cbd5e1;
  text-align: center;
}

.home-footer-text {
  margin: 0;
  font-size: 0.76rem;
  color: #64748b;
}

.home-footer-links {
  margin-top: 0.35rem;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 0.35rem;
}

.home-footer-link {
  font-size: 0.76rem;
  font-weight: 600;
  color: #0f172a;
  text-decoration: underline;
  text-underline-offset: 2px;
}

.home-footer-link:hover {
  color: #0f766e;
}

.home-footer-separator {
  font-size: 0.7rem;
  color: #94a3b8;
}

@media (min-width: 960px) {
  .shalat-grid {
    grid-template-columns: 1fr 1fr;
  }

  .grid-2 {
    grid-template-columns: 1fr 1fr;
  }
}
</style>
