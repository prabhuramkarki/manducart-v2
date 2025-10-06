import { createRouter, createWebHistory } from 'vue-router';
import Home from '../pages/index.vue';
import Mens from '../pages/mens.vue';
import Womens from '../pages/womens.vue';
import Shops from '../pages/shop.vue';
import About from '../pages/about.vue';
import Contact from '../pages/contact.vue';
import Search from '../pages/search.vue';
import Wishlist from '../pages/wishlist.vue';
import Cart from '../pages/cart.vue';

// admin routes imports
import AddProducts from '../pages/admin/addproduct.vue';
import Products from '../pages/admin/products.vue';

//auth routes imports
import Login from '../pages/auth/login.vue';
import Signup from '../pages/auth/signup.vue';

const routes = [
  { path: '/', component: Home },
  { path: '/mens', component: Mens },
  { path: '/womens', component: Womens },
  { path: '/shop', component: Shops },
  { path: '/about', component: About },
  { path: '/contact', component: Contact },
  { path: '/search', component: Search },
  { path: '/wishlist', component: Wishlist },
  { path: '/cart', component: Cart },
  

  // admin routes paths
  { path: '/addproduct', component: AddProducts },
  { path: '/products', component: Products },

  //auth routes
  { path: '/login', component: Login },
  { path: '/signup', component: Signup }


];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
