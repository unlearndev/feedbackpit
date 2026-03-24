<script setup>
defineProps({
    note: {
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
    <div class="rounded-none border border-amber-200/50 bg-amber-50/50 p-4">
        <div class="flex items-center gap-2 mb-2">
            <img
                :src="note.user.avatar_url"
                :alt="`${note.user.name} avatar`"
                class="h-6 w-6 rounded-full"
            >
            <span class="text-sm font-medium text-neutral-900">{{ note.user.name }}</span>
            <span class="text-xs text-neutral-400">{{ formatDate(note.created_at) }}</span>
        </div>
        <p class="text-sm text-neutral-700 whitespace-pre-line">{{ note.body }}</p>
    </div>
</template>
