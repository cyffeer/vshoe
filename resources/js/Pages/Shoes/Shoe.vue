<template>
  <AuthenticatedLayout>
    <div class="max-w-4xl mx-auto p-4 ">
      <div class="bg-gray-600 rounded-lg p-4 shadow-md">
        <img :src="getImagePath(shoe.image_path)" alt="Shoe Image" class="w-full h-100 object-cover rounded-t-md" style="height: 500px;" />
        <div class="text-center mt-2">
          <h2 class="text-2xl text-white font-semibold">{{ shoe.name }}</h2>
          <p class="text-lg text-white">Brand: {{ shoe.brand }}</p>
          <p class="text-lg text-white">Size: {{ shoe.size }}</p>
          <p class="text-lg text-white">Quantity: {{ shoe.quantity }}</p>
          <p class="text-lg text-white">Quality: {{ shoe.quality }}</p>
          <p class="text-lg text-white">Views: {{ shoe.view }}</p>
          <p class="text-lg text-white">Price: ₱{{ shoe.price }}</p>
          <button @click="addToCart(shoe.id)" class="mt-4 text-white px-4 py-2 rounded-md flex items-center justify-center">
            <CartLogo class="w-6 h-6 mr-2" /> Add to Cart
          </button>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Link as InertiaLink } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import CartLogo from '@/Components/CartLogo.vue'; 

// Receive the shoe data from the server (via Inertia)
const props = defineProps({
  shoe: Object,
});

const shoe = ref(props.shoe);

// Function to generate the correct image path
const getImagePath = (imagePath) => {
  return `/storage/${imagePath}`;
};

// Function to add a shoe to the cart
const addToCart = (shoeId) => {
  Inertia.post(route('cart.store'), { shoe_id: shoeId, quantity: 1 });
};
</script>