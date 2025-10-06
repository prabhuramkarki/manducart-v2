import { createApp } from 'vue'
import './assets/css/style.css'
import App from './App.vue'
import router from './router/routes.ts'

const app = createApp(App)
app.use(router)
app.mount('#app')
