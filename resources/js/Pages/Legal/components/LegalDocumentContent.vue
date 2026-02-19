<script setup>
import { computed } from 'vue';

const props = defineProps({
    content: {
        type: Object,
        required: true,
    },
    documentKey: {
        type: String,
        required: true,
    },
});

const project = computed(() => props.content?.project ?? {});
const documentContent = computed(() => props.content?.documents?.[props.documentKey] ?? {});

const HIGHLIGHT = {
    important: {
        label: 'Penting',
        icon: 'shield',
        badgeClass: 'badge-important',
        cardClass: 'card-important',
    },
    warning: {
        label: 'Peringatan',
        icon: 'warning',
        badgeClass: 'badge-warning',
        cardClass: 'card-warning',
    },
    info: {
        label: 'Info',
        icon: 'info',
        badgeClass: 'badge-info',
        cardClass: 'card-info',
    },
    new: {
        label: 'Baru',
        icon: 'spark',
        badgeClass: 'badge-new',
        cardClass: 'card-new',
    },
};

const getHighlightMeta = (type) => HIGHLIGHT[type] ?? HIGHLIGHT.info;

const normalizedSections = computed(() =>
    (documentContent.value.sections ?? []).map((section, index) => {
        const type = section?.type ?? 'info';
        const blocks = Array.isArray(section?.blocks)
            ? section.blocks
            : [
                  ...(section?.paragraphs ?? []).map((text) => ({
                      kind: 'paragraph',
                      text,
                  })),
                  ...(section?.points ?? []).length
                      ? [{ kind: 'list', items: section.points }]
                      : [],
              ];

        return {
            id: section?.id ?? `${section?.title ?? 'section'}-${index}`,
            title: section?.title ?? 'Section',
            blocks,
            statusText: section?.status_text ?? getHighlightMeta(type).label,
            statusBadgeClass: getHighlightMeta(type).badgeClass,
            cardClass: getHighlightMeta(type).cardClass,
            icon: section?.icon ?? getHighlightMeta(type).icon,
        };
    })
);
</script>

<template>
    <article class="legal-shell">
        <header class="legal-header">
            <h1>{{ documentContent.heading }}</h1>
            <p>Last updated: {{ documentContent.last_updated }}</p>
        </header>

        <p class="legal-intro">{{ documentContent.intro }}</p>

        <section
            v-for="(section, index) in normalizedSections"
            :key="section.id"
            class="legal-card"
            :class="section.cardClass"
            :style="{ '--delay': `${index * 70}ms` }"
        >
            <div class="section-top">
                <div class="section-title-wrap">
                    <span class="section-icon">
                        <svg
                            v-if="section.icon === 'shield'"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="M12 3l7 3v6c0 5-3.5 8.5-7 9-3.5-.5-7-4-7-9V6l7-3z" />
                        </svg>
                        <svg
                            v-else-if="section.icon === 'warning'"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="M12 4l9 16H3l9-16z" />
                            <path d="M12 10v4" />
                            <circle cx="12" cy="17" r="1" />
                        </svg>
                        <svg
                            v-else-if="section.icon === 'spark'"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path d="M12 3l1.7 4.3L18 9l-4.3 1.7L12 15l-1.7-4.3L6 9l4.3-1.7L12 3z" />
                            <path d="M5 16l.9 2.1L8 19l-2.1.9L5 22l-.9-2.1L2 19l2.1-.9L5 16z" />
                        </svg>
                        <svg
                            v-else
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 10v6" />
                            <circle cx="12" cy="7" r="1" />
                        </svg>
                    </span>
                    <h2>{{ section.title }}</h2>
                </div>
                <span class="status-badge" :class="section.statusBadgeClass">
                    {{ section.statusText }}
                </span>
            </div>

            <template v-for="(block, blockIndex) in section.blocks" :key="`${section.id}-${blockIndex}`">
                <p v-if="block.kind === 'paragraph'">{{ block.text }}</p>
                <ul v-else-if="block.kind === 'list'" class="content-list">
                    <li v-for="item in block.items || []" :key="item">{{ item }}</li>
                </ul>
                <div v-else-if="block.kind === 'note'" class="inline-note">
                    {{ block.text }}
                </div>
            </template>
        </section>

        <section class="legal-card">
            <h2>Tentang Proyek</h2>
            <p>
                <strong>{{ project.project_name }}</strong> dikembangkan oleh
                <strong>{{ project.developed_by }}</strong>.
            </p>
        </section>

        <section class="legal-card">
            <h2>Tim Pengembang</h2>
            <ul>
                <li v-for="member in project.team_members || []" :key="`${member.name}-${member.role}`">
                    {{ member.name }} - {{ member.role }}
                </li>
            </ul>
        </section>

        <section class="legal-card">
            <h2>Rencana Pengembangan Selanjutnya</h2>
            <ul>
                <li v-for="plan in project.upcoming_plans || []" :key="plan">{{ plan }}</li>
            </ul>
        </section>
    </article>
</template>

<style scoped>
.legal-shell {
    display: grid;
    gap: 0.75rem;
}

.legal-header h1 {
    font-size: 1.25rem;
    font-weight: 800;
    color: #0f172a;
}

.legal-header p {
    margin-top: 0.2rem;
    font-size: 0.8rem;
    color: #64748b;
}

.legal-intro {
    font-size: 0.9rem;
    color: #334155;
}

.legal-card {
    border: 1px solid #dbe4ef;
    border-radius: 14px;
    padding: 0.9rem;
    background: #ffffff;
    box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
    transition: transform 220ms ease, box-shadow 220ms ease;
    animation: cardIn 480ms ease both;
    animation-delay: var(--delay, 0ms);
}

.legal-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 30px rgba(15, 23, 42, 0.1);
}

.section-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.6rem;
    margin-bottom: 0.4rem;
}

.section-title-wrap {
    display: flex;
    align-items: center;
    gap: 0.55rem;
}

.section-icon {
    width: 1.8rem;
    height: 1.8rem;
    border-radius: 999px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: rgba(15, 23, 42, 0.08);
    color: #0f172a;
}

.section-icon svg {
    width: 0.95rem;
    height: 0.95rem;
}

.status-badge {
    border-radius: 999px;
    padding: 0.22rem 0.58rem;
    font-size: 0.7rem;
    font-weight: 700;
    white-space: nowrap;
}

.badge-important {
    color: #991b1b;
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
}

.badge-warning {
    color: #92400e;
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
}

.badge-info {
    color: #1e3a8a;
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
}

.badge-new {
    color: #166534;
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
}

.card-important {
    background: linear-gradient(180deg, #fff7f7 0%, #ffffff 55%);
}

.card-warning {
    background: linear-gradient(180deg, #fffaf0 0%, #ffffff 55%);
}

.card-info {
    background: linear-gradient(180deg, #f5f9ff 0%, #ffffff 55%);
}

.card-new {
    background: linear-gradient(180deg, #f3fff8 0%, #ffffff 55%);
}

.legal-card h2 {
    font-size: 1rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0.4rem;
}

.legal-card p,
.legal-card li {
    font-size: 0.86rem;
    line-height: 1.5;
    color: #334155;
}

.legal-card ul {
    margin: 0;
    padding-left: 1rem;
}

.content-list {
    margin-top: 0.2rem;
}

.inline-note {
    margin-top: 0.35rem;
    border-left: 3px solid #94a3b8;
    padding: 0.35rem 0.55rem;
    font-size: 0.82rem;
    color: #475569;
    background: #f8fafc;
    border-radius: 8px;
}

@keyframes cardIn {
    from {
        opacity: 0;
        transform: translateY(8px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
