import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

import Home from '@/views/Home.vue';
import Login from '@/components/Login.vue';
import SignUp from '@/components/SignUp.vue';
import DashBoard from '@/components/DashBoard.vue';
import Admin from '@/views/Admin.vue';
import SupplierDetails from '@/components/SupplierDetails.vue'
import SupplierList from '@/components/SupplierList.vue'

const routes = [
  { path: '/', component: Home },

  { path: '/login', component: Login, meta: { hideLayout: true } },
  { path: '/register', component: SignUp, meta: { hideLayout: true } },

   { path: '/suppliers', name: 'SupplierList', component: SupplierList, meta: { requiresAuth: true } },

  { path: '/dashboard', component: DashBoard, meta: { requiresAuth: true, role: 'user' } },
  { path: '/profile', component: () => import('@/components/Profile.vue'), meta: { requiresAuth: true } },
  { path: '/emissions', component: () => import('@/components/CarbonEmissionsInputForm.vue'), meta: { requiresAuth: true } },
  { path: '/waste', component: () => import('@/components/WasteTrackingInputForm.vue'), meta: { requiresAuth: true } },
  { path: '/resources', component: () => import('@/components/ResourceUsageInputForm.vue'), meta: { requiresAuth: true } },
  { path: '/suppliers', component: () => import('@/components/SupplierList.vue'), meta: { requiresAuth: true } },
  { path: '/supplier/:id', component: SupplierDetails, props: true },

  { path: '/admin', component: Admin, meta: { requiresAuth: true, role: 'admin' } },

  { path: '/about', component: () => import('@/components/AboutUs.vue') },
  { path: '/contact', component: () => import('@/components/Contact.vue') },
  { path: '/privacy', component: () => import('@/components/PrivacyPolicy.vue') },
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

// Global navigation guard
router.beforeEach((to, from, next) => {
  const auth = useAuthStore();
  const user = auth.user;

  // 1️⃣ Redirect logged-in users from login/register
  if ((to.path === '/login' || to.path === '/register') && auth.token) {
    return next(user?.role === 'admin' ? '/admin' : '/dashboard');
  }

  // 2️⃣ Protected routes require login
  if (to.meta.requiresAuth && !auth.token) {
    return next('/login');
  }

  // 3️⃣ Role-based access
  if (to.meta.role) {
    // If user is logged in but role doesn’t match, redirect to their dashboard
    if (!user || user.role !== to.meta.role) {
      return next(user?.role === 'admin' ? '/admin' : '/dashboard');
    }
  }

  next();
});

export default router;
