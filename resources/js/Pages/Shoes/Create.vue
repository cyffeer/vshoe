<template>
    <Head title="Sell" />
    <AuthenticatedLayout>
      <div class="max-w-2xl mx-auto p-4">
        <div class="flex justify-center">
          <h1 class="text-2xl font-semibold mb-4 text-white">Sell a Shoe</h1>
        </div>
        <div v-if="errors.length" class="bg-red-500 text-white p-3 mb-4 rounded">
          <ul>
            <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
          </ul>
        </div>
    
        <form @submit.prevent="submitForm" enctype="multipart/form-data" class="space-y-4">
          <div class="flex justify-center">
            <div class="w-1/2">
              <label for="name" class="block text-sm font-medium text-white">Shoe Name</label>
              <input type="text" v-model="form.name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required />
            </div>
          </div>
    
          <div class="flex justify-center">
            <div class="w-1/2">
              <label for="size" class="block text-sm font-medium text-white">Size</label>
              <input type="number" v-model="form.size" id="size" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required />
            </div>
          </div>
    
          <div class="flex justify-center">
            <div class="w-1/2">
              <label for="quantity" class="block text-sm font-medium text-white">Quantity</label>
              <input type="number" v-model="form.quantity" id="quantity" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required />
            </div>
          </div>
    
          <div class="flex justify-center">
            <div class="w-1/2">
              <label for="quality" class="block text-sm font-medium text-white">Quality</label>
              <select v-model="form.quality" id="quality" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                <option value="used">Used</option>
                <option value="very-near-dead-stock">Very Near Dead Stock</option>
                <option value="deadstock">Deadstock</option>
                <option value="beaters">Beaters</option>
                <option value="brand-new">Brand-New</option>
                <option value="fitted">Fitted</option>
              </select>
            </div>
          </div>
    
          <div class="flex justify-center">
            <div class="w-1/2">
              <label for="price" class="block text-sm font-medium text-white">Price</label>
              <div class="relative mt-1 rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <span class="text-gray-500 sm:text-sm">₱</span>
                </div>
                <input type="number" step="0.01" v-model="form.price" id="price" class="block w-full pl-7 pr-12 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required />
              </div>
            </div>
          </div>
    
          <div class="flex justify-center">
            <div class="w-1/2">
              <label for="brand" class="block text-sm font-medium text-white">Brand</label>
              <input type="text" v-model="form.brand" id="brand" list="brand-suggestions" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required />
              <datalist id="brand-suggestions">
                <option value="Nike"></option>
                <option value="Adidas"></option>
                <option value="Puma"></option>
                <option value="Reebok"></option>
                <option value="New Balance"></option>
                <option value="Converse"></option>
                <option value="Vans"></option>
                <option value="Under Armour"></option>
                <option value="Fila"></option>
                <option value="Jordan Brand"></option>
                <option value="ASICS"></option>
                <option value="Skechers"></option>
                <option value="Timberland"></option>
                <option value="Nike SB"></option>
                <option value="Saucony"></option>
              </datalist>
            </div>
          </div>
    
          <div class="flex justify-center">
            <div class="w-1/2">
              <label for="image" class="block text-sm font-medium text-white">Shoe Image</label>
              <input type="file" @change="handleFileUpload" id="image" class="mt-1 block w-full text-sm text-gray-500 file:py-2 file:px-4 file:border file:border-gray-300 file:rounded-md" required />
            </div>
          </div>
    
          <div class="mt-4 flex justify-center">
            <button type="submit" class="w-1/2 bg-indigo-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-indigo-600 focus:ring-indigo-500 focus:ring-2 focus:ring-offset-2">
              Sell Shoe
            </button>
          </div>
        </form>
      </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const form = ref({
  name: '',
  size: '',
  quantity: '',
  quality: 'used', // Default value for quality
  view: 0, // View count is always 0
  price: '',
  brand: '',
  image: null, // Will hold the file input data
});

const errors = ref([]);

// Handle image file input
const handleFileUpload = (event) => {
  form.value.image = event.target.files[0]; // Update image with selected file
};

// Submit the form
const submitForm = async () => {
  // Reset errors before submitting
  errors.value = [];

  // Create FormData object
  const formData = new FormData();
  formData.append('name', form.value.name);
  formData.append('size', form.value.size);
  formData.append('quantity', form.value.quantity);
  formData.append('quality', form.value.quality);
  formData.append('view', form.value.view); // View count will always be 0
  formData.append('price', form.value.price);
  formData.append('brand', form.value.brand);
  formData.append('image', form.value.image); // Append the image
  formData.append('image_path', 'images'); // Append the image path

  try {
    // Send the form data to the server
    await Inertia.post('/shoes', formData, {
      onSuccess: () => {
        // Reset form after successful submission
        form.value = {
          name: '',
          size: '',
          quantity: '',
          quality: 'used', // Default value for quality
          view: 0, // View count is always 0
          price: '',
          brand: '',
          image: null,
        };
      },
      onError: (error) => {
        if (error && error.errors) {
          errors.value = Object.values(error.errors).flat();
        }
      },
    });
  } catch (error) {
    console.error('Error submitting form:', error);
  }
};
</script>