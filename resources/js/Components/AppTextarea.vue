<script setup>
defineProps({
    modelValue: {
        type: String,
        default: '',
    },
    label: {
        type: String,
        required: true,
    },
    id: {
        type: String,
        required: true,
    },
    error: {
        type: String,
        default: null,
    },
    rows: {
        type: [Number, String],
        default: 5,
    },
    required: {
        type: Boolean,
        default: false,
    },
});

defineEmits(['update:modelValue']);
</script>

<template>
    <div>
        <label :for="id" class="block text-xs font-medium uppercase tracking-wider text-neutral-500 mb-1">{{ label }}</label>
        <textarea
            :id="id"
            :value="modelValue"
            :rows="rows"
            :required="required"
            class="w-full rounded-none border border-black/[0.06] px-3 py-2 text-sm text-neutral-900 placeholder-neutral-400 transition-colors duration-150 focus:outline-none focus:border-neutral-900"
            :class="{ 'border-red-500': error }"
            @input="$emit('update:modelValue', $event.target.value)"
        />
        <p v-if="error" class="mt-1 text-sm text-red-600">{{ error }}</p>
    </div>
</template>
