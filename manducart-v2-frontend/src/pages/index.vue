<template>
  <div>
    <!-- NavBar -->
    <NavBar />

    <!-- Carousel -->
     <Carousel/>

    <!-- Featured Section -->
    <!-- <section>
      <h1 class="text-xl font-bold text-center my-6">Featured Products</h1>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 px-6">
        <div v-for="item in featured" :key="item.title" class="relative group">
          <h5 class="absolute top-2 left-2 text-white px-3 py-1 rounded bg-gradient-to-r from-blue-600 to-green-400">
            {{ item.title }}
          </h5>
          <img :src="`/images/${item.image}`" class="rounded-lg shadow-lg w-full h-60 object-cover" />

          <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
            <button @click="seeMore(item.link)"
              class="bg-white text-black px-3 py-2 rounded flex items-center gap-2">
              <i class="fa-solid fa-circle-chevron-down"></i> See More
            </button>
          </div>
        </div>
      </div>
    </section> -->

    <!-- Product List -->
    <!-- <section>
      <h1 class="text-xl font-bold text-center my-6">View More Products</h1>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 px-6">
        <div v-for="product in products" :key="product.product_id" class="border rounded-lg overflow-hidden shadow-lg">
          <a :href="`/productdetail/${product.product_id}`">
            <img :src="`/images/${product.product_image}`" class="w-full h-60 object-cover" />
          </a>

          <div class="p-3">
            <div class="flex justify-between">
              <button @click="addWishlist(product.product_id)" class="text-gray-500 hover:text-red-500">
                <i class="fa-regular fa-heart"></i>
              </button>
              <div class="flex gap-2">
                <button @click="buyNow(product.product_id)" class="text-blue-600">
                  <i class="fa-solid fa-bag-shopping"></i>
                </button>
                <button @click="addCart(product.product_id)" class="text-green-600">
                  <i class="fa-solid fa-cart-plus"></i>
                </button>
              </div>
            </div>
            <div class="mt-3">
              <p>CATEGORY: {{ product.category }}</p>
              <p>SIZE: {{ product.size }}</p>
              <h2 class="font-bold">{{ product.product_name }}</h2>
              <h2 class="text-red-500">Rs. {{ product.product_price }}</h2>
            </div>
          </div>
        </div>
      </div>

      <div class="text-center mt-6">
        <button @click="goToShop" class="bg-blue-500 text-white px-4 py-2 rounded">See More</button>
      </div>
    </section> -->

    <!-- Bottom Banner -->
    <section class="text-center my-12 bg-gray-100 py-10">
      <p class="text-lg">New Arrival's <span class="text-red-600 font-bold">50% Off</span></p>
      <h2 class="text-2xl font-semibold">
        Men's & Women's <span class="text-sky-500">Collection</span>
      </h2>
      <a href="/shop">
        <p class="bg-red-600 inline-block mt-4 px-4 py-2 text-white rounded">Order Now</p>
      </a>
    </section>

    <!-- <Footer /> -->
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
// import Footer from '@/components/Footer.vue'
import axios from 'axios'
import NavBar from '../components/layouts/NavBar.vue'
import Carousel from '../components/Carousel.vue'

const products = ref([])
const featured = ref([
  { title: 'MENS', image: 'mens.jpg', link: '/shop?category=mens' },
  { title: 'WOMENS', image: 'womens.jpg', link: '/shop?category=womens' },
  { title: 'UNISEX', image: 'unisex.jpg', link: '/shop?category=unisex' },
  { title: 'NEW ARRIVAL', image: 'newarrival.jpg', link: '/shop?sort=newarrival' }
])

// Fetch all product data
const fetchProducts = async () => {
  const res = await axios.get('/api/products/random?limit=4')
  products.value = res.data
}

// Fetch featured section (mens, womens, unisex, new arrival)
const fetchFeatured = async () => {
  const res = await axios.get('/api/products/featured')
  featured.value = res.data
}

// Add to cart
const addCart = async (id) => {
  try {
    await axios.post('/api/cart', { product_id: id })
    alert('Product added to cart')
  } catch (err) {
    alert('Please login first')
  }
}

// Add to wishlist
const addWishlist = async (id) => {
  try {
    await axios.post('/api/wishlist', { product_id: id })
    alert('Product added to wishlist')
  } catch (err) {
    alert('Please login first')
  }
}

// Buy now
const buyNow = (id) => {
  window.location.href = `/checkout?product_id=${id}&quantity=1`
}

// See more buttons
const seeMore = (link) => {
  window.location.href = link
}

const goToShop = () => {
  window.location.href = '/shop'
}

onMounted(() => {
  fetchProducts()
  fetchFeatured()
})
</script>

<style scoped>
img {
  transition: transform 0.3s ease;
}
img:hover {
  transform: scale(1.05);
}
</style>
