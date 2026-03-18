<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

const statusLabels = {
    under_review: 'Under Review',
    planned: 'Planned',
    in_progress: 'In Progress',
    completed: 'Completed',
};

defineProps({
    ideas: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <AppLayout>
        <h1 class="text-2xl font-bold text-neutral-900 mb-6">Feedback Dashboard</h1>

        <div v-if="ideas.length === 0" class="rounded-lg border-2 border-dashed border-gray-300 p-12 text-center">
            <p class="text-sm text-gray-500">No ideas have been submitted yet.</p>
        </div>

        <div v-else class="space-y-3">
            <div
                v-for="idea in ideas"
                :key="idea.id"
                class="flex items-center gap-4 rounded-lg border border-gray-200 bg-white p-4"
            >
                <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 rounded-lg border border-gray-200 text-sm font-semibold text-neutral-900">
                    {{ idea.votes }}
                </div>

                <div class="min-w-0 flex-1">
                    <p class="font-semibold text-neutral-900">{{ idea.title }}</p>
                    <p class="text-sm text-gray-500 truncate">{{ idea.description }}</p>
                </div>

                <span class="flex-shrink-0 inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">
                    {{ statusLabels[idea.status] }}
                </span>
            </div>
        </div>
    </AppLayout>
</template>
