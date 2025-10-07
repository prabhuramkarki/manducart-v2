<template>
  <div class="min-h-screen bg-gray-50 font-[Montserrat]">
    <!-- Navbar -->
    <NavBar />

    <!-- Page Header -->
    <section class="text-center py-10">
      <h1 class="text-3xl font-bold text-gray-800 tracking-wide">Shop Products</h1>
      <p class="text-gray-500 mt-2">Browse our latest collection</p>
    </section>

    <!-- Product Grid -->
    <div class="container mx-auto px-4 pb-10">
      <div
        v-if="products.length"
        class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 justify-items-center"
      >
        <div
          v-for="product in products"
          :key="product.product_id"
          class="relative bg-white rounded-xl shadow-md hover:shadow-xl transition duration-300 w-full max-w-[280px] overflow-hidden flex flex-col"
        >
          <!-- Wishlist -->
          <button
            @click="addToWishlist(product)"
            class="absolute top-3 right-3 z-10 bg-white p-2 h-auto w-auto rounded-full shadow hover:bg-red-500 hover:text-white transition"
          >
            <i class="fa-regular fa-heart text-gray-700"></i>
          </button>

          <!-- Product Image -->
          <a :href="`/productdetail/${product.product_id}`" class="block">
            <div class="overflow-hidden">
              <img
                :src="`../../images/${product.product_image}`"
                alt="Product image"
                class="w-full h-64 object-cover transform hover:scale-110 transition duration-700"
              />
            </div>
          </a>

          <!-- Product Details -->
          <div class="p-4 space-y-2 flex flex-col flex-grow">
            <div class="flex justify-between text-xs text-gray-600 uppercase">
              <p>Category: <span class="font-medium">{{ product.category }}</span></p>
              <p>Size: <span class="font-medium">{{ product.size }}</span></p>
            </div>

            <h2 class="font-semibold text-gray-800 text-base line-clamp-2 min-h-[3rem]">
              {{ product.product_name }}
            </h2>

            <p class="text-red-600 font-bold text-lg">Rs. {{ product.product_price }}</p>

            <!-- Buttons -->
            <div class="flex justify-between items-center mt-auto pt-3 gap-2">
              <button
                @click="buyNow(product)"
                class="flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-lg text-sm font-medium flex-1"
              >
                <i class="fa-solid fa-bag-shopping"></i> Buy Now
              </button>

              <button
                @click="addToCart(product)"
                class="flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg text-sm font-medium flex-1"
              >
                <i class="fa-solid fa-cart-plus"></i> Add
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Loading -->
      <div v-else class="text-center py-10 text-gray-500">Loading products...</div>
    </div>

    <!-- Footer -->
    <!-- <FooterBar /> -->
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import NavBar from "../components/layouts/NavBar.vue";

// State
const products = ref([]);

// Fetch data from API
const fetchProducts = async () => {
  try {
    const res = await axios.get("http://127.0.0.1:8000/api/products");
    products.value = res.data.data;
  } catch (err) {
    console.error("Error fetching products:", err);
  }
};

onMounted(fetchProducts);

// Button actions
const addToWishlist = (product) => alert(`Added ${product.product_name} to wishlist`);
const addToCart = (product) => alert(`Added ${product.product_name} to cart`);
const buyNow = (product) => alert(`Buying now: ${product.product_name}`);
</script>

<style scoped></style>