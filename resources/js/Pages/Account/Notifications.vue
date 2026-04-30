<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import { show } from '@/routes/feedback';
import { destroy } from '@/routes/account/notifications';
import { dashboard } from '@/routes';

defineProps({
    ideas: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({});

const unsubscribe = (ideaId) => {
    form.delete(destroy.url(ideaId), {
        preserveScroll: true,
    });
};
</script>

<template>
    <AppLayout>
        <div class="max-w-md mx-auto">
            <h1 class="text-2xl font-semibold tracking-tight text-neutral-900 mb-2">Notification preferences</h1>
            <p class="text-sm text-neutral-500 mb-8">Manage the ideas you receive email updates about.</p>

            <div class="rounded-none border border-black/[0.06] bg-white">
                <div v-if="ideas.length" class="divide-y divide-black/[0.06]">
                    <div
                        v-for="idea in ideas"
                        :key="idea.id"
                        class="flex items-center justify-between gap-4 p-4"
                    >
                        <div class="min-w-0 flex-1">
                            <a
                                :href="show.url(idea.id)"
                                class="block truncate text-sm font-medium text-neutral-900 hover:underline"
                            >
                                {{ idea.title }}
                            </a>
                            <div class="mt-1.5">
                                <StatusBadge :status="idea.status" />
                            </div>
                        </div>
                        <button
                            type="button"
                            class="flex-shrink-0 text-xs uppercase tracking-wider text-neutral-400 hover:text-neutral-900 transition-colors disabled:opacity-50"
                            :disabled="form.processing"
                            @click="unsubscribe(idea.id)"
                        >
                            Unsubscribe
                        </button>
                    </div>
                </div>
                <div v-else class="p-8 text-center">
                    <p class="text-sm text-neutral-500 mb-4">You're not subscribed to any ideas right now.</p>
                    <a
                        :href="dashboard.url()"
                        class="inline-flex items-center gap-1 text-xs uppercase tracking-wider text-neutral-400 hover:text-neutral-900 transition-colors"
                    >
                        Browse feedback
                    </a>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
