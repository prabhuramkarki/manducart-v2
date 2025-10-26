<template>
    <div class="p-6">
        <!-- Products Table -->
        <div class="overflow-x-auto border rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium">SN</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Image</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Name</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Category</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Color</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Size</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Details</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Quantity</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Price</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Manage</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="(product, index) in products" :key="product.product_id">
                        <td class="px-4 py-2">{{ index + 1 }}</td>
                        <td class="px-4 py-2">
                            <img 
                                :src="`http://127.0.0.1:8000/${product.product_image}`" 
                                alt="Product Image" 
                                class="w-12 h-12 rounded" 
                            />
                        </td>
                        <td class="px-4 py-2">{{ product.product_name }}</td>
                        <td class="px-4 py-2">{{ product.category.product_category }}</td>
                        <td class="px-4 py-2">{{ product.category.product_color }}</td>
                        <td class="px-4 py-2 uppercase">{{ product.category.product_size }}</td>
                        <td class="px-4 py-2 truncate max-w-xs">{{ product.product_details }}</td>
                        <td class="px-4 py-2">{{ product.product_quantity }}</td>
                        <td class="px-4 py-2">{{ product.product_price }}</td>
                        <td class="px-4 py-2 flex gap-3">
                            <button @click="deleteProduct(product.product_id)" class="text-red-500 hover:text-red-700">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            <button @click="editProduct(product.product_id)" class="text-blue-500 hover:text-blue-700">
                                <i class="fa-solid fa-pen-nib"></i>
                            </button>
                        </td>
                    </tr>
                    <tr v-if="products.length === 0">
                        <td colspan="10" class="text-center py-4">No products found!</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const products = ref([])

// Fetch products from API
const fetchProducts = async () => {
    try {
        const res = await axios.get('http://127.0.0.1:8000/api/products')
        products.value = res.data.data
    } catch (error) {
        console.error('Failed to fetch products:', error)
    }
}

onMounted(() => {
    fetchProducts()
})

// Manage product actions
const deleteProduct = (id) => {
    if (confirm('Are you sure you want to delete this product?')) {
        axios.delete(`/products/${id}`).then(() => {
            fetchProducts()
            alert('Product deleted successfully')
        })
    }
}

const editProduct = (id) => {
    window.location.href = `/editproduct/${id}`
}
</script>

<style>
.truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
