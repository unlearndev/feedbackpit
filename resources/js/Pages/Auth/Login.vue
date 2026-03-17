<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

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
            <h1 class="text-2xl font-bold text-neutral-900 mb-8">Log in to your account</h1>

            <div v-if="form.hasErrors" class="mb-6 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                These credentials are incorrect. Please try again.
            </div>

            <form class="space-y-5" @submit.prevent="submit">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        autocomplete="email"
                        required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-neutral-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:border-transparent"
                    >
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <a href="/forgot-password" class="text-sm font-medium text-neutral-900 hover:underline">Forgot your password?</a>
                    </div>
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        autocomplete="current-password"
                        required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-neutral-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:border-transparent"
                    >
                </div>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full inline-flex justify-center items-center px-4 py-2 text-sm font-medium text-white bg-neutral-900 rounded-lg hover:bg-neutral-800 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    Log in
                </button>
            </form>

            <p class="mt-6 text-sm text-gray-600">
                Don't have an account?
                <a href="/register" class="font-medium text-neutral-900 hover:underline">Create one</a>
            </p>
        </div>
    </AppLayout>
</template>
