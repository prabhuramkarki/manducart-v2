<template>
  <div class="flex justify-center items-center h-screen bg-gray-100">
    <form
      @submit.prevent="validateForm"
      class="bg-white rounded-lg shadow-md w-96 p-8 text-center"
    >
      <!-- Logo -->
      <div class="flex items-center justify-center mb-4 w-2/3 mx-auto">
        <img src="../../assets/svgs/manducart-logo.svg" alt="manducart-logo" />
      </div>

      <!-- Signup Title -->
      <div>
        <h1 id="signup-text" class="text-2xl font-bold mt-3 mb-6">Signup</h1>
      </div>

      <!-- Full Name -->
      <div class="text-left mb-4">
        <div class="flex items-center mb-1">
          <i class="fa-solid fa-user text-gray-600 mr-2"></i>
          <label for="fullname" class="text-gray-700 font-semibold text-sm">Full Name</label>
        </div>
        <input
          v-model="fullname"
          type="text"
          id="fullname"
          class="w-full border border-gray-300 rounded-md p-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-400"
          placeholder="Enter your full name"
        />
      </div>

      <!-- Email -->
      <div class="text-left mb-4">
        <div class="flex items-center mb-1">
          <i class="fa-solid fa-envelope text-gray-600 mr-2"></i>
          <label for="email" class="text-gray-700 font-semibold text-sm">Email</label>
        </div>
        <input
          v-model="email"
          type="email"
          id="email"
          class="w-full border border-gray-300 rounded-md p-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-400"
          placeholder="Enter your email"
        />
      </div>

      <!-- Password -->
      <div class="text-left mb-4">
        <div class="flex items-center mb-1">
          <i class="fa-solid fa-lock text-gray-600 mr-2"></i>
          <label for="password" class="text-gray-700 font-semibold text-sm">Password</label>
        </div>
        <input
          v-model="password"
          type="password"
          id="password"
          class="w-full border border-gray-300 rounded-md p-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-400"
          placeholder="Enter your password"
        />
      </div>

      <!-- Confirm Password -->
      <div class="text-left mb-4">
        <div class="flex items-center mb-1">
          <i class="fa-solid fa-lock text-gray-600 mr-2"></i>
          <label for="confirmPassword" class="text-gray-700 font-semibold text-sm">Confirm Password</label>
        </div>
        <input
          v-model="confirmPassword"
          type="password"
          id="confirmPassword"
          class="w-full border border-gray-300 rounded-md p-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-400"
          placeholder="Re-enter your password"
        />
      </div>

      <!-- Button -->
      <button
        type="submit"
        class="w-full bg-red-500 text-white py-3 rounded-md text-lg font-medium hover:bg-gray-700 transition-all duration-300 shadow-md"
      >
        Signup
      </button>

      <!-- Login Redirect -->
      <div>
        <p class="mt-3 text-sm">Already have an Account?</p>
        <Routelink
          to="/login"
          class="text-red-500 font-medium hover:underline cursor-pointer"
          >Login</Routelink
        >
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const fullname = ref("");
const email = ref("");
const password = ref("");
const confirmPassword = ref("");

async function validateForm() {
  if (
    fullname.value.trim() === "" ||
    email.value.trim() === "" ||
    password.value.trim() === "" ||
    confirmPassword.value.trim() === ""
  ) {
    toast.error("Please fill in all fields", { autoClose: 3000 });
    return;
  }

  if (password.value !== confirmPassword.value) {
    toast.warning("Passwords do not match", { autoClose: 3000 });
    return;
  }

  try {
    const response = await axios.post("http://127.0.0.1:8000/api/signup", {
      fullname: fullname.value,
      email: email.value,
      password: password.value,
      password_confirmation: confirmPassword.value,
    });

    toast.success(response.data.message || "Signup successful!", { autoClose: 3000 });
  } catch (error) {
    if (error.response && error.response.data.errors) {
      toast.error("Error: " + JSON.stringify(error.response.data.errors), {
        autoClose: 3000,
      });
    } else {
      toast.error("Something went wrong!", { autoClose: 3000 });
    }
  }
}
</script>
    