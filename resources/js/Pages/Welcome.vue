<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Welcome" />

    <component :is="$page.props.auth.user ? AuthenticatedLayout : GuestLayout" :can-login="canLogin" :can-register="canRegister">
        <!-- Main Content -->
        <div class="py-12 px-5">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="p-6 text-white">
                    <h1 class="text-3xl font-bold text-center text-white">Welcome to VShoes</h1>

                    <!-- Guest Content -->
                    

                    <!-- Authenticated User Content -->
                    <div v-if="$page.props.auth.user" class="mt-4">
                        <p class="text-lg text-center text-black">Enjoy your personalized experience!</p>
                    </div>
                </div>
            </div>
        </div>
    </component>
</template>