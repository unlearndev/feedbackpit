<script setup>
import { computed } from 'vue';

const props = defineProps({
    variant: {
        type: String,
        default: 'primary',
        validator: (v) => ['primary', 'secondary', 'outline'].includes(v),
    },
    size: {
        type: String,
        default: 'md',
        validator: (v) => ['md', 'sm'].includes(v),
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    href: {
        type: String,
        default: null,
    },
    type: {
        type: String,
        default: 'submit',
    },
});

const classes = computed(() => {
    const base = 'inline-flex items-center justify-center font-medium tracking-tight rounded-md transition-colors duration-150 disabled:opacity-50 disabled:cursor-not-allowed';

    const sizes = {
        md: 'px-4 py-2 text-sm',
        sm: 'px-3 py-1.5 text-xs',
    };

    const variants = {
        primary: 'bg-neutral-900 text-white border border-neutral-900 hover:bg-neutral-800',
        outline: 'border border-neutral-300 text-neutral-900 hover:border-neutral-900',
        secondary: 'bg-neutral-100 text-neutral-900 border border-neutral-200 hover:bg-neutral-200',
    };

    return [base, sizes[props.size], variants[props.variant]].join(' ');
});
</script>

<template>
    <a v-if="href" :href="href" :class="classes">
        <slot />
    </a>
    <button v-else :type="type" :disabled="disabled" :class="classes">
        <slot />
    </button>
</template>
