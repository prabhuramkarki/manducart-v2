// stores/auth.js
import { defineStore } from "pinia";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        user: (() => {
            const userStr = localStorage.getItem("user");
            return userStr ? JSON.parse(userStr) : null;
        })(),
        token: localStorage.getItem("token") || null,
        role: localStorage.getItem("role") || null,
    }),
    actions: {
        login(user: { role: string; [key: string]: any }, token: string) {
            this.user = user;
            this.token = token;
            this.role = user.role;
            localStorage.setItem("user", JSON.stringify(user));
            localStorage.setItem("token", token);
            localStorage.setItem("role", user.role);
        },
        logout() {
            this.user = null;
            this.token = null;
            this.role = null;
            localStorage.removeItem("user");
            localStorage.removeItem("token");
            localStorage.removeItem("role");
        },
        isLoggedIn() {
            return !!this.token;
        }
    }
});
