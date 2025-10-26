<template>
  <div class="container mx-auto">
    <h2 class="text-3xl font-bold mb-6">Welcome, Admin!</h2>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <!-- Total Users -->
      <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
        <i class="fa-solid fa-users text-3xl text-blue-500"></i>
        <div class="ml-4">
          <h3 class="text-lg font-semibold">Total Users</h3>
          <p class="text-2xl font-bold">1,234</p>
        </div>
      </div>

      <!-- Total Products -->
      <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
        <i class="fa-solid fa-box-open text-3xl text-green-500"></i>
        <div class="ml-4">
          <h3 class="text-lg font-semibold">Total Products</h3>
          <p class="text-2xl font-bold">567</p>
        </div>
      </div>

      <!-- Total Orders -->
      <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
        <i class="fa-solid fa-shopping-cart text-3xl text-yellow-500"></i>
        <div class="ml-4">
          <h3 class="text-lg font-semibold">Total Orders</h3>
          <p class="text-2xl font-bold">890</p>
        </div>
      </div>

      <!-- Total Revenue -->
      <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
        <i class="fa-solid fa-dollar-sign text-3xl text-red-500"></i>
        <div class="ml-4">
          <h3 class="text-lg font-semibold">Total Revenue</h3>
          <p class="text-2xl font-bold">$12,345</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
// No script needed for this static page for now
</script>

<style scoped>
/* No specific styles needed for this component as they are handled by Tailwind CSS */
</style>