<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  isAuthenticated: {
    type: Boolean,
    default: false,
  },
  userName: {
    type: String,
    default: '',
  },
});
</script>

<template>
  <header class="hero">
    <div>
      <h1 class="hero-title">Beranda Islami</h1>
      <p class="hero-sub">Doa, Kalender Hijriah, dan Hadist dalam satu halaman publik.</p>
      <p class="hero-status" :class="{ on: isAuthenticated }">
        {{ isAuthenticated ? `Status: Aktif sebagai ${userName || 'User'}` : 'Status: Belum login' }}
      </p>
    </div>

    <div class="hero-actions">
      <Link v-if="isAuthenticated" :href="route('dashboard')" class="btn btn-main">Dashboard</Link>
      <template v-else>
        <Link :href="route('login')" class="btn btn-main">Login</Link>
        <Link :href="route('register')" class="btn btn-soft">Register</Link>
      </template>
    </div>
  </header>
</template>

<style scoped>
.hero {
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  padding: 1rem;
  background: #ffffff;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 0.8rem;
}

.hero-title {
  font-size: 1.5rem;
  font-weight: 800;
  color: #0f172a;
}

.hero-sub {
  margin-top: 0.2rem;
  color: #475569;
  font-size: 0.9rem;
}

.hero-status {
  margin-top: 0.35rem;
  font-size: 0.75rem;
  color: #b45309;
  font-weight: 600;
}

.hero-status.on {
  color: #166534;
}

.hero-actions {
  display: flex;
  gap: 0.5rem;
}

.btn {
  border-radius: 10px;
  padding: 0.42rem 0.75rem;
  font-size: 0.78rem;
  font-weight: 700;
  text-decoration: none;
}

.btn-main {
  background: #0f172a;
  color: #ffffff;
}

.btn-soft {
  background: #e2e8f0;
  color: #0f172a;
}
</style>
