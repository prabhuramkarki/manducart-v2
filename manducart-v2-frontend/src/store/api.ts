import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";

export const useApiStore = defineStore("api", () => {
    const api = ref(
        axios.create({
            baseURL: import.meta.env.VITE_API_URL,
            headers: {
                "Content-Type": "application/json",
            },
        })
    );

    api.value.interceptors.request.use(
        (config) => {
            const token = localStorage.getItem("token");
            if (token) {
                config.headers.Authorization = `Bearer ${token}`;
            }
            return config;
        },
        (error) => {
            return Promise.reject(error);
        }
    );

    return {
        api,
    };
});