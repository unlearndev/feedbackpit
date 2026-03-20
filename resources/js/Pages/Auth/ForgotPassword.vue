<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppInput from '@/Components/AppInput.vue';
import AppButton from '@/Components/AppButton.vue';

const form = useForm({
    email: '',
});

const submit = () => {
    form.post('/forgot-password');
};
</script>

<template>
    <AppLayout>
        <div class="max-w-md mx-auto">
            <h1 class="text-2xl font-semibold tracking-tight text-neutral-900 mb-8">Reset your password</h1>

            <form class="rounded-none border border-black/[0.06] bg-white p-6 space-y-5" @submit.prevent="submit">
                <AppInput
                    id="email"
                    v-model="form.email"
                    label="Email address"
                    type="email"
                    autocomplete="email"
                    required
                    :error="form.errors.email"
                />

                <AppButton type="submit" :disabled="form.processing" class="w-full">
                    Send reset link
                </AppButton>
            </form>

            <p class="mt-6 text-sm text-neutral-600 text-center">
                Remember your password?
                <a href="/login" class="font-medium text-neutral-900 hover:underline transition-colors duration-150">Sign in</a>
            </p>
        </div>
    </AppLayout>
</template>
