<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppInput from '@/Components/AppInput.vue';
import AppButton from '@/Components/AppButton.vue';

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
            <h1 class="text-2xl font-semibold tracking-tight text-neutral-900 mb-8">Account settings</h1>

            <div class="rounded-none border border-black/[0.06] bg-white p-6">
                <form class="space-y-5" @submit.prevent="submit">
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
                        Save changes
                    </AppButton>
                </form>
            </div>

            <div class="mt-8 rounded-none border border-black/[0.06] bg-white p-6">
                <h2 class="text-lg font-semibold tracking-tight text-neutral-900 mb-5">Change password</h2>

                <form class="space-y-5" @submit.prevent="submitPassword">
                    <AppInput
                        id="current_password"
                        v-model="passwordForm.current_password"
                        label="Current password"
                        type="password"
                        autocomplete="current-password"
                        required
                        :error="passwordForm.errors.current_password"
                    />

                    <AppInput
                        id="password"
                        v-model="passwordForm.password"
                        label="New password"
                        type="password"
                        autocomplete="new-password"
                        required
                        :error="passwordForm.errors.password"
                    />

                    <AppInput
                        id="password_confirmation"
                        v-model="passwordForm.password_confirmation"
                        label="Confirm new password"
                        type="password"
                        autocomplete="new-password"
                        required
                    />

                    <AppButton type="submit" :disabled="passwordForm.processing" class="w-full">
                        Update password
                    </AppButton>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
