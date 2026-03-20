<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { usePage, router } from '@inertiajs/vue3';

const show = ref(false);
const message = ref('');
let timeout = null;
let removeListener = null;

function dismiss() {
    show.value = false;
    clearTimeout(timeout);
}

function checkFlash() {
    clearTimeout(timeout);

    const newMessage = usePage().props.flash?.message;

    if (newMessage) {
        message.value = newMessage;
        show.value = true;
        timeout = setTimeout(() => {
            show.value = false;
        }, 5000);
    }
}

onMounted(() => {
    checkFlash();
    removeListener = router.on('finish', checkFlash);
});

onUnmounted(() => {
    clearTimeout(timeout);
    removeListener?.();
});
</script>

<template>
    <Transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="translate-y-4 opacity-0"
        enter-to-class="translate-y-0 opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="translate-y-0 opacity-100"
        leave-to-class="translate-y-4 opacity-0"
    >
        <div
            v-if="show"
            class="fixed bottom-6 left-1/2 z-50 -translate-x-1/2 cursor-pointer rounded-md border border-neutral-700 bg-neutral-900 px-5 py-3 text-sm font-medium text-white shadow-lg"
            @click="dismiss"
        >
            {{ message }}
        </div>
    </Transition>
</template>
