<template>
  <!-- Navbar -->
  <nav
    class="w-full bg-gray-200/70 py-[30px] px-[5%] md:px-[10%] flex justify-between items-center h-[91px] z-30 font-montserrat relative"
  >
    <!-- Logo -->
    <div class="flex items-center space-x-2 select-none">
      <RouterLink to="/" class="flex items-center space-x-1">
        <img
          src="../../assets/svgs/manducart-logo.svg"
          alt="Manducart Logo"
          class="h-auto object-contain"
        />
      </RouterLink>
    </div>

    <!-- Desktop Nav Links -->
    <ul
      class="hidden lg:flex space-x-8 ml-[50px] font-medium text-[16px]"
    >
      <li v-for="link in navLinks" :key="link.path">
        <RouterLink
          :to="link.path"
          class="hover:text-red-500 transition-all duration-300 ease-in-out"
          :class="{ 'text-red-500 font-semibold': isActive(link.path) }"
        >
          {{ link.label }}
        </RouterLink>
      </li>
    </ul>

    <!-- Hamburger / Close Button (Visible on mobile + tablet) -->
    <button
      @click="toggleMenu"
      class="lg:hidden text-black hover:text-red-500 transition-colors duration-300"
      aria-label="Toggle menu"
    >
      <i
        :class="
          isMenuOpen
            ? 'fa-solid fa-xmark text-2xl'
            : 'fa-solid fa-bars text-xl'
        "
      ></i>
    </button>

    <!-- Sliding Mobile & Tablet Menu -->
    <transition name="slide">
      <div
        v-if="isMenuOpen"
        class="fixed top-[91px] right-0 w-[75%] h-[calc(100vh-91px)] bg-gray-200 shadow-lg z-40 flex flex-col px-6 py-10 space-y-6"
      >
        <!-- Navigation Links -->
        <ul class="flex flex-col space-y-6">
          <li v-for="link in navLinks" :key="link.path">
            <RouterLink
              :to="link.path"
              @click="closeMenu"
              class="hover:text-red-500 transition-all duration-300 ease-in-out text-lg font-medium"
              :class="{ 'text-red-500 font-semibold': isActive(link.path) }"
            >
              {{ link.label }}
            </RouterLink>
          </li>
        </ul>

        <!-- Login Button -->
        <RouterLink
          to="/login"
          @click="closeMenu"
          class="mt-8 text-center bg-red-500 text-white py-3 rounded-xl hover:bg-red-600 transition-all duration-300"
        >
          Login
        </RouterLink>
      </div>
    </transition>

    <!-- Desktop Icons (Only on large screens) -->
    <div class="hidden lg:flex items-center space-x-4">
      <RouterLink to="/search">
        <i
          class="fa-solid fa-magnifying-glass text-black hover:text-red-500 cursor-pointer transition-colors duration-300"
        ></i>
      </RouterLink>

      <RouterLink to="/wishlist">
        <i
          class="fa-solid fa-heart text-black hover:text-red-500 cursor-pointer transition-colors duration-300"
        ></i>
      </RouterLink>

      <RouterLink to="/cart" class="relative">
        <i
          class="fa-solid fa-cart-shopping text-black cursor-pointer transition-transform duration-500 hover:scale-125"
        ></i>
        <span
          class="absolute -top-2 -right-3 bg-red-500 text-white text-[10px] w-[18px] h-[18px] rounded-full flex items-center justify-center"
        >
          {{ cartCount }}
        </span>
      </RouterLink>

      <RouterLink to="/login">
        <i
          class="fa-solid fa-user text-black hover:text-red-500 cursor-pointer transition-colors duration-300"
        ></i>
      </RouterLink>
    </div>

    <!-- Mobile & Tablet Bottom Icons -->
    <div
      class="lg:hidden fixed bottom-0 left-0 w-full bg-gray-200 py-4 px-[10%] flex justify-around items-center z-50 shadow-lg border-t border-gray-300"
    >
      <RouterLink to="/search" @click="closeMenu">
        <i
          class="fa-solid fa-magnifying-glass text-black hover:text-red-500 cursor-pointer transition-colors duration-300 text-xl"
        ></i>
      </RouterLink>

      <RouterLink to="/wishlist" @click="closeMenu">
        <i
          class="fa-solid fa-heart text-black hover:text-red-500 cursor-pointer transition-colors duration-300 text-xl"
        ></i>
      </RouterLink>

      <RouterLink to="/cart" class="relative" @click="closeMenu">
        <i
          class="fa-solid fa-cart-shopping text-black cursor-pointer transition-transform duration-300 hover:scale-125 text-xl"
        ></i>
        <span
          class="absolute -top-2 -right-3 bg-red-500 text-white text-[10px] w-[18px] h-[18px] rounded-full flex items-center justify-center"
        >
          {{ cartCount }}
        </span>
      </RouterLink>

      <RouterLink to="/login" @click="closeMenu">
        <i
          class="fa-solid fa-user text-black hover:text-red-500 cursor-pointer transition-colors duration-300 text-xl"
        ></i>
      </RouterLink>
    </div>
  </nav>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const isMenuOpen = ref(false)
const cartCount = ref(2)

const navLinks = ref([
  { label: 'Home', path: '/' },
  { label: "Men's", path: '/mens' },
  { label: "Women's", path: '/womens' },
  { label: 'Shop', path: '/shop' },
  { label: 'Contact', path: '/contact' },
])

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value
  document.body.style.overflow = isMenuOpen.value ? 'hidden' : ''
}

const closeMenu = () => {
  isMenuOpen.value = false
  document.body.style.overflow = ''
}

const isActive = (path) => route.path === path

watch(() => route.path, () => {
  closeMenu()
})
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');

.font-montserrat {
  font-family: 'Montserrat', sans-serif;
}

/* Slide animation for right-side menu */
.slide-enter-active,
.slide-leave-active {
  transition: transform 0.3s ease;
}
.slide-enter-from {
  transform: translateX(100%);
}
.slide-leave-to {
  transform: translateX(100%);
}
</style>
