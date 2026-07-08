<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppInput from '@/Components/AppInput.vue';
import AppTextarea from '@/Components/AppTextarea.vue';
import AppButton from '@/Components/AppButton.vue';
import { show, update } from '@/routes/feedback';

const props = defineProps({
    idea: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    title: props.idea.title,
    description: props.idea.description,
});

const submit = () => {
    form.put(update.url(props.idea.id));
};
</script>

<template>
    <AppLayout>
        <div class="max-w-md mx-auto">
            <a :href="show.url(idea.id)" class="inline-flex items-center gap-1 text-xs uppercase tracking-wider text-neutral-400 hover:text-neutral-900 transition-colors mb-6">
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                Back to feedback
            </a>

            <h1 class="text-2xl font-semibold tracking-tight text-neutral-900 mb-8 text-center">Edit Feedback</h1>

            <form class="rounded-none border border-black/[0.06] bg-white p-6 space-y-5" @submit.prevent="submit">
                <AppInput
                    id="title"
                    v-model="form.title"
                    label="Title"
                    :error="form.errors.title"
                />

                <AppTextarea
                    id="description"
                    v-model="form.description"
                    label="Description"
                    :rows="5"
                    :error="form.errors.description"
                />

                <AppButton type="submit" :disabled="form.processing" class="w-full">
                    Save Changes
                </AppButton>
            </form>
        </div>
    </AppLayout>
</template>
