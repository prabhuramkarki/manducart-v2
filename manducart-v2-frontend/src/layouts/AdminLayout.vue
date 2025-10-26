<template>
  <div class="flex h-screen bg-gray-100 font-montserrat">
    <!-- Sidebar -->
    <transition name="slide">
      <div v-if="isSidebarOpen" class="w-64 bg-white shadow-lg text-black flex-shrink-0">
        <div class="p-6">
          <div class="flex items-center space-x-2 select-none">
            <RouterLink to="/admin" class="flex items-center space-x-1">
              <img src="../assets/svgs/manducart-admin-logo.svg" alt="Manducart Logo" class="h-auto object-contain" />
            </RouterLink>
          </div>
        </div>
        <nav>
          <ul>
            <li>
              <RouterLink to="/admin" class="flex items-center px-6 py-3 hover:text-red-500 transition-colors duration-300" :class="{ 'text-red-500 font-semibold': isActive('/admin') }">
                <i class="fa-solid fa-house w-6"></i>
                <span class="font-medium">Dashboard</span>
              </RouterLink>
            </li>
            <li>
              <RouterLink to="/admin/products" class="flex items-center px-6 py-3 hover:text-red-500 transition-colors duration-300" :class="{ 'text-red-500 font-semibold': isActive('/admin/products') }">
                <i class="fa-solid fa-box w-6"></i>
                <span class="font-medium">Products</span>
              </RouterLink>
            </li>
            <li>
              <RouterLink to="/admin/addproduct" class="flex items-center px-6 py-3 hover:text-red-500 transition-colors duration-300" :class="{ 'text-red-500 font-semibold': isActive('/admin/addproduct') }">
                <i class="fa-solid fa-plus w-6"></i>
                <span class="font-medium">Add Product</span>
              </RouterLink>
            </li>
          </ul>
        </nav>
      </div>
    </transition>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col">
      <!-- Header -->
      <header class="bg-white shadow-md p-4 flex justify-between items-center">
        <!-- Left side: Hamburger Menu -->
        <button @click="toggleSidebar" class="text-black hover:text-red-500 transition-colors duration-300 cursor-pointer">
          <i class="fa-solid fa-bars text-xl"></i>
        </button>

        <!-- Right side: Icons -->
        <div class="flex items-center space-x-4 cursor-pointer">
          <button @click="toggleFullscreen" class="text-black hover:text-red-500 transition-colors duration-300 cursor-pointer">
            <i :class="isFullscreen ? 'fa-solid fa-compress text-xl' : 'fa-solid fa-expand text-xl'"></i>
          </button>
          <button @click="toggleNotification" class="text-black hover:text-red-500 transition-colors duration-300 cursor-pointer">
            <i :class="isNotificationOpen ? 'fa-solid fa-bell-slash text-xl' : 'fa-solid fa-bell text-xl'"></i>
          </button>
          <button @click="toggleProfile" class="text-black hover:text-red-500 transition-colors duration-300 cursor-pointer">
            <i :class="isProfileOpen ? 'fa-solid fa-user-minus text-xl' : 'fa-solid fa-user text-xl'"></i>
          </button>
        </div>
      </header>

      <!-- Page Content -->
      <div class="flex-1 p-6 lg:p-10 overflow-y-auto">
        <router-view />
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRoute } from 'vue-router';

const isSidebarOpen = ref(true);
const isFullscreen = ref(false);
const isNotificationOpen = ref(false);
const isProfileOpen = ref(false);

const route = useRoute();
const isActive = (path) => route.path === path;

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};

const toggleFullscreen = () => {
  if (!document.fullscreenElement) {
    document.documentElement.requestFullscreen();
    isFullscreen.value = true;
  } else {
    if (document.exitFullscreen) {
      document.exitFullscreen();
      isFullscreen.value = false;
    }
  }
};

const toggleNotification = () => {
  isNotificationOpen.value = !isNotificationOpen.value;
};

const toggleProfile = () => {
  isProfileOpen.value = !isProfileOpen.value;
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');

.font-montserrat {
  font-family: 'Montserrat', sans-serif;
}

/* Slide animation for the sidebar */
.slide-enter-active,
.slide-leave-active {
  transition: transform 0.3s ease;
}

.slide-enter-from,
.slide-leave-to {
  transform: translateX(-100%);
}
</style>
