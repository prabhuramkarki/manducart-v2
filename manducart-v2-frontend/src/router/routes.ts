import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from "../store/auth";
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

// admin routes 
import AdminLayout from '../layouts/AdminLayout.vue';
import AdminDashboard from '../pages/admin/dashboard.vue';

//user login profile
import Profile from '../pages/profile.vue';


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

  // product detail (dynamic) - lazy-loaded
  { path: '/product/:id', name: 'product', component: () => import('../pages/[id].vue') },

  

  // for testing
  // { path: '/addproduct', component: AddProducts },
  // { path: '/products', component: Products },
  
  // admin routes paths
  {
    path: "/admin",
    component: AdminLayout,
    meta: { requiresAuth: true, adminOnly: true },
    children: [
      {
        path: '',
        name: 'AdminDashboard',
        component: AdminDashboard,
      },
      {
        path: 'addproduct',
        name: 'AdminAddProduct',
        component: AddProducts,
      },
      {
        path: 'products',
        name: 'AdminProducts',
        component: Products,
      },
    ],
  },

  //auth routes
  { path: '/login', component: Login, meta: { guestOnly: true } },
  { path: '/signup', component: Signup, meta: { guestOnly: true } },


  //profile 
  { path: '/profile', component: Profile, meta: { requiresAuth: true } },





];

const router = createRouter({
  history: createWebHistory(),
  routes
});

router.beforeEach((to, _from, next) => {
  const auth = useAuthStore();

  const isLogged = auth.isLoggedIn() || !!localStorage.getItem("token");
  const role = auth.role || localStorage.getItem("role");

  // Prevent logged-in users from visiting guest-only pages (e.g., login, signup)
  if (to.meta?.guestOnly && isLogged) {
    return next(role === "admin" ? "/admin" : "/profile");
  }

  // Require auth for protected routes
  if (to.meta?.requiresAuth && !isLogged) {
    return next({ path: "/login", query: { redirect: to.fullPath } });
  }

  // Admin-only routes
  if (to.meta?.adminOnly && role !== "admin") {
    return next("/");
  }

  return next();
});


export default router;
