<template>
  <div class="min-h-screen bg-gray-50 font-[Montserrat]">
    <NavBar />

    <!-- Page Header -->
    <section>
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-800">Shopping Cart</h1>
        <p class="text-gray-500 mt-2">{{ cartItems.length }} items in your cart</p>
      </div>
    </section>

    <!-- Cart Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div v-if="loading" class="text-center py-16">
        <i class="fa-solid fa-spinner fa-spin text-gray-400 text-6xl mb-4"></i>
        <p class="text-gray-500">Loading cart...</p>
      </div>

      <div v-else-if="cartItems.length === 0" class="text-center py-16">
        <i class="fa-solid fa-cart-shopping text-gray-300 text-6xl mb-4"></i>
        <h2 class="text-2xl font-semibold text-gray-700 mb-2">Your cart is empty</h2>
        <p class="text-gray-500 mb-6">Add some products to get started!</p>
        <RouterLink 
          to="/shop" 
          class="inline-block bg-red-500 hover:bg-gray-600 ease-in-out duration-300 text-white px-8 py-3 rounded-lg font-semibold"
        >
          Continue Shopping
        </RouterLink>
      </div>

      <div v-else>
        <!-- Clear Cart Button -->
        <div class="mb-4 flex justify-end">
          <button
            @click="clearCart"
            class="text-red-500 hover:text-red-700 font-medium transition duration-300"
          >
            <i class="fa-solid fa-trash mr-2"></i>Clear Cart
          </button>
        </div>

        <div class="lg:grid lg:grid-cols-3 lg:gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2 space-y-4">
          <div
            v-for="item in cartItems"
            :key="item.id"
            class="bg-white rounded-lg shadow-md p-4 sm:p-6 flex flex-col sm:flex-row gap-4"
          >
            <!-- Product Image -->
            <div class="flex-shrink-0">
              <img
                :src="`http://127.0.0.1:8000/${item.product?.product_image}`"
                :alt="item.product?.product_name"
                class="w-full sm:w-32 h-32 object-cover rounded-lg"
              />
            </div>

            <!-- Product Details -->
            <div class="flex-1 flex flex-col justify-between">
              <div>
                <div class="flex justify-between items-start">
                  <div>
                    <h3 class="text-lg font-semibold text-gray-800">{{ item.product?.product_name }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ item.product?.category?.product_category }}</p>
                    <div class="flex gap-4 mt-2 text-sm text-gray-600">
                      <span><strong>Color:</strong> {{ item.product?.category?.product_color }}</span>
                      <span><strong>Size:</strong> {{ item.product?.category?.product_size }}</span>
                    </div>
                  </div>
                  <button
                    @click="removeItem(item.id)"
                    class="text-gray-400 hover:text-red-500 transition duration-300"
                  >
                    <i class="fa-solid fa-trash text-lg"></i>
                  </button>
                </div>
              </div>

              <div class="flex justify-between items-center mt-4">
                <!-- Quantity Controls -->
                <div class="flex items-center space-x-3 border border-gray-300 rounded-lg">
                  <button
                    @click="decreaseQuantity(item.id)"
                    class="px-3 py-2 hover:bg-gray-100 transition duration-300"
                  >
                    <i class="fa-solid fa-minus text-sm"></i>
                  </button>
                  <span class="px-4 font-semibold">{{ item.quantity }}</span>
                  <button
                    @click="increaseQuantity(item.id)"
                    class="px-3 py-2 hover:bg-gray-100 transition duration-300"
                  >
                    <i class="fa-solid fa-plus text-sm"></i>
                  </button>
                </div>

                <!-- Price -->
                <div class="text-right">
                  <p class="text-xl font-bold text-red-600">Rs. {{ (item.product?.product_price * item.quantity).toFixed(2) }}</p>
                  <p class="text-sm text-gray-500">Rs. {{ item.product?.product_price }} each</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1 mt-8 lg:mt-0">
          <div class="bg-white rounded-lg shadow-md p-6 sticky top-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Order Summary</h2>

            <div class="space-y-3 mb-6">
              <div class="flex justify-between text-gray-600">
                <span>Subtotal ({{ totalItems }} items)</span>
                <span>Rs. {{ subtotal }}</span>
              </div>
              <div class="flex justify-between text-gray-600">
                <span>Shipping</span>
                <span>Rs. {{ shipping }}</span>
              </div>
              <div class="flex justify-between text-gray-600">
                <span>Tax (13%)</span>
                <span>Rs. {{ tax }}</span>
              </div>
              <div class="border-t border-gray-200 pt-3 mt-3">
                <div class="flex justify-between text-lg font-bold text-gray-800">
                  <span>Total</span>
                  <span class="text-red-600">Rs. {{ total }}</span>
                </div>
              </div>
            </div>

            <!-- Promo Code -->
            <div class="mb-6">
              <label class="block text-sm font-medium text-gray-700 mb-2">Promo Code</label>
              <div class="flex gap-2">
                <input
                  v-model="promoCode"
                  type="text"
                  placeholder="Enter code"
                  class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                />
                <button
                  @click="applyPromo"
                  class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg font-medium transition duration-300"
                >
                  Apply
                </button>
              </div>
            </div>

            <!-- Checkout Button -->
            <button
              @click="checkout"
              class="w-full bg-red-500 hover:bg-gray-600 ease-in-out duration-300 text-white py-4 rounded-lg font-bold text-lg shadow-lg"
            >
              Proceed to Checkout
            </button>

            <RouterLink
              to="/shop"
              class="block text-center mt-4 text-gray-600 hover:text-gray-800 font-medium transition duration-300"
            >
              <i class="fa-solid fa-arrow-left mr-2"></i>Continue Shopping
            </RouterLink>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { RouterLink } from 'vue-router';
import axios from 'axios';
import NavBar from '../components/layouts/NavBar.vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import { useCart } from '../composables/useCart';

const { userId, updateCartQuantity: updateCartQty, removeFromCart: removeFromCartGlobal, clearCart: clearCartGlobal } = useCart();

const cartItems = ref([]);
const loading = ref(true);
const promoCode = ref('');

// Fetch cart items from API
const fetchCartItems = async () => {
  try {
    loading.value = true;
    const response = await axios.get(`http://127.0.0.1:8000/api/cart?user_id=${userId.value}`);
    cartItems.value = response.data.data;
    loading.value = false;
  } catch (error) {
    console.error('Error fetching cart items:', error);
    toast.error('Failed to load cart items');
    loading.value = false;
  }
};

onMounted(() => {
  fetchCartItems();
});

// Computed properties
const totalItems = computed(() => {
  return cartItems.value.reduce((sum, item) => sum + item.quantity, 0);
});

const subtotal = computed(() => {
  return cartItems.value.reduce((sum, item) => {
    const price = parseFloat(item.product?.product_price || 0);
    return sum + (price * item.quantity);
  }, 0);
});

const shipping = computed(() => {
  return subtotal.value > 5000 ? 0 : 150;
});

const tax = computed(() => {
  return Math.round(subtotal.value * 0.13);
});

const total = computed(() => {
  return subtotal.value + shipping.value + tax.value;
});

// Methods
const increaseQuantity = async (id) => {
  const item = cartItems.value.find(item => item.id === id);
  if (item) {
    try {
      await updateCartQty(id, item.quantity + 1);
      item.quantity++;
      toast.success('Quantity updated');
    } catch (error) {
      console.error('Error updating quantity:', error);
      toast.error('Failed to update quantity');
    }
  }
};

const decreaseQuantity = async (id) => {
  const item = cartItems.value.find(item => item.id === id);
  if (item && item.quantity > 1) {
    try {
      await updateCartQty(id, item.quantity - 1);
      item.quantity--;
      toast.success('Quantity updated');
    } catch (error) {
      console.error('Error updating quantity:', error);
      toast.error('Failed to update quantity');
    }
  }
};

const removeItem = async (id) => {
  const item = cartItems.value.find(item => item.id === id);
  if (item) {
    try {
      await removeFromCartGlobal(id);
      const index = cartItems.value.findIndex(item => item.id === id);
      if (index !== -1) {
        cartItems.value.splice(index, 1);
      }
      toast.success('Item removed from cart');
    } catch (error) {
      console.error('Error removing item:', error);
      toast.error('Failed to remove item');
    }
  }
};

const applyPromo = () => {
  if (promoCode.value.trim()) {
    toast.info('Promo code feature coming soon!');
  } else {
    toast.error('Please enter a promo code');
  }
};

const clearCart = async () => {
  if (confirm('Are you sure you want to clear your cart?')) {
    try {
      await clearCartGlobal();
      cartItems.value = [];
      toast.success('Cart cleared successfully');
    } catch (error) {
      console.error('Error clearing cart:', error);
      toast.error('Failed to clear cart');
    }
  }
};

const checkout = () => {
  if (cartItems.value.length === 0) {
    toast.error('Your cart is empty');
    return;
  }
  toast.success('Proceeding to checkout...');
  // Add checkout logic here
};
</script>

<style scoped>
/* Additional custom styles if needed */
</style>