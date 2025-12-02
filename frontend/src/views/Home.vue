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
          <!-- <router-link
            to="/register"
            class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 sm:px-10 sm:py-5 rounded-lg text-lg sm:text-xl font-bold shadow-lg transition transform hover:scale-105"
          >
            Get Started Free
          </router-link> -->
<!-- 
          <router-link
            to="/login"
            class="bg-gray-800 hover:bg-gray-700 text-white px-8 py-4 sm:px-10 sm:py-5 rounded-lg text-lg sm:text-xl font-bold shadow-lg transition transform hover:scale-105"
          >
            Book a Demo
          </router-link> -->
        </div>
      </div>
    </section>

    <!-- FEATURES SECTION -->
    <section class="py-20 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-center mb-12 text-gray-900">
          Powerful Features
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12">
          <!-- Feature 1 -->
          <div class="text-center p-6 bg-white rounded-xl shadow-xl hover:shadow-2xl transition duration-300 border border-gray-100">
            <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4 ring-4 ring-emerald-300">
              <span class="text-3xl">🌍</span>
            </div>
            <h3 class="text-xl sm:text-2xl font-bold mb-2 text-gray-900">Carbon Tracking</h3>
            <p class="text-gray-600 text-base sm:text-lg">
              Calculate your footprint from electricity, travel, and industry.
            </p>
          </div>

          <!-- Feature 2 -->
          <div class="text-center p-6 bg-white rounded-xl shadow-xl hover:shadow-2xl transition duration-300 border border-gray-100">
            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 ring-4 ring-blue-300">
              <span class="text-3xl">♻️</span>
            </div>
            <h3 class="text-xl sm:text-2xl font-bold mb-2 text-gray-900">Waste Management</h3>
            <p class="text-gray-600 text-base sm:text-lg">
              Track plastic, paper, and organic waste streams for better recycling.
            </p>
          </div>

          <!-- Feature 3 -->
          <div class="text-center p-6 bg-white rounded-xl shadow-xl hover:shadow-2xl transition duration-300 border border-gray-100">
            <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4 ring-4 ring-purple-300">
              <span class="text-3xl">💧</span>
            </div>
            <h3 class="text-xl sm:text-2xl font-bold mb-2 text-gray-900">Resource Monitoring</h3>
            <p class="text-gray-600 text-base sm:text-lg">
              Monitor water and fuel consumption with smart alerts and reporting.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- STATS SECTION -->
    <section class="py-20 bg-emerald-800 text-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-12">Real Results</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12">
          <div>
            <p class="text-5xl sm:text-6xl md:text-7xl font-extrabold text-emerald-300">15%</p>
            <p class="text-lg sm:text-xl mt-2">Average CO₂ Reduction</p>
          </div>
          <div>
            <p class="text-5xl sm:text-6xl md:text-7xl font-extrabold text-blue-300">5,000+</p>
            <p class="text-lg sm:text-xl mt-2">Active Users</p>
          </div>
          <div>
            <p class="text-5xl sm:text-6xl md:text-7xl font-extrabold text-purple-300">1M+</p>
            <p class="text-lg sm:text-xl mt-2">Tons of CO₂ Tracked</p>
          </div>
        </div>
      </div>
    </section>

    <!-- FINAL CTA SECTION -->
    <section class="py-20 text-center bg-white shadow-inner">
      <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 text-gray-900">
        Start Your Journey Today
      </h2>
      <p class="text-lg sm:text-xl text-gray-600 mb-8">
        Join thousands making a measurable difference for the planet.
      </p>
      <!-- <router-link
        to="/register"
        class="bg-emerald-600 hover:bg-emerald-500 text-white px-12 sm:px-20 py-4 sm:py-8 rounded-full text-xl sm:text-3xl font-bold shadow-2xl transition transform hover:scale-105"
      >
        Get Started Free
      </router-link> -->
    </section>

  </div>
</template>

<script setup>
</script>

<style>
/* Import Inter font */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
</style>