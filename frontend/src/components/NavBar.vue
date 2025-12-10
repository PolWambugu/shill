<template>
  <nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-8 py-6 flex justify-between items-center">
      <!-- Logo -->
      <router-link :to="homeLink" class="text-4xl font-extrabold text-emerald-700 hover:text-emerald-600 transition">
        EcoTrack
      </router-link>

      <!-- Logged In Menu -->
      <div v-if="isLoggedIn" class="flex items-center space-x-6 text-lg md:space-x-10">
        <router-link v-if="role === 'user'" to="/dashboard" class="text-gray-700 hover:text-emerald-600 font-medium transition">
          Dashboard
        </router-link>
        <router-link v-else-if="role === 'admin'" to="/admin" class="text-gray-700 hover:text-emerald-600 font-medium transition">
          Admin Panel
        </router-link>

        <router-link v-if="role === 'user'" to="/emissions" class="text-gray-700 hover:text-emerald-600 font-medium transition">
          Emissions
        </router-link>
        <router-link v-if="role === 'user'" to="/waste" class="text-gray-700 hover:text-emerald-600 font-medium transition">
          Waste
        </router-link>
        <router-link v-if="role === 'user'" to="/resources" class="text-gray-700 hover:text-emerald-600 font-medium transition">
          Resources
        </router-link>

        <router-link v-if="role === 'admin'" to="/suppliers" class="text-gray-700 hover:text-emerald-600 font-medium transition">
          Suppliers
        </router-link>

        <router-link to="/profile" class="text-gray-700 hover:text-emerald-600 font-medium transition">
          Profile
        </router-link>

        <button @click="logout" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-full font-semibold transition shadow-md">
          Logout
        </button>
      </div>

      <!-- Not Logged In -->
      <div v-else class="space-x-4 md:space-x-8 text-lg">
        <router-link to="/login" class="text-gray-700 hover:text-emerald-600 font-medium transition">Login</router-link>
        <router-link to="/register" class="bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-2 rounded-full font-semibold transition shadow-md">
          Get Started
        </router-link>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { computed } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const auth = useAuthStore()

// ✅ Reactive computed properties
const isLoggedIn = computed(() => auth.isAuthenticated)
const role = computed(() => auth.user?.role || null)
const homeLink = computed(() => isLoggedIn.value ? (role.value === 'admin' ? '/admin' : '/dashboard') : '/')

// Logout function
const logout = () => {
  auth.logout()
  router.push('/')
}
</script>
