<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

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
            <h1 class="text-2xl font-bold text-neutral-900 mb-8">Create an account</h1>

            <form class="space-y-5" @submit.prevent="submit">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        autocomplete="name"
                        required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-neutral-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:border-transparent"
                    >
                    <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
                </div>

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
                    <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        autocomplete="new-password"
                        required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-neutral-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:border-transparent"
                    >
                    <p v-if="form.errors.password" class="mt-1 text-sm text-red-600">{{ form.errors.password }}</p>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm password</label>
                    <input
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-neutral-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:border-transparent"
                    >
                    <p v-if="form.errors.password_confirmation" class="mt-1 text-sm text-red-600">{{ form.errors.password_confirmation }}</p>
                </div>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full inline-flex justify-center items-center px-4 py-2 text-sm font-medium text-white bg-neutral-900 rounded-lg hover:bg-neutral-800 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    Create account
                </button>
            </form>

            <p class="mt-6 text-sm text-gray-600">
                Already have an account?
                <a href="/login" class="font-medium text-neutral-900 hover:underline">Log in</a>
            </p>
        </div>
    </AppLayout>
</template>
