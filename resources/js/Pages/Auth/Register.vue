<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppInput from '@/Components/AppInput.vue';
import AppButton from '@/Components/AppButton.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post('/register', {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <AppLayout>
        <div class="max-w-md mx-auto">
            <h1 class="text-2xl font-semibold tracking-tight text-neutral-900 mb-8 text-center">Create an account</h1>

            <form class="rounded-none border border-black/[0.06] bg-white p-6 space-y-5" @submit.prevent="submit">
                <AppInput
                    id="name"
                    v-model="form.name"
                    label="Name"
                    autocomplete="name"
                    required
                    :error="form.errors.name"
                />

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
                    autocomplete="new-password"
                    required
                    :error="form.errors.password"
                />

                <AppInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    label="Confirm password"
                    type="password"
                    autocomplete="new-password"
                    required
                    :error="form.errors.password_confirmation"
                />

                <AppButton type="submit" :disabled="form.processing" class="w-full">
                    Create account
                </AppButton>
            </form>

            <p class="mt-6 text-sm text-neutral-600">
                Already have an account?
                <a href="/login" class="font-medium text-neutral-900 hover:underline transition-colors duration-150">Log in</a>
            </p>
        </div>
    </AppLayout>
</template>
