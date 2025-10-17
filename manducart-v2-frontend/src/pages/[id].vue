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
              :src="mainImage" 
              alt="The Minimalist Tote in selected color" 
              class="w-full object-cover aspect-square rounded-lg shadow-md"
            />
          </div>

          <div class="mt-6 w-full">
            <div class="flex space-x-3 overflow-x-auto">
              <img 
                v-for="(image, index) in product.images" 
                :key="index"
                :src="image.src" 
                :alt="image.alt"
                @click="mainImage = image.src"
                :class="[
                  'w-20 h-20 object-cover rounded-md cursor-pointer ring-2 transition duration-200',
                  mainImage === image.src ? 'ring-yellow-500 ring-offset-2' : 'ring-transparent hover:ring-gray-300'
                ]"
              />
            </div>
          </div>
        </div>

        <div class="mt-10 lg:mt-0 lg:sticky lg:top-8">
          
          <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">{{ product.name }}</h1>
          <p class="mt-4 text-3xl text-gray-900 font-light">${{ product.price.toFixed(2) }}</p>

          <div class="mt-3 flex items-center">
            <div class="flex items-center text-yellow-500">
              <i class="fas fa-star text-sm"></i>
              <i class="fas fa-star text-sm"></i>
              <i class="fas fa-star text-sm"></i>
              <i class="fas fa-star text-sm"></i>
              <i class="fas fa-star-half-alt text-sm"></i>
            </div>
            <p class="ml-2 text-sm text-gray-500">{{ product.rating.count }} reviews</p>
          </div>

          <div class="mt-6">
            <h3 class="text-lg font-medium text-gray-900">Details</h3>
            <p class="text-base text-gray-500 mt-2">{{ product.description }}</p>
          </div>
          
          <form class="mt-6">
            
            <div>
              <h3 class="text-sm font-medium text-gray-900">Color: <span class="font-semibold">{{ selectedColor.name }}</span></h3>
              <div class="mt-4 flex items-center space-x-3">
                <button 
                  v-for="color in product.colors" 
                  :key="color.name" 
                  type="button" 
                  @click="selectColor(color)"
                  :class="[
                    color.class,
                    'p-1 rounded-full ring-2 transition duration-200',
                    selectedColor.name === color.name ? 'ring-offset-2 ring-yellow-500' : 'ring-transparent hover:ring-gray-300'
                  ]"
                >
                  <span :class="['w-8 h-8 rounded-full block', color.class]"></span>
                </button>
              </div>
            </div>

            <div class="mt-8">
              <h3 class="text-sm font-medium text-gray-900">Size</h3>
              <div class="mt-4 flex items-center space-x-3">
                <button 
                  v-for="size in product.sizes" 
                  :key="size" 
                  type="button" 
                  @click="selectedSize = size"
                  :class="[
                    'px-4 py-2 border rounded-md text-sm font-medium transition duration-200',
                    selectedSize === size ? 'bg-gray-900 text-white border-gray-900' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'
                  ]"
                >
                  {{ size }}
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
</section>
</template>

<script setup>
import { ref, reactive } from 'vue';
import NavBar from '../components/layouts/NavBar.vue'

// --- Product Data Simulation ---
const product = reactive({
  id: 1,
  name: 'The Minimalist Tote',
  price: 299.00,
  description: "Crafted for simplicity and function, this is the only bag you'll ever need. Features a padded laptop sleeve, interior zip pocket, and magnetic snap closure. Made with ethically sourced Italian leather.",
  rating: { value: 4.5, count: 156 },
  sizes: ['Small', 'Medium', 'Large'],
  colors: [
    { name: 'Black', src: 'https://via.placeholder.com/600x600/1f2937/FFFFFF?text=Black+Tote', class: 'bg-gray-900' },
    { name: 'Tan', src: 'https://via.placeholder.com/600x600/b49877/FFFFFF?text=Tan+Tote', class: 'bg-amber-700' },
    { name: 'Clay', src: 'https://via.placeholder.com/600x600/9ca3af/FFFFFF?text=Clay+Tote', class: 'bg-gray-400' },
  ],
  images: [
    { src: 'https://via.placeholder.com/600x600/1f2937/FFFFFF?text=Black+Tote', alt: 'Black Tote Front' },
    { src: 'https://via.placeholder.com/600x600/b49877/FFFFFF?text=Tan+Tote', alt: 'Tan Tote Side' },
    { src: 'https://via.placeholder.com/600x600/9ca3af/FFFFFF?text=Clay+Tote', alt: 'Clay Tote Detail' },
    { src: 'https://via.placeholder.com/600x600/374151/FFFFFF?text=Interior+View', alt: 'Tote Interior' },
  ]
});

// --- State Management ---
const selectedColor = ref(product.colors[0]);
const selectedSize = ref(product.sizes[1]);
const mainImage = ref(product.images[0].src);

// --- Methods ---
const selectColor = (color) => {
  selectedColor.value = color;
  // Update the main image to reflect the selected color
  const newImage = product.images.find(img => img.alt.includes(color.name)) || color.src;
  mainImage.value = newImage.src || color.src;
};

const addToCart = () => {
  console.log('Adding to cart:', {
    product: product.name,
    color: selectedColor.value.name,
    size: selectedSize.value,
    qty: 1
  });
  alert(`${selectedColor.value.name} ${product.name} (${selectedSize.value}) added to cart!`);
};
</script>

<style>
/* You'll need to link Font Awesome for the star/icon ratings */
/* For example, by linking it in your main index.html file: */
/* <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" /> */
</style>