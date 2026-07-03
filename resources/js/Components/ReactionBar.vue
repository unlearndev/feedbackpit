<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import ReactionController from '@/actions/App/Http/Controllers/ReactionController';

const props = defineProps({
    ideaId: {
        type: Number,
        required: true,
    },
    reactions: {
        type: Array,
        default: () => [],
    },
});

const isGuest = computed(() => !usePage().props.auth?.user);

const open = ref(false);
const root = ref(null);

const activeReactions = computed(() => props.reactions.filter((reaction) => reaction.count > 0));

const react = (emoji) => {
    if (isGuest.value) return;
    open.value = false;
    router.post(ReactionController.url(props.ideaId), { emoji }, { preserveScroll: true });
};

const onClickOutside = (event) => {
    if (root.value && !root.value.contains(event.target)) {
        open.value = false;
    }
};

const onKeydown = (event) => {
    if (event.key === 'Escape') {
        open.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', onClickOutside);
    document.addEventListener('keydown', onKeydown);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', onClickOutside);
    document.removeEventListener('keydown', onKeydown);
});
</script>

<template>
    <div ref="root" class="flex flex-wrap items-center gap-2">
        <div class="relative">
            <button
                type="button"
                :disabled="isGuest"
                :title="isGuest ? 'Sign in to react' : 'Add a reaction'"
                :aria-expanded="open"
                :class="[
                    'flex h-9 w-9 items-center justify-center rounded-none border transition-all duration-150',
                    open
                        ? 'border-neutral-900 text-neutral-900'
                        : isGuest
                            ? 'border-black/[0.06] text-neutral-300 cursor-not-allowed'
                            : 'border-black/[0.06] text-neutral-400 hover:border-neutral-900 hover:text-neutral-900 cursor-pointer',
                ]"
                @click="open = !open"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
                </svg>
            </button>

            <Transition
                enter-active-class="transition duration-100 ease-out"
                enter-from-class="opacity-0 -translate-y-1"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition duration-75 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="open"
                    class="absolute left-0 top-full z-10 mt-2 flex divide-x divide-black/[0.06] rounded-none border border-black/[0.06] bg-white shadow-lg shadow-black/[0.04]"
                >
                    <button
                        v-for="reaction in reactions"
                        :key="reaction.emoji"
                        type="button"
                        :title="`React with ${reaction.emoji}`"
                        :class="[
                            'flex h-10 w-10 items-center justify-center text-lg leading-none transition-all duration-150 cursor-pointer',
                            reaction.reacted ? 'bg-neutral-100' : 'hover:bg-neutral-50',
                        ]"
                        @click="react(reaction.emoji)"
                    >
                        {{ reaction.emoji }}
                    </button>
                </div>
            </Transition>
        </div>

        <button
            v-for="reaction in activeReactions"
            :key="reaction.emoji"
            type="button"
            :disabled="isGuest"
            :title="isGuest ? 'Sign in to react' : `React with ${reaction.emoji}`"
            :class="[
                'flex h-9 items-center gap-1.5 rounded-none border px-2.5 transition-all duration-150',
                reaction.reacted
                    ? 'border-neutral-900 bg-neutral-50'
                    : 'border-black/[0.06]',
                isGuest ? 'cursor-default' : 'cursor-pointer hover:border-neutral-900',
            ]"
            @click="react(reaction.emoji)"
        >
            <span class="text-sm leading-none">{{ reaction.emoji }}</span>
            <span :class="['text-xs font-semibold tabular-nums', reaction.reacted ? 'text-neutral-900' : 'text-neutral-500']">
                {{ reaction.count }}
            </span>
        </button>
    </div>
</template>
