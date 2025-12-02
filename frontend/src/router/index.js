import { createRouter, createWebHistory } from 'vue-router'
import Home from '@/views/Home.vue'
import Login from '@/components/Login.vue'
import SignUp from '@/components/SignUp.vue'
import DashBoard from '@/components/DashBoard.vue'
import Admin from '@/views/Admin.vue' // 1. IMPORT ADMIN VIEW

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/', component: Home },
    { path: '/login', component: Login },
    { path: '/register', component: SignUp },
    { path: '/dashboard', component: DashBoard, meta: { requiresAuth: true } },
    { path: '/about', component: () => import('@/components/AboutUs.vue') },
    { path: '/contact', component: () => import('@/components/Contact.vue') },
{ path: '/privacy', component: () => import('@/components/PrivacyPolicy.vue') },
{ path: '/profile', component: () => import('@/components/Profile.vue'), meta: { requiresAuth: true } },
    { 
      path: '/emissions', 
      component: () => import('@/components/CarbonEmissionsInputForm.vue'),
      meta: { requiresAuth: true }
    },
    {
      path: '/waste',
      component: () => import('@/components/WasteTrackingInputForm.vue'),
      meta: { requiresAuth: true }
    },
    {
      path: '/resources',
      component: () => import('@/components/ResourceUsageInputForm.vue'),
      meta: { requiresAuth: true }
    },
    {
      path: '/suppliers',
      component: () => import('@/components/SupplierList.vue'),
      meta: { requiresAuth: true }
    },
    // 2. INTEGRATE ADMIN ROUTE INTO THE ARRAY
    {
      path: '/admin',
      name: 'Admin',
      component: Admin,
      // Use meta fields for checking in the global guard
      meta: { requiresAuth: true, requiresAdmin: true } 
    }
  ]
})

// Consolidated Global Navigation Guard
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')
  const userRole = localStorage.getItem('user_role') // Get the stored role

  // Check 1: General Authentication (Any protected route)
  if (to.meta.requiresAuth && !token) {
    // If auth is required but no token exists, redirect to login
    return next('/login')
  }

  // Check 2: Administrator Authorization
  if (to.meta.requiresAdmin && (!token || userRole !== 'admin')) {
    // If admin role is required, but user is not an admin, redirect to home
    // This is the core logic for restricting the /admin route
    return next('/') 
  }

  // Allow navigation if no guards are triggered
  next()
})

export default router