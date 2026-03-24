<script setup>
import InternalLayout from '@/Layouts/InternalLayout.vue';
import StatusBadge from '@/Components/StatusBadge.vue';

defineProps({
    ideas: {
        type: Array,
        required: true,
    },
});

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};
</script>

<template>
    <InternalLayout>
        <h1 class="text-2xl font-semibold tracking-tight text-neutral-900 mb-6">Ideas</h1>

        <div v-if="ideas.length === 0" class="rounded-none border-2 border-dashed border-black/[0.06] p-12 text-center">
            <p class="text-sm text-neutral-500">No ideas yet.</p>
        </div>

        <div v-else class="space-y-3">
            <a
                v-for="idea in ideas"
                :key="idea.id"
                href="#"
                class="flex items-center gap-4 rounded-none border border-black/[0.06] bg-white p-4 hover:border-neutral-300 transition-colors"
            >
                <div class="flex flex-shrink-0 flex-col items-center justify-center w-12 h-12 rounded-none border border-black/[0.06] text-sm font-semibold text-neutral-900">
                    <svg class="h-3 w-3 -mb-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                    </svg>
                    {{ idea.votes }}
                </div>

                <div class="min-w-0 flex-1">
                    <span class="font-semibold text-neutral-900">{{ idea.title }}</span>
                    <div class="flex items-center gap-3 mt-1 text-xs text-neutral-400">
                        <span>{{ idea.user.name }}</span>
                        <span>{{ formatDate(idea.created_at) }}</span>
                        <span v-if="idea.comments_count !== undefined">{{ idea.comments_count }} {{ idea.comments_count === 1 ? 'comment' : 'comments' }}</span>
                    </div>
                </div>

                <StatusBadge :status="idea.status" class="flex-shrink-0" />
            </a>
        </div>
    </InternalLayout>
</template>
