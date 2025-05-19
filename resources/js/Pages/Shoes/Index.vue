<template>
  <AuthenticatedLayout>
    <div class="max-w-6xl mx-auto p-4">
      <h1 class="text-2xl font-semibold text-white mb-4">Available Shoes for Sale</h1>

      <!-- Loop through the shoes and display them in a grid -->
      <div class="grid grid-cols-3 gap-4">
        <div v-for="shoe in shoes.data" :key="shoe.id" class="bg-gray-600 rounded-lg p-4 shadow-md" style="height: 400px;">
          <InertiaLink :href="route('shoes.show', shoe.id)">
            <img :src="getImagePath(shoe.image_path)" alt="Shoe Image" class="w-full h-48 object-cover rounded-t-md" />
            <div class="text-center mt-2">
              <h2 class="text-lg text-white font-semibold truncate">{{ shoe.name }}</h2>
              <p class="text-sm text-white">Brand: {{ shoe.brand }}</p>
              <p class="text-sm text-white">Size: {{ shoe.size }}</p>
              <p class="text-sm text-white">Price: ₱{{ shoe.price }}</p>
            </div>
          </InertiaLink>
          <button @click="addToCart(shoe.id)" class="mt-2 text-white px-4 py-2 rounded-md flex items-center justify-center">
            <CartLogo class="w-6 h-6 mr-2" />
          </button>
        </div>
      </div>

      <!-- Pagination Controls -->
      <div class="mt-4 flex justify-center items-center space-x-4">
        <!-- Previous Page Button -->
        <button 
          v-if="shoes.prev_page_url" 
          @click="goToPage(shoes.prev_page_url)" 
          class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600 transition"
        >
          Previous
        </button>

        <!-- Current Page Display -->
        <span class="text-white">
          Page {{ shoes.current_page }} of {{ shoes.last_page }}
        </span>

        <!-- Next Page Button -->
        <button 
          v-if="shoes.next_page_url" 
          @click="goToPage(shoes.next_page_url)" 
          class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600 transition"
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
import { route } from 'ziggy-js';
import { useToast } from 'vue-toastification';
import 'vue-toastification/dist/index.css';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CartLogo from '@/Components/CartLogo.vue';

// Props passed from the controller
const props = defineProps({
  shoes: {
    type: Object,
    default: () => ({ data: [], prev_page_url: null, next_page_url: null, current_page: 1, last_page: 1 }),
  },
});

// Reactive variable for shoes data
const shoes = ref(props.shoes);

const toast = useToast();

// Generate correct image path
const getImagePath = (imagePath) => {
  return `/storage/${imagePath}`;
};

// Standard page navigation
const goToPage = (url) => {
  window.location.href = url; // This replaces Inertia visit
};

// Add to cart method (assumes cart functionality exists)
const addToCart = (shoeId) => {
  Inertia.post(route('cart.store'), { shoe_id: shoeId, quantity: 1 }, {
    onSuccess: () => {
      toast.success('Shoe added to cart successfully!');
    },
    onError: () => {
      toast.error('Failed to add shoe to cart.');
    }
  });
};
</script>



