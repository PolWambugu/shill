import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

import Home from '@/views/Home.vue';
import Login from '@/components/Login.vue';
import SignUp from '@/components/SignUp.vue';
import DashBoard from '@/components/DashBoard.vue';
import Admin from '@/views/Admin.vue';

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', component: Home },

    { path: '/login', component: Login, meta: { hideLayout: true } },
    { path: '/register', component: SignUp, meta: { hideLayout: true } },

    { path: '/dashboard', component: DashBoard, meta: { requiresAuth: true } },
    { path: '/profile', component: () => import('@/components/Profile.vue'), meta: { requiresAuth: true } },
    { path: '/emissions', component: () => import('@/components/CarbonEmissionsInputForm.vue'), meta: { requiresAuth: true } },
    { path: '/waste', component: () => import('@/components/WasteTrackingInputForm.vue'), meta: { requiresAuth: true } },
    { path: '/resources', component: () => import('@/components/ResourceUsageInputForm.vue'), meta: { requiresAuth: true } },
    { path: '/suppliers', component: () => import('@/components/SupplierList.vue'), meta: { requiresAuth: true } },

    { path: '/admin', component: Admin, meta: { requiresAuth: true, requiresAdmin: true } },

    { path: '/about', component: () => import('@/components/AboutUs.vue') },
    { path: '/contact', component: () => import('@/components/Contact.vue') },
    { path: '/privacy', component: () => import('@/components/PrivacyPolicy.vue') }
  ]
});

// Reactive navigation guard using Pinia store
router.beforeEach((to, from, next) => {
  const auth = useAuthStore();

  // logged-in users cannot access login/register
  if ((to.path === '/login' || to.path === '/register') && auth.token) {
    return next('/dashboard');
  }

  // protected routes
  if (to.meta.requiresAuth && !auth.token) {
    return next('/login');
  }

  // admin-only
  if (to.meta.requiresAdmin && auth.user?.role !== 'admin') {
    return next('/');
  }

  next();
});

export default router;
