<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import VoteButton from '@/Components/VoteButton.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import { show } from '@/actions/App/Http/Controllers/IdeaController';

defineProps({
    ideas: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <AppLayout>
        <h1 class="text-2xl font-semibold tracking-tight text-neutral-900 mb-6">Dashboard</h1>

        <div v-if="ideas.length === 0" class="rounded-none border-2 border-dashed border-black/[0.06] p-12 text-center">
            <p class="text-sm text-neutral-500">No feedback has been submitted yet.</p>
        </div>

        <div v-else class="space-y-3">
            <div
                v-for="idea in ideas"
                :key="idea.id"
                class="flex items-center gap-4 rounded-none border border-black/[0.06] bg-white p-4 hover:border-black/[0.06] transition-colors"
            >
                <VoteButton :idea-id="idea.id" :votes="idea.votes" :has-voted="idea.has_voted" />

                <div class="min-w-0 flex-1">
                    <a :href="show.url(idea.id)" class="font-semibold text-neutral-900 hover:text-neutral-600 transition-colors duration-150">{{ idea.title }}</a>
                    <p class="text-sm text-neutral-500 truncate">{{ idea.description }}</p>
                </div>

                <StatusBadge :status="idea.status" class="flex-shrink-0" />
            </div>
        </div>
    </AppLayout>
</template>
