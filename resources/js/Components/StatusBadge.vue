<script setup>
import { computed } from 'vue';

const props = defineProps({
    status: {
        type: String,
        required: true,
        validator: (v) => ['under_review', 'planned', 'in_progress', 'completed'].includes(v),
    },
});

const labels = {
    under_review: 'Under Review',
    planned: 'Planned',
    in_progress: 'In Progress',
    completed: 'Completed',
};

const colorClasses = {
    under_review: 'border-neutral-200 bg-neutral-50 text-neutral-600',
    planned: 'border-blue-200 bg-blue-50 text-blue-700',
    in_progress: 'border-amber-200 bg-amber-50 text-amber-700',
    completed: 'border-green-200 bg-green-50 text-green-700',
};

const label = computed(() => labels[props.status]);
const colors = computed(() => colorClasses[props.status]);
</script>

<template>
    <span
        :class="[
            'inline-flex items-center rounded border px-2.5 py-0.5 text-[11px] font-medium uppercase tracking-wider',
            colors,
        ]"
    >
        {{ label }}
    </span>
</template>
