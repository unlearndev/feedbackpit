<script setup>
import { ref, computed } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';

const appName = usePage().props.appName;
const mobileMenuOpen = ref(false);
const dropdownOpen = ref(false);

const user = computed(() => usePage().props.auth?.user ?? null);

const logout = () => {
    router.post('/logout');
};
</script>

<template>
    <div class="min-h-screen bg-white">
        <nav class="fixed top-0 inset-x-0 z-50 bg-white/80 backdrop-blur-md border-b border-black/[0.06]">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center gap-3">
                        <a href="/internal" class="text-xl font-semibold tracking-tight text-neutral-900">
                            {{ appName }}
                        </a>
                        <span class="inline-flex items-center rounded border border-neutral-200 bg-neutral-50 px-2.5 py-0.5 text-[11px] font-medium uppercase tracking-wider text-neutral-600">
                            Internal
                        </span>
                    </div>

                    <div class="hidden md:flex items-center space-x-4">
                        <a href="/internal" class="text-xs font-medium text-neutral-700 hover:text-neutral-900 transition-colors">
                            Ideas
                        </a>
                        <a href="/dashboard" class="text-xs font-medium text-neutral-700 hover:text-neutral-900 transition-colors">
                            Public Dashboard
                        </a>

                        <div v-if="user" class="relative">
                            <button type="button" class="flex items-center p-1" @click="dropdownOpen = !dropdownOpen">
                                <img
                                    :src="user.avatar_url"
                                    :alt="`${user.name} avatar`"
                                    class="h-7 w-7 rounded-full"
                                >
                            </button>

                            <div v-if="dropdownOpen" class="fixed inset-0 z-10" @click="dropdownOpen = false" />

                            <Transition
                                enter-active-class="transition ease-out duration-200"
                                enter-from-class="opacity-0 scale-95"
                                enter-to-class="opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="opacity-100 scale-100"
                                leave-to-class="opacity-0 scale-95"
                            >
                                <div v-if="dropdownOpen" class="absolute right-0 mt-2 w-48 origin-top-right rounded-md bg-white border border-neutral-200 shadow-md py-1 z-20">
                                    <a
                                        href="/account/settings"
                                        class="block w-full text-left px-4 py-2 text-xs text-neutral-700 hover:bg-neutral-100 transition-colors duration-150"
                                    >
                                        Account
                                    </a>
                                    <button
                                        type="button"
                                        class="block w-full text-left px-4 py-2 text-xs text-neutral-700 hover:bg-neutral-100 transition-colors duration-150"
                                        @click="logout"
                                    >
                                        Log out
                                    </button>
                                </div>
                            </Transition>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 md:hidden">
                        <img
                            v-if="user"
                            :src="user.avatar_url"
                            :alt="`${user.name} avatar`"
                            class="h-7 w-7 rounded-full"
                        >

                        <button
                            type="button"
                            class="p-2 text-neutral-500 hover:text-neutral-700 transition-colors duration-150"
                            @click="mobileMenuOpen = !mobileMenuOpen"
                        >
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                <path v-else stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div v-if="mobileMenuOpen" class="md:hidden border-t border-neutral-200 bg-white/80 backdrop-blur-md">
                <div class="space-y-1 px-4 py-3">
                    <a href="/internal" class="block rounded-md px-3 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-100 transition-colors duration-150">
                        Ideas
                    </a>
                    <a href="/dashboard" class="block rounded-md px-3 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-100 transition-colors duration-150">
                        Public Dashboard
                    </a>
                    <a href="/account/settings" class="block rounded-md px-3 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-100 transition-colors duration-150">
                        Account
                    </a>
                    <button
                        type="button"
                        class="w-full text-left rounded-md px-3 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-100 transition-colors duration-150"
                        @click="logout"
                    >
                        Log out
                    </button>
                </div>
            </div>
        </nav>

        <FlashMessage />

        <main class="pt-24 pb-12">
            <div class="max-w-5xl mx-auto relative blueprint">
                <div class="blueprint-rule">
                    <span class="absolute -top-1 -left-1 block h-2 w-2 bg-neutral-200" />
                    <span class="absolute -top-1 -right-1 block h-2 w-2 bg-neutral-200" />
                </div>
                <div class="px-4 sm:px-6 lg:px-8 py-8">
                    <slot />
                </div>
                <div class="blueprint-rule">
                    <span class="absolute -top-1 -left-1 block h-2 w-2 bg-neutral-200" />
                    <span class="absolute -top-1 -right-1 block h-2 w-2 bg-neutral-200" />
                </div>
            </div>
        </main>

        <footer class="border-t border-black/[0.06]">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex items-center justify-between">
                <a href="https://bitterbrains.com" class="text-xs text-neutral-400 hover:text-neutral-900 transition-colors duration-150">Powered by BitterBrains</a>
                <div class="flex items-center gap-4">
                    <a href="https://github.com/unlearndev/feedbackpit" class="text-xs text-neutral-400 hover:text-neutral-900 transition-colors duration-150">GitHub</a>
                    <a href="https://unlearn.dev" class="text-xs text-neutral-400 hover:text-neutral-900 transition-colors duration-150">unlearn.dev</a>
                </div>
            </div>
        </footer>
    </div>
</template>
