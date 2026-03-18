<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    idea: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <AppLayout>
        <h1>{{ idea.title }}</h1>
    </AppLayout>
</template>
