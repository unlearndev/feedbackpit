<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const form = useForm({
    email: usePage().props.auth.user.email,
});

const submit = () => {
    form.put('/account/settings');
};

const passwordForm = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const submitPassword = () => {
    passwordForm.put('/account/password', {
        onFinish: () => passwordForm.reset(),
    });
};
</script>

<template>
    <AppLayout>
        <div class="max-w-md mx-auto">
            <h1 class="text-2xl font-bold text-neutral-900 mb-8">Account settings</h1>

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
                    <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
                </div>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full inline-flex justify-center items-center px-4 py-2 text-sm font-medium text-white bg-neutral-900 rounded-lg hover:bg-neutral-800 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    Save changes
                </button>
            </form>

            <hr class="my-10 border-gray-200">

            <h2 class="text-lg font-semibold text-neutral-900 mb-5">Change password</h2>

            <form class="space-y-5" @submit.prevent="submitPassword">
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current password</label>
                    <input
                        id="current_password"
                        v-model="passwordForm.current_password"
                        type="password"
                        autocomplete="current-password"
                        required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-neutral-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:border-transparent"
                    >
                    <p v-if="passwordForm.errors.current_password" class="mt-1 text-sm text-red-600">{{ passwordForm.errors.current_password }}</p>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New password</label>
                    <input
                        id="password"
                        v-model="passwordForm.password"
                        type="password"
                        autocomplete="new-password"
                        required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-neutral-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:border-transparent"
                    >
                    <p v-if="passwordForm.errors.password" class="mt-1 text-sm text-red-600">{{ passwordForm.errors.password }}</p>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm new password</label>
                    <input
                        id="password_confirmation"
                        v-model="passwordForm.password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-neutral-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-neutral-900 focus:border-transparent"
                    >
                </div>

                <button
                    type="submit"
                    :disabled="passwordForm.processing"
                    class="w-full inline-flex justify-center items-center px-4 py-2 text-sm font-medium text-white bg-neutral-900 rounded-lg hover:bg-neutral-800 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    Update password
                </button>
            </form>
        </div>
    </AppLayout>
</template>
