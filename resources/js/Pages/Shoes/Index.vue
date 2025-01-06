<template>
  <AuthenticatedLayout>
    <div class="max-w-6xl mx-auto p-4">
      <h1 class="text-2xl font-semibold text-white mb-4">Available Shoes for Sale</h1>

      <!-- Link to Cart Page -->
      <div class="flex justify-end mb-4">
        <InertiaLink :href="route('cart.index')" class="text-white px-4 py-2 rounded-md">
          <CartView class="w-6 h-6 mr-2" />
        </InertiaLink>
      </div>

      <!-- Loop through the shoes and display them in a 3x3 grid -->
      <div class="grid grid-cols-3 gap-4">
        <div v-for="shoe in shoes.data" :key="shoe.id" class="bg-gray-600 rounded-lg p-4 shadow-md">
          <img :src="getImagePath(shoe.image_path)" alt="Shoe Image" class="w-full h-50 object-cover rounded-t-md" />
          <div class="text-center mt-2">
            <h2 class="text-lg text-white font-semibold">{{ shoe.name }}</h2>
            <p class="text-sm text-white">Brand: {{ shoe.brand }}</p>
            <p class="text-sm text-white">Size: {{ shoe.size }}</p>
            <p class="text-sm text-white">Price: ₱{{ shoe.price }}</p>
            <button @click="addToCart(shoe.id)" class="mt-2 text-white px-4 py-2 rounded-md flex items-center justify-center">
              <CartLogo class="w-6 h-6 mr-2" />
            </button>
          </div>
        </div>
      </div>

      <!-- Pagination Controls -->
      <div class="mt-4 flex justify-center">
        <button 
          v-if="shoes.prev_page_url" 
          @click="loadPage(shoes.prev_page_url)" 
          class="bg-indigo-500 text-white px-4 py-2 rounded-md"
        >
          Previous
        </button>
        <button 
          v-if="shoes.next_page_url" 
          @click="loadPage(shoes.next_page_url)" 
          class="bg-indigo-500 text-white px-4 py-2 rounded-md ml-2"
        >
          Next
        </button>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Link as InertiaLink } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CartView from '@/Components/CartView.vue'; 
import CartLogo from '@/Components/CartLogo.vue'; 

// Receive the shoes data from the server (via Inertia)
const props = defineProps({
  shoes: Object,
});

const shoes = ref(props.shoes);

// Function to generate the correct image path
const getImagePath = (imagePath) => {
  return `/storage/${imagePath}`;
};

// Load a specific page of shoes when pagination buttons are clicked
const loadPage = (url) => {
  Inertia.get(url, {}, { preserveState: true });
};

// Function to add a shoe to the cart
const addToCart = (shoeId) => {
  Inertia.post(route('cart.store'), { shoe_id: shoeId, quantity: 1 });
};
</script>