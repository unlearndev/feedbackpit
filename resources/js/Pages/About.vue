<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import AppButton from '@/Components/AppButton.vue';
</script>

<template>
    <AppLayout>
        <div class="max-w-lg mx-auto py-8">
            <h1 class="text-2xl font-semibold tracking-tight text-neutral-900 text-center mb-8">About FeedbackPit</h1>

            <div class="space-y-4 text-sm text-neutral-500">
                <p>
                    FeedbackPit is a <span class="font-semibold text-neutral-900">demo application</span>. It was built as the flagship project for
                    <a href="https://unlearn.dev" class="text-neutral-900 underline hover:text-neutral-600 transition-colors duration-150">Unlearn</a>,
                    a platform by BitterBrains that teaches modern development workflows and trains developers for the AI era.
                </p>

                <p>
                    Everything you see here, the feedback board, voting, user accounts, statuses, was built using modern AI practices that we teach.
                </p>

                <p>
                    While the app is fully functional, it exists primarily as a learning tool. Feel free to explore, submit feedback, and vote, just know that the data here is for demonstration purposes.
                </p>
            </div>

            <div class="mt-8 flex items-center justify-center">
                <AppButton href="https://unlearn.dev" variant="outline">Visit unlearn.dev</AppButton>
            </div>
        </div>
    </AppLayout>
</template>
