import { ref } from 'vue'
import { useApiStore } from '../store/api'

// Global cart count state
const cartCount = ref(0)
const userId = ref(1) // Replace with actual authenticated user ID

// Fetch cart count from API
const fetchCartCount = async () => {
  try {
    const response = await api.get(`/cart?user_id=${userId.value}`)
    cartCount.value = response.data.count
  } catch (error) {
    console.error('Error fetching cart count:', error)
  }
}

// Add item to cart
const addToCart = async (productId, quantity = 1) => {
  try {
    await api.post('/cart', {
      user_id: userId.value,
      product_id: productId,
      quantity: quantity
    })
    // Immediately update cart count
    await fetchCartCount()
    return true
  } catch (error) {
    console.error('Error adding to cart:', error)
    throw error
  }
}

// Remove item from cart
const removeFromCart = async (cartItemId) => {
  try {
    await api.delete(`/cart/${cartItemId}`)
    // Immediately update cart count
    await fetchCartCount()
    return true
  } catch (error) {
    console.error('Error removing from cart:', error)
    throw error
  }
}

// Update cart item quantity
const updateCartQuantity = async (cartItemId, quantity) => {
  try {
    await api.put(`/cart/${cartItemId}`, {
      quantity: quantity
    })
    // Immediately update cart count
    await fetchCartCount()
    return true
  } catch (error) {
    console.error('Error updating cart quantity:', error)
    throw error
  }
}

// Clear cart
const clearCart = async () => {
  try {
    await api.post('/cart/clear', {
      user_id: userId.value
    })
    cartCount.value = 0
    return true
  } catch (error) {
    console.error('Error clearing cart:', error)
    throw error
  }
}

export function useCart() {
  return {
    cartCount,
    userId,
    fetchCartCount,
    addToCart,
    removeFromCart,
    updateCartQuantity,
    clearCart
  }
}
