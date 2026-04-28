<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { show } from '@/routes/feedback';

defineProps({
    idea: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <AppLayout>
        <div class="max-w-md mx-auto rounded-none border border-black/[0.06] bg-white p-6 text-center">
            <h1 class="text-2xl font-semibold tracking-tight text-neutral-900 mb-4">You've been unsubscribed</h1>

            <p class="text-neutral-700 mb-6">
                We won't send you any more updates about <span class="font-medium">{{ idea.title }}</span>.
                Notifications for your other ideas are unaffected.
            </p>

            <a
                :href="show.url(idea.id)"
                class="inline-flex items-center gap-1 text-xs uppercase tracking-wider text-neutral-400 hover:text-neutral-900 transition-colors"
            >
                View the idea
            </a>
        </div>
    </AppLayout>
</template>
