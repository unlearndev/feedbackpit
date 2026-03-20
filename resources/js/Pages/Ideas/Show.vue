<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import VoteButton from '@/Components/VoteButton.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import { home } from '@/routes';

defineProps({
    idea: {
        type: Object,
        required: true,
    },
});

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};
</script>

<template>
    <AppLayout>
        <a :href="home.url()" class="inline-flex items-center gap-1 text-xs uppercase tracking-wider text-neutral-400 hover:text-neutral-900 transition-colors mb-6">
            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            Back to dashboard
        </a>

        <div class="rounded-none border border-black/[0.06] bg-white p-6">
            <div class="flex items-start justify-between gap-4 mb-4">
                <h1 class="text-2xl font-semibold tracking-tight text-neutral-900">{{ idea.title }}</h1>
                <StatusBadge :status="idea.status" class="flex-shrink-0" />
            </div>

            <p class="text-xs uppercase tracking-wider text-neutral-400 mb-6">
                Submitted by {{ idea.user.name }} on {{ formatDate(idea.created_at) }}
            </p>

            <div class="flex items-center gap-2 mb-6">
                <VoteButton :idea-id="idea.id" :votes="idea.votes" :has-voted="idea.has_voted" />
                <span class="text-sm text-neutral-500">votes</span>
            </div>

            <p class="text-neutral-700 whitespace-pre-line">{{ idea.description }}</p>
        </div>

        <!-- Comments (coming soon) -->
        <div class="mt-8">
            <h2 class="text-lg font-semibold tracking-tight text-neutral-900 mb-4">Comments</h2>
            <div class="rounded-none border-2 border-dashed border-black/[0.06] p-8 text-center">
                <p class="text-sm text-neutral-500">Comments are coming soon.</p>
            </div>
        </div>
    </AppLayout>
</template>
