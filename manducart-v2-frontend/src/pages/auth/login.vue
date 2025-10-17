<template>
    <div class="flex justify-center items-center h-screen bg-gray-100">
        <form @submit.prevent="validateForm" class="bg-white rounded-lg shadow-md w-96 p-8 text-center">
            <!-- Logo -->
            <div class="flex items-center justify-center mb-4 w-2/3 mx-auto">
                <img src="../../assets/svgs/manducart-logo.svg" alt="manducart-logo" />
            </div>

            <!-- Login Title -->
            <div>
                <h1 id="login-text" class="text-2xl font-bold mt-3 mb-6">Login</h1>
            </div>

            <!-- Email -->
            <div class="text-left mb-4">
                <div class="flex items-center mb-1">
                    <i class="fa-solid fa-user text-gray-600 mr-2"></i>
                    <label for="email" class="text-gray-700 font-semibold text-sm">Email</label>
                </div>
                <input v-model="email" type="email" id="email"
                    class="w-full border border-gray-300 rounded-md p-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-400"
                    placeholder="Enter your email" />
            </div>

            <!-- Password -->
            <div class="text-left mb-4">
                <div class="flex items-center mb-1">
                    <i class="fa-solid fa-unlock text-gray-600 mr-2"></i>
                    <label for="password" class="text-gray-700 font-semibold text-sm">Password</label>
                </div>
                <input v-model="password" type="password" id="password"
                    class="w-full border border-gray-300 rounded-md p-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-400"
                    placeholder="Enter your password" />
                <h5 class="text-right mt-1">
                    <Routelink class="text-slate-500 text-sm hover:underline">
                        Forgot Password?
                    </Routelink>
                </h5>
            </div>

            <!-- Button -->
            <button type="submit"
                class="w-full bg-red-500 text-white py-3 rounded-md text-lg font-medium hover:bg-gray-700 transition-all duration-300 shadow-md cursor-pointer">
                Login
            </button>

            <!-- Signup -->
            <div>
                <p class="mt-3 text-sm">Don't have an Account?</p>
                <Routelink to="/signup" class="text-red-500 font-medium hover:underline cursor-pointer">Signup
                </Routelink>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const router = useRouter();

const email = ref("");
const password = ref("");
async function validateForm() {
    if (email.value.trim() === "" || password.value.trim() === "") {
        toast.error("Please enter both email and password", { autoClose: 3000 });
        return;
    }

    try {
        const response = await axios.post("http://127.0.0.1:8000/api/login", {
            email: email.value.trim(),
            password: password.value.trim(),
        });

        // Store token
        const token = response.data.token;
        localStorage.setItem("token", token);
        localStorage.setItem("role", response.data.user.role);
        localStorage.setItem("user", JSON.stringify(response.data.user));

        // Optional: set default header for future requests
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

        // Get user role
        const role = response.data.user.role;



        toast.success("Login successful!", { autoClose: 2000 });

        // Redirect based on role
        setTimeout(() => {
            if (role === "admin") {
                router.push("/admin");
            } else if (role === "user") {
                router.push("/");
            } else {
                router.push("/"); // default fallback
            }
        }, 1000);

    } catch (error) {
        if (error.response && error.response.data.message) {
            toast.error(error.response.data.message, { autoClose: 3000 });
        } else {
            toast.error("Invalid credentials or server error", { autoClose: 3000 });
        }
    }
}

</script>
