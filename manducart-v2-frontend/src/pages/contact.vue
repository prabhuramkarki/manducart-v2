<template>
<section>
  <NavBar/>
  
  <div class="min-h-screen flex flex-col lg:flex-row font-sans bg-gray-50">

    <div class="lg:w-1/2 p-8 md:p-16 lg:p-24 flex flex-col justify-center order-2 lg:order-1">
      
      <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold mb-6 leading-tight">
        <span class="text-gray-800">GOT A</span>
        <br />
        <span class="text-yellow-500">QUESTION?</span>
      </h1>

      <p class="text-gray-600 text-xl md:text-2xl mb-8 max-w-lg">
        We're here to help! Fill out the form below with your details and issue. Our team will get back to you within 24 hours.
      </p>

      <div class="mt-4 text-gray-700 text-lg">
        <p class="font-semibold mb-2">Or Call Us:</p>
        <p class="flex items-center">
          <i class="fas fa-phone-alt text-yellow-500 mr-2"></i>
          +1 (555) 123-4567
        </p>
      </div>
    </div>

    <div class="lg:w-1/2 bg-yellow-500 flex items-center justify-center p-8 md:p-16 order-1 lg:order-2">
      <div class="bg-white rounded-xl shadow-2xl w-full max-w-xl p-8 md:p-10 text-center transform lg:scale-100">
        
        <h2 class="text-3xl font-bold mb-8 text-gray-800">Contact Us</h2>
        
        <form @submit.prevent="handleSubmit">
          
          <div class="mb-5 text-left">
            <label class="block text-gray-700 font-semibold mb-2 text-sm">Full Name</label>
            <div class="relative">
              <i class="fa-solid fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
              <input 
                v-model="form.fullname" 
                type="text" 
                placeholder="Enter Your Name" 
                class="w-full p-3 pl-10 border-2 border-gray-200 rounded-lg text-base focus:border-yellow-500 focus:ring-yellow-500 transition duration-300" 
                required
              />
            </div>
          </div>

          <div class="mb-5 text-left">
            <label class="block text-gray-700 font-semibold mb-2 text-sm">Email</label>
            <div class="relative">
              <i class="fa-solid fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
              <input 
                v-model="form.email" 
                type="email" 
                placeholder="Enter Your Email" 
                class="w-full p-3 pl-10 border-2 border-gray-200 rounded-lg text-base focus:border-yellow-500 focus:ring-yellow-500 transition duration-300" 
                required
              />
            </div>
          </div>

          <div class="mb-5 text-left">
            <label class="block text-gray-700 font-semibold mb-2 text-sm">Choose Your Issue</label>
            <div class="relative">
              <i class="fa-solid fa-question absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
              <select 
                v-model="form.issue" 
                class="w-full p-3 pl-10 border-2 border-gray-200 rounded-lg text-base appearance-none focus:border-yellow-500 focus:ring-yellow-500 transition duration-300 bg-white"
              >
                <option value="Payment Problems">Payment Problems</option>
                <option value="Wrong Product and Quality Issue">Wrong Product / Quality</option>
                <option value="Delayed/Not Delivery">Delayed / Not Delivered</option>
                <option value="Security Concerns">Security Concerns</option>
                <option value="Technical Glitches">Technical Glitches</option>
                <option value="Inappropriate Content or Behavior">Inappropriate Content</option>
                <option value="Others">Others</option>
              </select>
              <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
            </div>
          </div>

          <div class="mb-6 text-left">
            <label class="block text-gray-700 font-semibold mb-2 text-sm">Message</label>
            <div class="relative">
              <i class="fa-solid fa-message absolute left-3 top-5 text-gray-400"></i>
              <textarea 
                v-model="form.message" 
                placeholder="Let us know what you need help with..." 
                rows="5" 
                class="w-full p-3 pl-10 border-2 border-gray-200 rounded-lg text-base focus:border-yellow-500 focus:ring-yellow-500 transition duration-300 resize-none" 
                required
              ></textarea>
            </div>
          </div>

          <button 
            type="submit" 
            class="w-full bg-red-600 text-white rounded-lg py-4 px-6 text-lg font-bold tracking-wider mt-4 hover:bg-gray-800 shadow-xl transition duration-300 focus:outline-none focus:ring-4 focus:ring-yellow-500 focus:ring-opacity-50"
          >
            Send Message
          </button>

        </form>
      </div>
    </div>
  </div>
</section>
</template>

<script setup>
import { reactive } from 'vue'
import NavBar from '../components/layouts/NavBar.vue'

// Reactive form object
const form = reactive({
  fullname: '',
  email: '',
  issue: 'Payment Problems',
  message: ''
})

// Form submit handler
function handleSubmit() {
  console.log('Form submitted:', form)
  alert('Message sent successfully!')
  // Reset form
  form.fullname = ''
  form.email = ''
  form.issue = 'Payment Problems'
  form.message = ''
}
</script>

<style>
/* You'll need to link Font Awesome for the icons (fa-...) and potentially the Montserrat font */
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap');

body {
  font-family: 'Montserrat', sans-serif;
}
</style>