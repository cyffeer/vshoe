<template>
  <AuthenticatedLayout>
    <div class="max-w-6xl mx-auto p-4 flex flex-col items-center">
      <h1 class="text-2xl font-semibold text-white mb-4 text-center">Search Results</h1>
      <div v-if="shoes.data.length" class="w-full flex justify-center">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 w-full">
          <div
            v-for="shoe in shoes.data"
            :key="shoe.id"
            class="bg-gray-600 rounded-lg p-4 shadow-md flex flex-col items-center"
            style="height: 400px;"
          >
            <Link :href="route('shoes.show', shoe.id)">
              <img
                :src="`/storage/${shoe.image_path}`"
                alt="Shoe"
                class="w-full h-48 object-cover rounded-t-md"
              />
              <div class="text-center mt-2">
                <h2 class="text-lg text-white font-semibold truncate">{{ shoe.name }}</h2>
                <p class="text-sm text-white">Brand: {{ shoe.brand }}</p>
                <p class="text-sm text-white">Price: ₱{{ shoe.price }}</p>
              </div>
            </Link>
          </div>
        </div>
      </div>
      <div v-else class="text-gray-300 mt-8 text-center w-full">No shoes found.</div>

      <div class="mt-10 w-full flex flex-col items-center">
        <h2 class="text-xl font-semibold mb-2 text-white text-center">Recommended Shoes</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 w-full">
          <div
            v-for="rec in recommendations"
            :key="rec.id"
            class="bg-gray-500 rounded-lg p-4 shadow-md flex flex-col items-center"
            style="height: 350px;"
          >
            <Link :href="route('shoes.show', rec.id)">
              <img
                :src="`/storage/${rec.image_path}`"
                alt="Shoe"
                class="w-full h-48 object-cover rounded-t-md"
              />
              <div class="text-center mt-2">
                <h3 class="text-md text-white font-semibold truncate">{{ rec.name }}</h3>
                <p class="text-sm text-white">Brand: {{ rec.brand }}</p>
                <p class="text-sm text-white">Price: ₱{{ rec.price }}</p>
              </div>
            </Link>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
  shoes: Object,
  recommendations: Array,
  query: String,
})
</script>