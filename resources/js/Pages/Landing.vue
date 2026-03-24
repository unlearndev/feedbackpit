<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import AppButton from '@/Components/AppButton.vue';
import StatusBadge from '@/Components/StatusBadge.vue';

const statuses = ['under_review', 'planned', 'in_progress', 'completed'];
const activeIndex = ref(0);
let interval;

onMounted(() => {
    interval = setInterval(() => {
        activeIndex.value = (activeIndex.value + 1) % statuses.length;
    }, 1500);
});

onUnmounted(() => {
    clearInterval(interval);
});
</script>

<template>
    <AppLayout>
        <section class="blueprint-center-line py-16 sm:py-24 text-center">
            <h1 class="text-4xl sm:text-5xl font-semibold tracking-tight text-neutral-900">
                Collect feedback.<br>Ship what matters.
            </h1>
            <p class="mt-4 text-lg text-neutral-500 max-w-lg mx-auto">
                A transparent suggestion board where your users submit ideas, vote on priorities, and watch progress unfold.
            </p>
            <div class="mt-8 flex items-center justify-center gap-3">
                <AppButton href="/dashboard">View Dashboard</AppButton>
                <AppButton href="https://unlearn.dev" variant="outline">Visit unlearn.dev</AppButton>
            </div>
        </section>

        <div class="blueprint-rule -mx-4 sm:-mx-6 lg:-mx-8">
            <span class="absolute -top-1 -left-1 block h-2 w-2 bg-neutral-200" />
            <span class="absolute -top-1 -right-1 block h-2 w-2 bg-neutral-200" />
        </div>

        <section class="py-16 text-center">
            <h2 class="text-2xl font-semibold tracking-tight text-neutral-900">Built for learning</h2>
            <p class="mt-3 text-sm text-neutral-500 max-w-md mx-auto">
                FeedbackPit is a <a href="/about" class="text-neutral-900 underline hover:text-neutral-600 transition-colors duration-150">demo</a> suggestion tracking application and the live project powering all workflows across
                <a href="https://unlearn.dev" class="text-neutral-900 underline hover:text-neutral-600 transition-colors duration-150">Unlearn</a>.
            </p>
        </section>

        <div class="blueprint-rule -mx-4 sm:-mx-6 lg:-mx-8">
            <span class="absolute -top-1 -left-1 block h-2 w-2 bg-neutral-200" />
            <span class="absolute -top-1 -right-1 block h-2 w-2 bg-neutral-200" />
        </div>

        <section class="relative py-10">
            <span class="hidden md:block absolute top-0 bottom-0 left-1/3 border-l border-dashed border-black/[0.06]" />
            <span class="hidden md:block absolute top-0 bottom-0 left-2/3 border-l border-dashed border-black/[0.06]" />
            <p class="text-xs uppercase tracking-wider text-neutral-400 mb-6 text-center">How it works</p>
            <div class="grid grid-cols-1 md:grid-cols-3">
                <div class="px-6 py-4 text-center">
                    <span class="text-xs uppercase tracking-wider text-neutral-400">01</span>
                    <h3 class="mt-2 text-lg font-semibold tracking-tight text-neutral-900">Submit</h3>
                    <p class="mt-1 text-sm text-neutral-500">Users share ideas and feature requests in seconds.</p>
                </div>
                <div class="px-6 py-4 text-center">
                    <span class="text-xs uppercase tracking-wider text-neutral-400">02</span>
                    <h3 class="mt-2 text-lg font-semibold tracking-tight text-neutral-900">Vote</h3>
                    <p class="mt-1 text-sm text-neutral-500">The community upvotes what matters most to them.</p>
                </div>
                <div class="px-6 py-4 text-center">
                    <span class="text-xs uppercase tracking-wider text-neutral-400">03</span>
                    <h3 class="mt-2 text-lg font-semibold tracking-tight text-neutral-900">Ship</h3>
                    <p class="mt-1 text-sm text-neutral-500">You build with confidence, guided by real demand.</p>
                </div>
            </div>
        </section>

        <div class="blueprint-rule -mx-4 sm:-mx-6 lg:-mx-8">
            <span class="absolute -top-1 -left-1 block h-2 w-2 bg-neutral-200" />
            <span class="absolute -top-1 -right-1 block h-2 w-2 bg-neutral-200" />
        </div>

        <section class="py-16 text-center">
            <h2 class="text-2xl font-semibold tracking-tight text-neutral-900">Open & transparent</h2>
            <p class="mt-3 text-sm text-neutral-500 max-w-md mx-auto">
                Every vote is public. Every status update is visible. Your users always know where things stand.
            </p>
            <div class="mt-6 flex items-center justify-center flex-wrap gap-2">
                <StatusBadge
                    v-for="(status, index) in statuses"
                    :key="status"
                    :status="status"
                    class="transition-all duration-500"
                    :class="activeIndex === index ? 'opacity-100 scale-110' : 'opacity-30 scale-100'"
                />
            </div>
        </section>
    </AppLayout>
</template>
