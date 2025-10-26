<template>
  <div class="relative bg-white rounded-xl shadow-md hover:shadow-xl transition duration-300 w-full max-w-[280px] overflow-hidden flex flex-col">
    <!-- Wishlist -->
    <button
      @click="handleAddToWishlist"
      class="absolute top-3 right-3 z-10 bg-white p-2 h-10 w-10 flex items-center justify-center rounded-full shadow hover:bg-red-500 hover:text-white transition cursor-pointer"
      :class="{ 'text-red-500': isInWishlist }"
      :title="isInWishlist ? 'Remove from wishlist' : 'Add to wishlist'"
    >
      <i :class="isInWishlist ? 'fas fa-heart' : 'far fa-heart'"></i>
    </button>

    <!-- Product Image -->
    <RouterLink :to="`/product/${product.product_id}`" class="block">
      <div class="overflow-hidden">
        <img
          :src="productImage"
          :alt="product.product_name"
          class="w-full h-64 object-cover transform hover:scale-110 transition duration-700"
          @error="handleImageError"
        />
      </div>
    </RouterLink>

    <!-- Product Details -->
    <div class="p-4 space-y-2 flex flex-col flex-grow">
      <div class="flex justify-between text-xs text-gray-600 uppercase">
        <p>Category: <span class="font-medium">{{ productCategory }}</span></p>
        <p v-if="productSize">Size: <span class="font-medium">{{ productSize }}</span></p>
      </div>

      <h2 class="font-semibold text-gray-800 text-base line-clamp-2 min-h-[3rem]">
        {{ product.product_name }}
      </h2>

      <p class="text-red-600 font-bold text-lg">Rs. {{ formattedPrice }}</p>

      <!-- Buttons -->
      <div class="flex justify-between items-center mt-auto pt-3 gap-2">
        <button
          @click="handleBuyNow"
          class="flex items-center justify-center gap-2 bg-slate-700 hover:bg-slate-800 ease-in-out duration-300 text-white px-3 py-2 rounded-lg text-sm font-medium flex-1 cursor-pointer"
          :disabled="isAddingToCart"
        >
          <i class="fa-solid fa-bag-shopping"></i> Buy Now
        </button>

        <button
          @click="handleAddToCart"
          class="flex items-center justify-center gap-2 bg-red-500 hover:bg-red-600 ease-in-out duration-300 text-white px-3 py-2 rounded-lg text-sm font-medium flex-1 cursor-pointer"
          :disabled="isAddingToCart"
        >
          <i class="fa-solid fa-cart-plus"></i> 
          <span v-if="!isAddingToCart">Add</span>
          <span v-else class="inline-block animate-spin">
            <i class="fas fa-spinner"></i>
          </span>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';
import { useCart } from '../composables/useCart';
import { useWishlist } from '../composables/useWishlist';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const props = defineProps({
  product: {
    type: Object,
    required: true,
    validator: (value) => {
      return (
        'product_id' in value &&
        'product_name' in value &&
        'product_price' in value
      );
    },
  },
  baseImageUrl: {
    type: String,
    default: 'http://127.0.0.1:8000',
  },
});

const emit = defineEmits(['add-to-cart', 'buy-now', 'add-to-wishlist']);

const router = useRouter();
const { addToCart: addToCartGlobal } = useCart();
const { isInWishlist, addToWishlist: addToWishlistGlobal } = useWishlist();

const isAddingToCart = ref(false);
const imageError = ref(false);

// Computed properties
const productCategory = computed(() => {
  return props.product.category?.product_category || 'Uncategorized';
});

const productSize = computed(() => {
  return props.product.category?.product_size || '';
});

const formattedPrice = computed(() => {
  return new Intl.NumberFormat('en-NP').format(props.product.product_price);
});

const productImage = computed(() => {
  if (imageError.value || !props.product.product_image) {
    return 'https://via.placeholder.com/300x300?text=No+Image';
  }
  return props.product.product_image.startsWith('http')
    ? props.product.product_image
    : `${props.baseImageUrl}${props.product.product_image}`;
});

// Methods
const handleImageError = () => {
  imageError.value = true;
};

const handleAddToCart = async () => {
  isAddingToCart.value = true;
  try {
    await addToCartGlobal(props.product.product_id, 1);
    toast.success(`Added ${props.product.product_name} to cart`, { autoClose: 2000 });
    emit('add-to-cart', props.product);
  } catch (error) {
    console.error('Error adding to cart:', error);
    toast.error(error.response?.data?.message || 'Failed to add to cart', { autoClose: 2000 });
  } finally {
    isAddingToCart.value = false;
  }
};

const handleBuyNow = () => {
  emit('buy-now', props.product);
  router.push({ name: 'checkout' });
};

const handleAddToWishlist = async () => {
  try {
    await addToWishlistGlobal(props.product.product_id);
    toast.success(
      isInWishlist(props.product.product_id)
        ? 'Added to wishlist'
        : 'Removed from wishlist',
      { autoClose: 2000 }
    );
    emit('add-to-wishlist', props.product);
  } catch (error) {
    console.error('Error updating wishlist:', error);
    toast.error('Failed to update wishlist', { autoClose: 2000 });
  }
};
</script>