<script setup>
import InternalLayout from '@/Layouts/InternalLayout.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import StatusUpdateForm from '@/Components/StatusUpdateForm.vue';
import CommentCard from '@/Components/CommentCard.vue';
import CommentForm from '@/Components/CommentForm.vue';
import NoteCard from '@/Components/NoteCard.vue';
import NoteForm from '@/Components/NoteForm.vue';
import { store as storeComment } from '@/actions/App/Http/Controllers/Internal/CommentController';
import { store as storeNote } from '@/actions/App/Http/Controllers/Internal/NoteController';

defineProps({
    idea: {
        type: Object,
        required: true,
    },
    comments: {
        type: Array,
        default: () => [],
    },
    internalComments: {
        type: Array,
        default: () => [],
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
    <InternalLayout>
        <a href="/internal" class="inline-flex items-center gap-1 text-xs uppercase tracking-wider text-neutral-400 hover:text-neutral-900 transition-colors mb-6">
            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
            Back to ideas
        </a>

        <div class="rounded-none border border-black/[0.06] bg-white p-6 mb-8">
            <div class="flex items-start justify-between gap-4 mb-4">
                <h1 class="text-2xl font-semibold tracking-tight text-neutral-900">{{ idea.title }}</h1>
                <StatusBadge :status="idea.status" class="flex-shrink-0" />
            </div>

            <div class="flex items-center gap-4 text-xs text-neutral-400 mb-6">
                <span>Submitted by {{ idea.user.name }} on {{ formatDate(idea.created_at) }}</span>
                <span>{{ idea.votes }} {{ idea.votes === 1 ? 'vote' : 'votes' }}</span>
            </div>

            <p class="text-neutral-700 whitespace-pre-line">{{ idea.description }}</p>
        </div>

        <div class="rounded-none border border-black/[0.06] bg-white p-6 mb-8">
            <h2 class="text-lg font-semibold tracking-tight text-neutral-900 mb-4">Update Status</h2>
            <StatusUpdateForm :idea="idea" />

            <div v-if="idea.status_updates && idea.status_updates.length" class="mt-8 border-t border-black/[0.06] pt-6">
                <h3 class="text-xs font-medium uppercase tracking-wider text-neutral-500 mb-3">History</h3>
                <ul class="space-y-3">
                    <li v-for="update in idea.status_updates" :key="update.id" class="text-sm">
                        <div class="flex flex-wrap items-center gap-2 text-neutral-600">
                            <span class="font-medium text-neutral-900">{{ update.user?.name ?? 'Team' }}</span>
                            <span>moved this from</span>
                            <StatusBadge :status="update.from_status" />
                            <span>to</span>
                            <StatusBadge :status="update.to_status" />
                            <span class="text-xs text-neutral-400">{{ formatDate(update.created_at) }}</span>
                        </div>
                        <p v-if="update.message" class="mt-1 text-neutral-700 whitespace-pre-line">{{ update.message }}</p>
                    </li>
                </ul>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div>
                <h2 class="text-lg font-semibold tracking-tight text-neutral-900 mb-4">Public Comments</h2>

                <div v-if="comments.length" class="space-y-3 mb-6">
                    <CommentCard v-for="comment in comments" :key="comment.id" :comment="comment" />
                </div>
                <div v-else class="rounded-none border-2 border-dashed border-black/[0.06] p-8 text-center mb-6">
                    <p class="text-sm text-neutral-500">No public comments yet.</p>
                </div>

                <CommentForm :action="storeComment.url(idea.id)" />
            </div>

            <div>
                <h2 class="text-lg font-semibold tracking-tight text-neutral-900 mb-4">Internal Notes</h2>

                <div v-if="internalComments.length" class="space-y-3 mb-6">
                    <NoteCard v-for="note in internalComments" :key="note.id" :note="note" />
                </div>
                <div v-else class="rounded-none border-2 border-dashed border-black/[0.06] p-8 text-center mb-6">
                    <p class="text-sm text-neutral-500">No internal notes yet.</p>
                </div>

                <NoteForm :action="storeNote.url(idea.id)" />
            </div>
        </div>
    </InternalLayout>
</template>
