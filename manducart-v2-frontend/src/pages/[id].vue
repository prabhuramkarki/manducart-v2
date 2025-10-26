<template>
<section>
  <NavBar/>
    <div class="min-h-screen bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
      <nav class="text-sm font-medium text-gray-500">
        <a href="#" class="hover:text-gray-700">Home</a>
        <span class="mx-2">/</span>
        <a href="#" class="hover:text-gray-700">Collection</a>
        <span class="mx-2">/</span>
        <span class="text-gray-900">The Minimalist Tote</span>
      </nav>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 lg:pb-24">
      <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 lg:items-start">
        
        <div class="flex flex-col-reverse">
          
          <div class="w-full mt-4">
            <img 
              v-if="mainImage"
              :src="mainImage" 
              :alt="product.product_name" 
              class="w-full object-cover aspect-square rounded-lg shadow-md"
            />
            <div v-else class="w-full aspect-square bg-gray-200 rounded-lg flex items-center justify-center">
              <p class="text-gray-400">No image available</p>
            </div>
          </div>
        </div>

        <div class="mt-10 lg:mt-0 lg:sticky lg:top-8">
          <div v-if="loading" class="text-center py-10">
            <p class="text-gray-500">Loading product details...</p>
          </div>
          
          <div v-else-if="error" class="text-center py-10">
            <p class="text-red-500">{{ error }}</p>
          </div>
          
          <div v-else>
          <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">{{ product.product_name }}</h1>
          <p class="mt-4 text-3xl text-gray-900 font-light">Rs. {{ product.product_price }}</p>

          <div class="mt-3 flex items-center">
            <div class="flex items-center text-yellow-500">
              <i class="fas fa-star text-sm"></i>
              <i class="fas fa-star text-sm"></i>
              <i class="fas fa-star text-sm"></i>
              <i class="fas fa-star text-sm"></i>
              <i class="fas fa-star-half-alt text-sm"></i>
            </div>
            <p class="ml-2 text-sm text-gray-500">Rating: {{ product.rating }}/5</p>
          </div>

          <div class="mt-6">
            <h3 class="text-lg font-medium text-gray-900">Details</h3>
            <p class="text-base text-gray-500 mt-2">{{ product.product_details }}</p>
          </div>
          
          <div class="mt-4 space-y-2">
            <p class="text-sm text-gray-700"><span class="font-semibold">Category:</span> {{ product.category.product_category }}</p>
            <p class="text-sm text-gray-700"><span class="font-semibold">Color:</span> {{ product.category.product_color }}</p>
            <p class="text-sm text-gray-700"><span class="font-semibold">Size:</span> {{ product.category.product_size }}</p>
            <p class="text-sm text-gray-700"><span class="font-semibold">Stock:</span> {{ product.product_quantity }} available</p>
          </div>
          
          <form class="mt-6">
            
            <div class="mt-8">
              <h3 class="text-sm font-medium text-gray-900">Quantity</h3>
              <div class="mt-4 flex items-center space-x-3">
                <button 
                  type="button"
                  @click="quantity = Math.max(1, quantity - 1)"
                  class="px-3 py-2 border border-gray-300 rounded-md hover:bg-gray-50"
                >
                  <i class="fas fa-minus text-sm"></i>
                </button>
                <input 
                  v-model.number="quantity" 
                  type="number" 
                  min="1" 
                  :max="product.product_quantity"
                  class="w-20 text-center border border-gray-300 rounded-md py-2"
                />
                <button 
                  type="button"
                  @click="quantity = Math.min(product.product_quantity, quantity + 1)"
                  class="px-3 py-2 border border-gray-300 rounded-md hover:bg-gray-50"
                >
                  <i class="fas fa-plus text-sm"></i>
                </button>
              </div>
            </div>

            <button 
              type="submit" 
              class="mt-10 w-full bg-yellow-500 border border-transparent rounded-md py-4 px-8 flex items-center justify-center text-lg font-bold text-white uppercase tracking-wider hover:bg-yellow-600 transition duration-300 shadow-lg focus:outline-none focus:ring-4 focus:ring-yellow-500 focus:ring-opacity-50"
              @click.prevent="addToCart"
            >
              Add to Cart
            </button>
          </form>

          <div class="mt-10 border-t border-gray-200 pt-8 space-y-4">
            <details class="group">
              <summary class="flex justify-between items-center text-lg font-medium cursor-pointer text-gray-900 hover:text-yellow-600">
                Shipping & Returns
                <i class="fas fa-chevron-down text-sm group-open:rotate-180 transition-transform"></i>
              </summary>
              <div class="mt-2 text-sm text-gray-500 pr-4">
                Free standard shipping on all orders over $75. 30-day no-questions-asked return policy.
              </div>
            </details>
            <details class="group">
              <summary class="flex justify-between items-center text-lg font-medium cursor-pointer text-gray-900 hover:text-yellow-600">
                Materials & Care
                <i class="fas fa-chevron-down text-sm group-open:rotate-180 transition-transform"></i>
              </summary>
              <div class="mt-2 text-sm text-gray-500 pr-4">
                100% full-grain Italian leather. Spot clean with a damp cloth. Do not machine wash.
              </div>
            </details>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';
import NavBar from '../components/layouts/NavBar.vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import { useCart } from '../composables/useCart';

const { addToCart: addToCartGlobal } = useCart();

const route = useRoute();
const loading = ref(true);
const error = ref(null);

// --- Product Data ---
const product = reactive({
  product_id: null,
  product_name: '',
  product_price: 0,
  product_details: '',
  product_image: '',
  product_quantity: 0,
  rating: 0,
  category: {
    product_category: '',
    product_color: '',
    product_size: ''
  }
});

// --- State Management ---
const selectedSize = ref('Medium');
const mainImage = ref('');
const quantity = ref(1);

// Fetch product data from API
const fetchProduct = async () => {
  try {
    loading.value = true;
    const response = await axios.get(`http://127.0.0.1:8000/api/products/${route.params.id}`);
    const data = response.data.data;
    
    // Update product reactive object
    Object.assign(product, data);
    mainImage.value = `http://127.0.0.1:8000/${data.product_image}`;
    loading.value = false;
  } catch (err) {
    console.error('Error fetching product:', err);
    error.value = 'Failed to load product details';
    loading.value = false;
    toast.error('Failed to load product details');
  }
};

onMounted(() => {
  fetchProduct();
});

// --- Methods ---
const addToCart = async () => {
  try {
    await addToCartGlobal(product.product_id, quantity.value);
    toast.success(`${product.product_name} added to cart!`);
    // Reset quantity after adding
    quantity.value = 1;
  } catch (error) {
    console.error('Error adding to cart:', error);
    toast.error('Failed to add to cart');
  }
};
</script>

<style>
/* You'll need to link Font Awesome for the star/icon ratings */
/* For example, by linking it in your main index.html file: */
/* <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" /> */
</style>