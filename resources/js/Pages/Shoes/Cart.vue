<template>
    <AuthenticatedLayout>
      <div class="max-w-6xl mx-auto p-4">
        <h1 class="text-2xl font-semibold text-white mb-4">Your Cart</h1>
  
        <!-- Loop through the cart items and display them in a 3x3 grid -->
        <div class="grid grid-cols-3 gap-4">
          <div v-for="item in cartItems" :key="item.id" class="bg-gray-600 rounded-lg p-4 shadow-md" style="height: 400px;">
            <img :src="getImagePath(item.shoe.image_path)" alt="Shoe Image" class="w-full h-48 object-cover rounded-t-md" />
            <div class="text-center mt-2">
              <h2 class="text-lg text-white font-semibold">{{ item.shoe.name }}</h2>
              <p class="text-sm text-white">Brand: {{ item.shoe.brand }}</p>
              <p class="text-sm text-white">Size: {{ item.shoe.size }}</p>
              <p class="text-sm text-white">Price: ₱{{ item.shoe.price }}</p>
              <p class="text-sm text-white">Quantity: {{ item.quantity }}</p>
              <button @click="removeFromCart(item.id)" class="mt-2 text-red-500 px-4 py-2 rounded-md flex items-center justify-center">
                <RemoveCart class="w-6 h-6 mr-2" />
              </button>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { Inertia } from '@inertiajs/inertia';
  import RemoveCart from '@/Components/RemoveCart.vue';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  
  // Receive the cart items data from the server (via Inertia)
  const props = defineProps({
    cartItems: Array,
  });
  
  const cartItems = ref(props.cartItems);
  
  // Function to generate the correct image path
  const getImagePath = (imagePath) => {
    return `/storage/${imagePath}`;
  };
  
  // Function to remove a shoe from the cart
  const removeFromCart = (cartItemId) => {
    Inertia.delete(route('cart.destroy', cartItemId));
  };
  </script>