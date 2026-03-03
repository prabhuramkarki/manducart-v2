<template>
  <div>
    <NavBar />
    <div class="min-h-screen bg-gray-50 font-[Montserrat]">
      <HeroSection />
      
      <!-- Featured Products -->
      <section class="container mx-auto px-4 py-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Featured Products</h2>
        <div v-if="products.length" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 justify-items-center">
          <ProductCard
            v-for="product in products"
            :key="product.product_id"
            :product="product"
            @add-to-cart="addToCart"
            @buy-now="handleBuyNow"
            @add-to-wishlist="handleAddToWishlist"
            class="w-full"
          />
        </div>
        <div v-else class="text-center py-10 text-gray-500">
          {{ isLoading ? 'Loading products...' : 'No featured products available' }}
        </div>
      </section>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from 'vue-router';
import axios from "axios";
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import NavBar from "../components/layouts/NavBar.vue";
import ProductCard from "../components/ProductCard.vue";
import HeroSection from "../components/HeroSection.vue";
import api from "@/services/api";
// import { useApiStore } from "../store/api";

// const api = useApiStore().api;
const router = useRouter();

const products = ref([]);
const isLoading = ref(true);
const featured = ref([
  { title: "MENS", image: "mens.jpg", link: "/shop?category=mens" },
  { title: "WOMENS", image: "womens.jpg", link: "/shop?category=womens" },
  { title: "UNISEX", image: "unisex.jpg", link: "/shop?category=unisex" },
  {
    title: "NEW ARRIVAL",
    image: "newarrival.jpg",
    link: "/shop?sort=newarrival",
  },
]);

// Fetch all product data
const fetchProducts = async () => {
  try {
    isLoading.value = true;
    const res = await api.get("/products/random?limit=4");
    products.value = res.data.data || [];
  } catch (error) {
    console.error('Error fetching products:', error);
    toast.error('Failed to load products', { autoClose: 2000 });
  } finally {
    isLoading.value = false;
  }
};

// Fetch featured section (mens, womens, unisex, new arrival)
const fetchFeatured = async () => {
  const res = await axios.get("/api/products/featured");
  featured.value = res.data;
};

// Add to cart
const addToCart = async (product) => {
  try {
    await api.post("/cart", { product_id: product.product_id });
    toast.success(`Added ${product.product_name} to cart`, { autoClose: 2000 });
  } catch (err) {
    console.error('Error adding to cart:', err);
    toast.error(err.response?.data?.message || 'Please login first', { autoClose: 2000 });
  }
};

const handleBuyNow = (product) => {
  router.push({ 
    name: 'checkout',
    query: { 
      product_id: product.product_id,
      quantity: 1 
    }
  });
};

const handleAddToWishlist = async (product) => {
  try {
    await api.post("/wishlist", { product_id: product.product_id });
    toast.success('Wishlist updated', { autoClose: 2000 });
  } catch (err) {
    console.error('Error updating wishlist:', err);
    toast.error(err.response?.data?.message || 'Please login first', { autoClose: 2000 });
  }
};

const seeMore = (link) => {
  router.push(link);
};

const goToShop = () => {
  router.push('/shop');
};

onMounted(() => {
  fetchProducts();
  fetchFeatured();
});
</script>

<style scoped>
img {
  transition: transform 0.3s ease;
}
img:hover {
  transform: scale(1.05);
}
</style>
