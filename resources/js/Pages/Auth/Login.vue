<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppInput from '@/Components/AppInput.vue';
import AppButton from '@/Components/AppButton.vue';

const form = useForm({
    email: '',
    password: '',
});

const submit = () => {
    form.post('/login', {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AppLayout>
        <div class="max-w-md mx-auto">
            <h1 class="text-2xl font-semibold tracking-tight text-neutral-900 mb-8 text-center">Log in to your account</h1>

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

                <AppInput
                    id="password"
                    v-model="form.password"
                    label="Password"
                    type="password"
                    autocomplete="current-password"
                    required
                >
                    <template #label-right>
                        <a href="/forgot-password" class="text-xs font-medium text-neutral-900 hover:underline transition-colors duration-150">Forgot your password?</a>
                    </template>
                </AppInput>

                <AppButton type="submit" :disabled="form.processing" class="w-full">
                    Log in
                </AppButton>
            </form>

            <p class="mt-6 text-sm text-neutral-600">
                Don't have an account?
                <a href="/register" class="font-medium text-neutral-900 hover:underline transition-colors duration-150">Create one</a>
            </p>
        </div>
    </AppLayout>
</template>
