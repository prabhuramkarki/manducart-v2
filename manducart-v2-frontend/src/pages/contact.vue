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
                v-model="formData.fullname" 
                type="text" 
                placeholder="Enter Your Name" 
                @blur="validateFullname"
                :class="[
                  'w-full p-3 pl-10 border-2 rounded-lg text-base transition duration-300',
                  errors.fullname ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-200 focus:border-yellow-500 focus:ring-yellow-500'
                ]"
              />
            </div>
            <p v-if="errors.fullname" class="text-red-500 text-sm mt-1">{{ errors.fullname }}</p>
          </div>

          <div class="mb-5 text-left">
            <label class="block text-gray-700 font-semibold mb-2 text-sm">Email</label>
            <div class="relative">
              <i class="fa-solid fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
              <input 
                v-model="formData.email" 
                type="email" 
                placeholder="Enter Your Email" 
                @blur="validateEmail"
                :class="[
                  'w-full p-3 pl-10 border-2 rounded-lg text-base transition duration-300',
                  errors.email ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-200 focus:border-yellow-500 focus:ring-yellow-500'
                ]"
              />
            </div>
            <p v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email }}</p>
          </div>

          <div class="mb-5 text-left">
            <label class="block text-gray-700 font-semibold mb-2 text-sm">Choose Your Issue</label>
            <div class="relative">
              <i class="fa-solid fa-question absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
              <select 
                v-model="formData.issue" 
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
                v-model="formData.message" 
                placeholder="Let us know what you need help with..." 
                rows="5" 
                @blur="validateMessage"
                :class="[
                  'w-full p-3 pl-10 border-2 rounded-lg text-base transition duration-300 resize-none',
                  errors.message ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-200 focus:border-yellow-500 focus:ring-yellow-500'
                ]"
              ></textarea>
            </div>
            <p v-if="errors.message" class="text-red-500 text-sm mt-1">{{ errors.message }}</p>
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
import axios from 'axios'
import NavBar from '../components/layouts/NavBar.vue'
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

// Reactive form object
const formData = reactive({
  fullname: '',
  email: '',
  issue: 'Payment Problems',
  message: ''
})

// Reactive errors object
const errors = reactive({
  fullname: '',
  email: '',
  message: ''
})

// Validation functions
function validateFullname() {
  if (!formData.fullname.trim()) {
    errors.fullname = 'Full name is required'
    return false
  }
  if (formData.fullname.trim().length < 2) {
    errors.fullname = 'Name must be at least 2 characters'
    return false
  }
  errors.fullname = ''
  return true
}

function validateEmail() {
  if (!formData.email.trim()) {
    errors.email = 'Email is required'
    return false
  }
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  if (!emailRegex.test(formData.email)) {
    errors.email = 'Please enter a valid email address'
    return false
  }
  errors.email = ''
  return true
}

function validateMessage() {
  if (!formData.message.trim()) {
    errors.message = 'Message is required'
    return false
  }
  if (formData.message.trim().length < 10) {
    errors.message = 'Message must be at least 10 characters'
    return false
  }
  errors.message = ''
  return true
}

// Form submit handler
async function handleSubmit() {
  // Validate all fields
  const isFullnameValid = validateFullname()
  const isEmailValid = validateEmail()
  const isMessageValid = validateMessage()

  if (!isFullnameValid || !isEmailValid || !isMessageValid) {
    toast.error('Please fill all the required fields')
    return
  }

  try {
    const response = await axios.post('http://127.0.0.1:8000/api/contact', formData)
    toast.success('Message sent successfully!')
    
    // Reset form
    formData.fullname = ''
    formData.email = ''
    formData.issue = 'Payment Problems'
    formData.message = ''
    
    // Clear errors
    errors.fullname = ''
    errors.email = ''
    errors.message = ''
  } catch (error) {
    console.error('Error submitting form:', error)
    toast.error('Failed to send message')
  }
}
</script>