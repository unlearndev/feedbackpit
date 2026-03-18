<script setup>
import { computed } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

const props = defineProps({
    ideaId: {
        type: Number,
        required: true,
    },
    votes: {
        type: Number,
        required: true,
    },
    hasVoted: {
        type: Boolean,
        required: true,
    },
});

const isGuest = computed(() => !usePage().props.auth?.user);

const vote = () => {
    if (isGuest.value) return;
    router.post(`/ideas/${props.ideaId}/vote`, {}, { preserveScroll: true });
};
</script>

<template>
    <button
        type="button"
        :disabled="isGuest"
        :class="[
            'flex flex-shrink-0 flex-col items-center justify-center w-12 h-12 rounded-lg text-sm font-semibold transition-colors',
            hasVoted
                ? 'bg-neutral-900 text-white'
                : isGuest
                    ? 'border border-gray-200 text-gray-400 cursor-not-allowed'
                    : 'border border-gray-200 text-neutral-900 hover:border-neutral-900 cursor-pointer',
        ]"
        @click="vote"
    >
        <svg class="h-3 w-3 -mb-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
        </svg>
        {{ votes }}
    </button>
</template>
