<script setup>
import { useForm } from '@inertiajs/vue3';
import AppTextarea from '@/Components/AppTextarea.vue';
import AppButton from '@/Components/AppButton.vue';

const props = defineProps({
    action: {
        type: String,
        required: true,
    },
});

const form = useForm({
    body: '',
});

const submit = () => {
    form.post(props.action, {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <form @submit.prevent="submit">
        <AppTextarea
            id="comment-body"
            v-model="form.body"
            label="Comment"
            :error="form.errors.body"
            :rows="3"
        />
        <div class="mt-2">
            <AppButton type="submit" size="sm" :disabled="form.processing">
                Post Comment
            </AppButton>
        </div>
    </form>
</template>
