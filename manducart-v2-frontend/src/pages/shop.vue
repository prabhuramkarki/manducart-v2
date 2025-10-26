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
        class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 justify-items-center"
      >
        <ProductCard
          v-for="product in products"
          :key="product.product_id"
          :product="product"
          @add-to-cart="addToCart"
          @buy-now="buyNow"
          @add-to-wishlist="addToWishlist"
        />
      </div>
      <div v-else class="text-center py-10 text-gray-500">
        <div v-if="!isLoading">No products found</div>
        <div v-else>Loading products...</div>
      </div>
    </div>

    <!-- Footer -->
    <!-- <FooterBar /> -->
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import NavBar from "../components/layouts/NavBar.vue";
import ProductCard from "../components/ProductCard.vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import { useCart } from "../composables/useCart";

const { addToCart: addToCartGlobal } = useCart();

// State
const products = ref([]);
const isLoading = ref(true);

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

// Wishlist
const addToWishlist = (product) => {
    toast.success(`Added ${product.product_name} to wishlist`, { autoClose: 2000 });
};

// Add to cart
const addToCart = async (product) => {
    try {
        await addToCartGlobal(product.product_id, 1);
        toast.success(`Added ${product.product_name} to cart`, { autoClose: 2000 });
    } catch (error) {
        console.error('Error adding to cart:', error);
        toast.error('Failed to add to cart', { autoClose: 2000 });
    }
};

// Buy now
const buyNow = (product) => {
    toast.success(`Buying now: ${product.product_name}`, { autoClose: 2000 });
};

// Delete product
const deleteProduct = async (id) => {
    if (confirm("Are you sure you want to delete this product?")) {
        try {
            await axios.delete(`/products/${id}`);
            fetchProducts();
            toast.success("Product deleted successfully", { autoClose: 2000 });
        } catch (error) {
            toast.error("Failed to delete product", { autoClose: 3000 });
        }
    }
};
</script>

<style scoped></style>