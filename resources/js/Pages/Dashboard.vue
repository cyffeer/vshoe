<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-white">
                Dashboard
            </h2>
        </template>

        <div class="py-5">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-gray-600 shadow-sm sm:rounded-lg">
                    <div class="p-6 text-white">
                        Welcome to VShoes, {{ $page.props.auth.user.name }}!
                    </div>
                </div>
            </div>
        </div>

        <div class="py-5">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-gray-600 shadow-sm sm:rounded-lg">
                    <div class="p-6 text-white">
                        <h3 class="text-lg font-semibold">Top 3 Most Viewed Shoes</h3>
                        <div class="grid grid-cols-3 gap-4">
                            <div v-for="shoe in topShoes" :key="shoe.id" class="bg-gray-600 rounded-lg p-4 shadow-md" style="height: 400px;">
                                <InertiaLink :href="route('shoes.show', shoe.id)">
                                    <img :src="getImagePath(shoe.image_path)" alt="Shoe Image" class="w-full h-48 object-cover rounded-t-md" />
                                    <div class="text-center mt-2">
                                        <h2 class="text-lg text-white font-semibold truncate">{{ shoe.name }}</h2>
                                        <p class="text-sm text-white">Brand: {{ shoe.brand }}</p>
                                        <p class="text-sm text-white">Size: {{ shoe.size }}</p>
                                        <p class="text-sm text-white">Price: ₱{{ shoe.price }}</p>
                                    </div>
                                </InertiaLink>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-5">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-gray-600 shadow-sm sm:rounded-lg">
                    <div class="p-6 text-white">
                        <h3 class="text-lg font-semibold">3 Most Recent Shoes</h3>
                        <div class="grid grid-cols-3 gap-4">
                            <div v-for="shoe in latestShoes" :key="shoe.id" class="bg-gray-600 rounded-lg p-4 shadow-md" style="height: 400px;">
                                <InertiaLink :href="route('shoes.show', shoe.id)">
                                    <img :src="getImagePath(shoe.image_path)" alt="Shoe Image" class="w-full h-48 object-cover rounded-t-md" />
                                    <div class="text-center mt-2">
                                        <h2 class="text-lg text-white font-semibold truncate">{{ shoe.name }}</h2>
                                        <p class="text-sm text-white">Brand: {{ shoe.brand }}</p>
                                        <p class="text-sm text-white">Size: {{ shoe.size }}</p>
                                        <p class="text-sm text-white">Price: ₱{{ shoe.price }}</p>
                                    </div>
                                </InertiaLink>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { Link as InertiaLink } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

const topShoes = ref([]);
const latestShoes = ref([]);

onMounted(async () => {
    const topShoesResponse = await axios.get('/api/top-shoes');
    topShoes.value = topShoesResponse.data;

    const latestShoesResponse = await axios.get('/api/latest-shoes');
    latestShoes.value = latestShoesResponse.data;
});

const getImagePath = (imagePath) => {
    return `/storage/${imagePath}`;
};
</script>