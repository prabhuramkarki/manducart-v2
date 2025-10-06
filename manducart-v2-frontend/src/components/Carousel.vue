<template>
  <div class="cara-wrap">
    <div class="carousel-container">
      <swiper
        :modules="[Navigation, Autoplay]"
        :loop="true"
        :autoplay="{ delay: 3000, disableOnInteraction: false }"
        navigation
        class="carousel"
      >
        <swiper-slide v-for="(image, index) in images" :key="index" class="carousel-item">
          <img :src="image" alt="Product Image" />
        </swiper-slide>
      </swiper>

      <div class="gallrey-text">
        <p>MENS | WOMENS</p>
        <h1>New Arrival</h1>
        <a href="shop.php">
          <p
            style="background-color: red; padding: 10px; width: 108px; color: white; border-radius: 7px; margin: 20px; font-size: 15px;"
          >
            Order Now
          </p>
        </a>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Navigation, Autoplay } from 'swiper/modules'
import 'swiper/css'
import 'swiper/css/navigation'

// Your image paths here
const images = [
  'https://shorthand.com/the-craft/raster-images/assets/5kVrMqC0wp/sh-unsplash_5qt09yibrok-4096x2731.jpeg',
  'https://shorthand.com/the-craft/raster-images/assets/5kVrMqC0wp/sh-unsplash_5qt09yibrok-4096x2731.jpeg',
  'https://shorthand.com/the-craft/raster-images/assets/5kVrMqC0wp/sh-unsplash_5qt09yibrok-4096x2731.jpeg',
  'https://shorthand.com/the-craft/raster-images/assets/5kVrMqC0wp/sh-unsplash_5qt09yibrok-4096x2731.jpeg',
  'https://shorthand.com/the-craft/raster-images/assets/5kVrMqC0wp/sh-unsplash_5qt09yibrok-4096x2731.jpeg'
]
</script>

<style scoped>
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
}

.cara-wrap {
  display: flex;
  justify-content: center;
  align-items: center;
}

.carousel-container {
  position: relative;
  width: 90%;
  margin: 40px auto;
  height: 50vh;
  opacity: 85%;
  overflow: hidden;
}

.carousel-item {
  object-fit: contain;
  min-width: 100%;
  box-sizing: border-box;
}

.carousel-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.gallrey-text {
  position: absolute;
  top: 10%;
  left: 5%;
  color: white;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
}
</style>
