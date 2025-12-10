<script setup>
import { useAuthStore } from '@/stores/auth'
const auth = useAuthStore()
</script>

<template>
  <div class="min-h-screen flex flex-col font-inter bg-gray-50">

    <!-- HERO SECTION -->
    <section
      class="relative h-[70vh] min-h-[450px] flex items-center justify-center p-8 bg-cover bg-center"
      style="background-image: url('https://images.unsplash.com/photo-1497436072909-60f6f2e7b8c6?auto=format&fit=crop&w=1600&q=80');"
    >
      <!-- Dark overlay -->
      <div class="absolute inset-0 bg-black bg-opacity-50"></div>

      <div class="relative z-10 max-w-5xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <p class="text-sm sm:text-base font-semibold text-emerald-400 mb-4 tracking-widest uppercase">
          EcoTrack Software
        </p>

        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold mb-6 text-white leading-tight drop-shadow-xl">
          <span class="block">MEASURE YOUR IMPACT.</span>
          <span class="block text-blue-400">DRIVE SUSTAINABILITY.</span>
        </h1>

        <p class="text-lg sm:text-xl md:text-2xl text-gray-200 mb-8 max-w-3xl mx-auto drop-shadow">
          Monitor, Reduce, and Track Your Environmental Footprint in Real Time.
        </p>

        <div class="flex flex-wrap justify-center gap-4 mt-4">
          <!-- Show buttons only if NOT logged in -->
          <router-link 
            v-if="!auth.isAuthenticated" 
            to="/register"
            class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 sm:px-10 sm:py-5 rounded-lg text-lg sm:text-xl font-bold shadow-lg transition transform hover:scale-105"
          >
            Get Started Free
          </router-link>

          <router-link 
            v-if="!auth.isAuthenticated" 
            to="/login"
            class="bg-gray-800 hover:bg-gray-700 text-white px-8 py-4 sm:px-10 sm:py-5 rounded-lg text-lg sm:text-xl font-bold shadow-lg transition transform hover:scale-105"
          >
            Book a Demo
          </router-link>
        </div>
      </div>
    </section>

  </div>
</template>
