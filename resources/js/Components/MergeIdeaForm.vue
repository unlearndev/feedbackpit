<script setup>
import { useForm } from '@inertiajs/vue3';
import { store as storeMerge } from '@/actions/App/Http/Controllers/Internal/IdeaMergeController';

const props = defineProps({
    idea: {
        type: Object,
        required: true,
    },
    targets: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    target_id: '',
});

const submit = () => {
    form.post(storeMerge.url(props.idea.id));
};
</script>

<template>
    <form @submit.prevent="submit" class="rounded-none border border-black/[0.06] bg-white p-6">
        <h2 class="text-sm font-semibold uppercase tracking-wider text-neutral-400 mb-4">Merge duplicate</h2>

        <select
            v-model="form.target_id"
            class="w-full rounded-none border border-black/[0.06] bg-white px-3 py-2 text-sm text-neutral-900"
        >
            <option value="">Select the idea to keep</option>
            <option v-for="target in targets" :key="target.id" :value="target.id">
                {{ target.title }}
            </option>
        </select>

        <p class="mt-3 text-xs text-neutral-500">
            Comments, reactions and votes move across, and this idea is closed.
        </p>

        <button
            type="submit"
            :disabled="form.processing"
            class="mt-4 w-full rounded-none bg-neutral-900 px-4 py-2 text-sm font-medium text-white hover:bg-neutral-700 transition-colors"
        >
            Merge
        </button>
    </form>
</template>
