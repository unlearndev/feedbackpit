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
    <div class="min-h-screen bg-gray-50">
        <!-- Navbar -->
        <nav class="fixed top-0 inset-x-0 z-50 bg-white border-b border-gray-200">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Left: Logo -->
                    <div class="flex-shrink-0">
                        <a href="/" class="text-xl font-bold text-neutral-900">
                            {{ appName }}
                        </a>
                    </div>

                    <!-- Right: Auth + CTA + User (hidden on mobile) -->
                    <div class="hidden md:flex items-center space-x-4">
                        <a
                            :href="user ? '/ideas/create' : '/login'"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-neutral-900 rounded-lg hover:bg-neutral-800 transition-colors"
                        >
                            New Idea
                        </a>

                        <template v-if="user">
                            <div class="relative">
                                <button type="button" class="flex items-center" @click="dropdownOpen = !dropdownOpen">
                                    <img
                                        :src="`https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=171717&color=fff&size=32`"
                                        :alt="`${user.name} avatar`"
                                        class="h-8 w-8 rounded-full"
                                    >
                                </button>

                                <!-- Click-outside overlay -->
                                <div v-if="dropdownOpen" class="fixed inset-0 z-10" @click="dropdownOpen = false" />

                                <!-- Dropdown menu -->
                                <div v-if="dropdownOpen" class="absolute right-0 mt-2 w-48 rounded-lg bg-white border border-gray-200 shadow-lg py-1 z-20">
                                    <a
                                        href="/account/settings"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    >
                                        Account
                                    </a>
                                    <button
                                        type="button"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        @click="logout"
                                    >
                                        Log out
                                    </button>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <a href="/login" class="text-sm font-medium text-gray-700 hover:text-neutral-900 transition-colors">
                                Login
                            </a>
                            <a
                                href="/register"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-neutral-900 border border-neutral-900 rounded-lg hover:bg-neutral-50 transition-colors"
                            >
                                Register
                            </a>
                        </template>
                    </div>

                    <!-- Mobile: Hamburger (+ Avatar when logged in) -->
                    <div class="flex items-center space-x-3 md:hidden">
                        <img
                            v-if="user"
                            :src="`https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=171717&color=fff&size=32`"
                            :alt="`${user.name} avatar`"
                            class="h-8 w-8 rounded-full"
                        >

                        <button
                            type="button"
                            class="p-2 text-gray-500 hover:text-gray-700"
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

            <!-- Mobile menu panel -->
            <div v-if="mobileMenuOpen" class="md:hidden border-t border-gray-200 bg-white">
                <div class="space-y-1 px-4 py-3">
                    <template v-if="user">
                        <a href="/account/settings" class="block rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                            Account
                        </a>
                        <button
                            type="button"
                            class="w-full text-left rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
                            @click="logout"
                        >
                            Log out
                        </button>
                    </template>
                    <template v-else>
                        <a href="/login" class="block rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                            Login
                        </a>
                        <a href="/register" class="block rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                            Register
                        </a>
                    </template>
                    <a :href="user ? '/ideas/create' : '/login'" class="block rounded-lg px-3 py-2 text-sm font-medium text-white bg-neutral-900 hover:bg-neutral-800">
                        New Idea
                    </a>
                </div>
            </div>
        </nav>

        <FlashMessage />

        <!-- Content area -->
        <main class="pt-24 pb-12">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <slot />
            </div>
        </main>
    </div>
</template>
