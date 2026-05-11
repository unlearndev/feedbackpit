<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppInput from '@/Components/AppInput.vue';
import AppButton from '@/Components/AppButton.vue';

const form = useForm({
    email: '',
});

const submit = () => {
    form.post('/login/code');
};
</script>

<template>
    <AppLayout>
        <div class="max-w-md mx-auto">
            <h1 class="text-2xl font-semibold tracking-tight text-neutral-900 mb-2 text-center">Sign in with a code</h1>
            <p class="text-sm text-neutral-600 mb-8 text-center">We'll email you a 6-digit code to sign in.</p>

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
                    Email me a code
                </AppButton>
            </form>

            <p class="mt-6 text-sm text-neutral-600 text-center">
                Prefer a password?
                <a href="/login" class="font-medium text-neutral-900 hover:underline transition-colors duration-150">Sign in with a password</a>
            </p>
        </div>
    </AppLayout>
</template>
