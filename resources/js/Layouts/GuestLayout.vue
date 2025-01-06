<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';

defineProps({
    canLogin: {
        type: Boolean,
        required: true,
    },
    canRegister: {
        type: Boolean,
        required: true,
    },
});
</script>

<template>
    <div class="flex min-h-screen flex-col bg-gray-50 dark:bg-gray-900">
        <!-- Navigation Bar -->
        <nav class="w-full bg-white shadow-md dark:bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16"> <!-- Ensure items are centered -->
                    <!-- Logo or Home Link -->
                    <div class="flex items-center">
                        <Link href="/" class="flex items-center">
                            <ApplicationLogo class="h-8 w-8 fill-current text-gray-500" />
                            <span class="ml-2 text-lg font-bold text-gray-800 dark:text-gray-200">VShoe</span>
                        </Link>
                    </div>
                    <!-- Authentication Links -->
                    <div class="flex items-center space-x-4">
                        <Link
                            v-if="canLogin"
                            :href="route('login')"
                            class="text-base font-medium text-gray-800 dark:text-gray-200"
                        >
                            Log in
                        </Link>
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="text-base font-medium text-gray-800 dark:text-gray-200"
                        >
                            Register
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex flex-col items-center pt-6 sm:justify-center sm:pt-0">
            <div class="mt-6 w-full overflow-hidden bg-white px-8 py-6 shadow-lg sm:max-w-md sm:rounded-lg dark:bg-gray-800">
                <slot />
            </div>
        </div>
    </div>
</template>
