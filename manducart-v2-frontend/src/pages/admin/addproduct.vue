<template>
  <div>
    <NavBar />
    <div class="min-h-screen bg-gray-100 py-10 px-5">
      <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-center mb-8">Add Product</h1>

        <form @submit.prevent="handleSubmit" class="space-y-8">
          <!-- Two Column Grid -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left Side -->
            <div class="space-y-4">
              <div>
                <label class="block font-semibold mb-1">Product Name</label>
                <input v-model="product.product_name" type="text"
                  class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300" required />
              </div>

              <div>
                <label class="block font-semibold mb-1">Product Category</label>
                <select v-model="product.product_category"
                  class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300" required>
                  <option value="">Select Category</option>
                  <option>Mens</option>
                  <option>Womens</option>
                  <option>Unisex</option>
                </select>
              </div>

              <div>
                <label class="block font-semibold mb-1">Product Details</label>
                <textarea v-model="product.product_details" rows="4"
                  class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300"></textarea>
              </div>

              <div>
                <label class="block font-semibold mb-1">Available Colors</label>
                <select v-model="product.product_color"
                  class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300">
                  <option>Black</option>
                  <option>White</option>
                  <option>Blue</option>
                  <option>Green</option>
                  <option>Orange</option>
                  <option>Purple</option>
                  <option>Brown</option>
                </select>
              </div>

              <div>
                <label class="block font-semibold mb-1">Select Size</label>
                <select v-model="product.product_size"
                  class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300">
                  <option>XS</option>
                  <option>S</option>
                  <option>M</option>
                  <option>L</option>
                  <option>X</option>
                  <option>XL</option>
                  <option>XXL</option>
                  <option>XXXL</option>
                </select>
              </div>
            </div>

            <!-- Right Side -->
            <div class="space-y-4">
              <div>
                <label class="block font-semibold mb-1">Price</label>
                <input v-model.number="product.product_price" type="number"
                  class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300" required />
              </div>

              <div>
                <label class="block font-semibold mb-1">Quantity</label>
                <input v-model.number="product.product_quantity" type="number" min="1"
                  class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300" required />
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="flex justify-center">
            <button type="submit"
              class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 transition">
              Add Product
            </button>
          </div>
        </form>

        <p v-if="message" class="text-center mt-5 text-green-600 font-medium">{{ message }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue"
import NavBar from "../../components/layouts/NavBar.vue"

// Product data
const product = ref({
  product_name: "",
  product_category: "",
  product_details: "",
  product_color: "",
  product_size: "",
  product_price: "",
  product_quantity: 1,
})

const message = ref("")

// Validate before submit
function validateForm() {
  const p = product.value
  if (
    !p.product_name ||
    !p.product_category ||
    !p.product_details ||
    !p.product_color ||
    !p.product_size ||
    p.product_price === "" ||
    p.product_price == null ||
    p.product_quantity == null
  ) {
    console.log("Please fill in all required fields.")
    return false
  }
  return true
}

// Submit form
async function handleSubmit() {
  if (!validateForm()) return

  const formData = new FormData()
  for (const [key, value] of Object.entries(product.value)) {
    formData.append(key, value == null ? "" : String(value))
  }

  try {
    const response = await fetch("http://127.0.0.1:8000/api/products", {
      method: "POST",
      body: formData,
    })

    if (!response.ok) {
      const bodyText = await response.text().catch(() => "")
      throw new Error(`Upload failed: ${response.status} ${bodyText}`)
    }

    message.value = "Product added successfully!"
    resetForm()
  } catch (err) {
    console.error("Error adding product:", err)
    message.value = "Error adding product. See console for details."
  }
}

// Reset the form
function resetForm() {
  product.value = {
    product_name: "",
    product_category: "",
    product_details: "",
    product_color: "",
    product_size: "",
    product_price: "",
    product_quantity: 1,
  }
}
</script>