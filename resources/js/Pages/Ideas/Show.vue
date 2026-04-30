<script setup>
import { computed } from 'vue';
import { usePage, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import VoteButton from '@/Components/VoteButton.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import CommentCard from '@/Components/CommentCard.vue';
import CommentForm from '@/Components/CommentForm.vue';
import { dashboard } from '@/routes';
import { store } from '@/actions/App/Http/Controllers/CommentController';
import { store as subscribe, destroy as unsubscribe } from '@/routes/account/notifications';

const props = defineProps({
    idea: {
        type: Object,
        required: true,
    },
    comments: {
        type: Array,
        default: () => [],
    },
});

const user = computed(() => usePage().props.auth?.user ?? null);

const subscriptionForm = useForm({});

const toggleSubscription = () => {
    if (props.idea.is_subscribed) {
        subscriptionForm.delete(unsubscribe.url(props.idea.id), { preserveScroll: true });
    } else {
        subscriptionForm.post(subscribe.url(props.idea.id), { preserveScroll: true });
    }
};

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
        <a :href="dashboard.url()" class="inline-flex items-center gap-1 text-xs uppercase tracking-wider text-neutral-400 hover:text-neutral-900 transition-colors mb-6">
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

            <div v-if="idea.latest_status_update?.message" class="mb-6 rounded-none border-l-2 border-neutral-900 bg-neutral-50 p-4">
                <p class="text-sm text-neutral-700 whitespace-pre-line">{{ idea.latest_status_update.message }}</p>
                <p class="mt-2 text-xs uppercase tracking-wider text-neutral-400">
                    {{ idea.latest_status_update.user?.name ?? 'Team' }} — {{ formatDate(idea.latest_status_update.created_at) }}
                </p>
            </div>

            <div class="flex items-center gap-2 mb-6">
                <VoteButton :idea-id="idea.id" :votes="idea.votes" :has-voted="idea.has_voted" />
                <span class="text-sm text-neutral-500">votes</span>

                <button
                    v-if="user"
                    type="button"
                    class="ml-auto text-xs uppercase tracking-wider text-neutral-400 hover:text-neutral-900 transition-colors disabled:opacity-50"
                    :disabled="subscriptionForm.processing"
                    @click="toggleSubscription"
                >
                    {{ idea.is_subscribed ? 'Unsubscribe' : 'Subscribe' }}
                </button>
            </div>

            <p class="text-neutral-700 whitespace-pre-line">{{ idea.description }}</p>
        </div>

        <div class="mt-8">
            <h2 class="text-lg font-semibold tracking-tight text-neutral-900 mb-4">Comments</h2>

            <div v-if="comments.length" class="space-y-3 mb-6">
                <CommentCard v-for="comment in comments" :key="comment.id" :comment="comment" />
            </div>
            <div v-else class="rounded-none border-2 border-dashed border-black/[0.06] p-8 text-center mb-6">
                <p class="text-sm text-neutral-500">No comments yet. Be the first to share your thoughts.</p>
            </div>

            <div v-if="user">
                <CommentForm :action="store.url(idea.id)" />
            </div>
            <div v-else class="rounded-none border border-black/[0.06] bg-white p-4 text-center">
                <a href="/login" class="text-sm font-medium text-neutral-900 hover:underline">Sign in to leave a comment</a>
            </div>
        </div>
    </AppLayout>
</template>
