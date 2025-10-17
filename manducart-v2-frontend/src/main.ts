import { createApp } from 'vue'
import './assets/css/style.css'
import App from './App.vue'
import "vue3-toastify/dist/index.css";
import router from './router/routes.ts'
import { createPinia } from "pinia";


const app = createApp(App)
const pinia = createPinia();

app.use(router)
app.use(pinia);
app.mount('#app')
