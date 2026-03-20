<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppInput from '@/Components/AppInput.vue';
import AppButton from '@/Components/AppButton.vue';

const props = defineProps({
    token: {
        type: String,
        default: '',
    },
    email: {
        type: String,
        default: '',
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post('/reset-password', {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <AppLayout>
        <div class="max-w-md mx-auto">
            <h1 class="text-2xl font-semibold tracking-tight text-neutral-900 mb-8">Set a new password</h1>

            <div v-if="form.errors.email" class="mb-6 rounded-none bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                {{ form.errors.email }}
            </div>

            <form class="rounded-none border border-black/[0.06] bg-white p-6 space-y-5" @submit.prevent="submit">
                <AppInput
                    id="password"
                    v-model="form.password"
                    label="New password"
                    type="password"
                    autocomplete="new-password"
                    required
                />

                <AppInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    label="Confirm password"
                    type="password"
                    autocomplete="new-password"
                    required
                />

                <AppButton type="submit" :disabled="form.processing" class="w-full">
                    Reset password
                </AppButton>
            </form>
        </div>
    </AppLayout>
</template>
