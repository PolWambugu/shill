<template>
  <nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-8 py-6 flex justify-between items-center">
      <!-- Logo - Goes to Dashboard when logged in, Home when not -->
      <router-link :to="isLoggedIn ? '/dashboard' : '/'" 
                   class="text-4xl font-extrabold text-emerald-700 hover:text-emerald-600 transition">
        EcoTrack
      </router-link>

      <!-- Logged In Menu -->
      <div v-if="isLoggedIn" class="flex items-center space-x-10 text-xl">
        <router-link to="/dashboard" class="text-gray-700 hover:text-emerald-600 font-medium transition">Dashboard</router-link>
        <router-link to="/emissions" class="text-gray-700 hover:text-emerald-600 font-medium transition">Emissions</router-link>
        <router-link to="/waste" class="text-gray-700 hover:text-emerald-600 font-medium transition">Waste</router-link>
        <router-link to="/resources" class="text-gray-700 hover:text-emerald-600 font-medium transition">Resources</router-link>
        <router-link to="/suppliers" class="text-gray-700 hover:text-emerald-600 font-medium transition">Suppliers</router-link>
        <router-link to="/profile" class="text-gray-700 hover:text-emerald-600 font-medium transition">Profile</router-link>
        <!-- <router-link to="/about" class="text-gray-700 hover:text-emerald-600 font-medium transition">About Us</router-link> -->
        <!-- <li><router-link to="/about" class="text-gray-400 hover:text-white transition text-sm block">About Us</router-link></li> -->
<!-- <li><router-link to="/contact" class="text-gray-400 hover:text-white transition text-sm block">Contact</router-link></li> -->
<!-- <li><router-link to="/privacy" class="text-gray-400 hover:text-white transition text-sm block">Privacy Policy</router-link></li> -->
        <button @click="logout" class="bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-full font-bold transition shadow-lg">
          
          Logout
        </button>
      </div>

      <!-- Not Logged In -->
      <div v-else class="space-x-8 text-xl">
        <router-link to="/login" class="text-gray-700 hover:text-emerald-600 font-medium transition">Login</router-link>
        <router-link to="/register" class="bg-emerald-600 hover:bg-emerald-500 text-white px-10 py-4 rounded-full font-bold transition shadow-lg">
          Get Started
        </router-link>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const isLoggedIn = ref(false)

const checkLogin = () => {
  isLoggedIn.value = !!localStorage.getItem('token')
}

const logout = () => {
  localStorage.removeItem('token')
  isLoggedIn.value = false
  router.push('/')
}

onMounted(() => {
  checkLogin()
  window.addEventListener('storage', checkLogin)
  setInterval(checkLogin, 1000)
})
</script>