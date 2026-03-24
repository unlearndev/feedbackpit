<script setup>
import StaffBadge from '@/Components/StaffBadge.vue';

defineProps({
    comment: {
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
    <div class="rounded-none border border-black/[0.06] bg-white p-4">
        <div class="flex items-center gap-2 mb-2">
            <img
                :src="comment.user.avatar_url"
                :alt="`${comment.user.name} avatar`"
                class="h-6 w-6 rounded-full"
            >
            <span class="text-sm font-medium text-neutral-900">{{ comment.user.name }}</span>
            <StaffBadge v-if="comment.user.is_team_member" />
            <span class="text-xs text-neutral-400">{{ formatDate(comment.created_at) }}</span>
        </div>
        <p class="text-sm text-neutral-700 whitespace-pre-line">{{ comment.body }}</p>
    </div>
</template>
