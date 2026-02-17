<template>
  <div v-if="open" class="modal-overlay" @click.self="$emit('close')">
    <div class="modal-card">
      <h3 class="modal-title">Pin Tanggal Hijriah</h3>
      <p class="modal-subtitle">
        {{ cell ? `${cell.hijriDay} ${cell.hijriMonthName} ${cell.hijriYear} H` : '-' }}
      </p>
      <textarea
        :value="modelValue"
        class="modal-textarea"
        rows="3"
        placeholder="Catatan pin (opsional)"
        @input="$emit('update:modelValue', $event.target.value)"
      />
      <div class="modal-actions">
        <button type="button" class="btn btn-soft" @click="$emit('close')">Batal</button>
        <button
          v-if="cell?.isPinned"
          type="button"
          class="btn btn-danger"
          @click="$emit('remove')"
        >
          Unpin
        </button>
        <button type="button" class="btn btn-main" @click="$emit('save')">Simpan</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PinNoteDialog',
  props: {
    open: {
      type: Boolean,
      default: false,
    },
    cell: {
      type: Object,
      default: null,
    },
    modelValue: {
      type: String,
      default: '',
    },
  },
  emits: ['close', 'save', 'remove', 'update:modelValue'],
};
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(2, 6, 23, 0.45);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 60;
  padding: 1rem;
}

.modal-card {
  width: 100%;
  max-width: 420px;
  border-radius: 14px;
  border: 1px solid #e2e8f0;
  background: #ffffff;
  padding: 0.9rem;
}

.modal-title {
  font-size: 0.95rem;
  font-weight: 700;
  color: #0f172a;
}

.modal-subtitle {
  margin-top: 0.2rem;
  font-size: 0.74rem;
  color: #475569;
}

.modal-textarea {
  width: 100%;
  margin-top: 0.6rem;
  border: 1px solid #cbd5e1;
  border-radius: 10px;
  padding: 0.5rem;
  font-size: 0.8rem;
}

.modal-actions {
  margin-top: 0.65rem;
  display: flex;
  justify-content: flex-end;
  gap: 0.45rem;
}

.btn {
  border: 0;
  border-radius: 9px;
  padding: 0.35rem 0.64rem;
  font-size: 0.73rem;
  font-weight: 700;
  cursor: pointer;
}

.btn-main {
  background: #0f172a;
  color: #fff;
}

.btn-soft {
  background: #e2e8f0;
  color: #0f172a;
}

.btn-danger {
  background: #fee2e2;
  color: #b91c1c;
}
</style>
