<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

const statusLabels = {
    under_review: 'Under Review',
    planned: 'Planned',
    in_progress: 'In Progress',
    completed: 'Completed',
};

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
        <a href="/" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-neutral-900 mb-6">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            Back to ideas
        </a>

        <div class="rounded-lg border border-gray-200 bg-white p-6">
            <div class="flex items-start justify-between gap-4 mb-4">
                <h1 class="text-2xl font-bold text-neutral-900">{{ idea.title }}</h1>
                <span class="flex-shrink-0 inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">
                    {{ statusLabels[idea.status] }}
                </span>
            </div>

            <p class="text-sm text-gray-500 mb-6">
                Submitted by {{ idea.user.name }} on {{ formatDate(idea.created_at) }}
            </p>

            <div class="flex items-center gap-2 mb-6">
                <div class="flex items-center justify-center w-12 h-12 rounded-lg border border-gray-200 text-sm font-semibold text-neutral-900">
                    {{ idea.votes }}
                </div>
                <span class="text-sm text-gray-500">votes</span>
            </div>

            <p class="text-gray-700 whitespace-pre-line">{{ idea.description }}</p>
        </div>

        <!-- Comments (coming soon) -->
        <div class="mt-8">
            <h2 class="text-lg font-semibold text-neutral-900 mb-4">Comments</h2>
            <div class="rounded-lg border-2 border-dashed border-gray-300 p-8 text-center">
                <p class="text-sm text-gray-500">Comments are coming soon.</p>
            </div>
        </div>
    </AppLayout>
</template>
