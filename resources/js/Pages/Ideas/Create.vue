<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppInput from '@/Components/AppInput.vue';
import AppTextarea from '@/Components/AppTextarea.vue';
import AppButton from '@/Components/AppButton.vue';

const form = useForm({
    title: '',
    description: '',
});

const submit = () => {
    form.post('/ideas');
};
</script>

<template>
    <AppLayout>
        <div class="max-w-md mx-auto">
            <h1 class="text-2xl font-semibold tracking-tight text-neutral-900 mb-8">Submit New Feedback</h1>

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
                    Submit Feedback
                </AppButton>
            </form>
        </div>
    </AppLayout>
</template>
