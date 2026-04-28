<script setup>
import { useForm } from '@inertiajs/vue3';
import AppTextarea from '@/Components/AppTextarea.vue';
import AppButton from '@/Components/AppButton.vue';
import { update } from '@/actions/App/Http/Controllers/Internal/IdeaStatusController';

const props = defineProps({
    idea: {
        type: Object,
        required: true,
    },
});

const STATUS_OPTIONS = [
    { value: 'under_review', label: 'Under Review' },
    { value: 'planned', label: 'Planned' },
    { value: 'in_progress', label: 'In Progress' },
    { value: 'completed', label: 'Completed' },
    { value: 'declined', label: 'Declined' },
];

const form = useForm({
    status: props.idea.status,
    message: '',
});

const submit = () => {
    form.patch(update.url(props.idea.id), {
        preserveScroll: true,
        onSuccess: () => form.reset('message'),
    });
};
</script>

<template>
    <form class="space-y-4" @submit.prevent="submit">
        <div>
            <label for="status-update-status" class="block text-xs font-medium uppercase tracking-wider text-neutral-500 mb-1">Status</label>
            <select
                id="status-update-status"
                v-model="form.status"
                class="w-full appearance-none rounded-none border border-black/[0.06] bg-white bg-no-repeat px-3 py-2.5 pr-10 text-sm text-neutral-900 transition-colors duration-150 focus:outline-none focus:border-neutral-900"
                style="background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2212%22 height=%2212%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23737373%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><polyline points=%226 9 12 15 18 9%22/></svg>'); background-position: right 0.75rem center;"
                :class="{ 'border-red-500': form.errors.status }"
            >
                <option v-for="option in STATUS_OPTIONS" :key="option.value" :value="option.value">
                    {{ option.label }}
                </option>
            </select>
            <p v-if="form.errors.status" class="mt-1 text-sm text-red-600">{{ form.errors.status }}</p>
        </div>

        <AppTextarea
            id="status-update-message"
            v-model="form.message"
            label="Message (optional)"
            :error="form.errors.message"
            :rows="3"
        />

        <div>
            <AppButton type="submit" size="sm" :disabled="form.processing">
                Update Status
            </AppButton>
        </div>
    </form>
</template>
