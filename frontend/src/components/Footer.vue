<template>
  <footer class="bg-gray-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-8">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
        
        <!-- Logo -->
        <div>
          <h3 class="text-4xl font-extrabold text-emerald-400 mb-6">ECOTRACK</h3>
          <p class="text-gray-400 text-sm leading-relaxed">
            Real-time sustainability tracking for individuals and organizations.
          </p>
        </div>

        <!-- Quick Links -->
        <div>
          <h4 class="text-lg font-bold text-emerald-400 mb-4">Quick Links</h4>
          <ul class="space-y-3">
            <li><router-link to="/dashboard" class="text-gray-400 hover:text-white transition text-sm">Dashboard</router-link></li>
            <li><router-link to="/emissions" class="text-gray-400 hover:text-white transition text-sm">Carbon Emissions</router-link></li>
            <li><router-link to="/waste" class="text-gray-400 hover:text-white transition text-sm">Waste Tracking</router-link></li>
            <li><router-link to="/resources" class="text-gray-400 hover:text-white transition text-sm">Resources</router-link></li>
          </ul>
        </div>

        <!-- Company -->
        <div>
          <h4 class="text-lg font-bold text-emerald-400 mb-4">Company</h4>
          <ul class="space-y-3">
            <li><router-link to="/about" class="text-gray-400 hover:text-white transition text-sm">About Us</router-link></li>
            <li><router-link to="/contact" class="text-gray-400 hover:text-white transition text-sm">Contact</router-link></li>
            <li><router-link to="/privacy" class="text-gray-400 hover:text-white transition text-sm">Privacy Policy</router-link></li>
          </ul>
        </div>

        <!-- Contact -->
        <div>
          <h4 class="text-lg font-bold text-emerald-400 mb-4">Get in Touch</h4>
          <p class="text-gray-400 text-sm">shill@gmail.com</p>
          <p class="text-gray-400 text-sm mt-2">Final Year Project 2025</p>
        </div>
      </div>

      <!-- Copyright -->
      <div class="mt-12 pt-8 border-t border-gray-700 text-center text-gray-500 text-sm">
        © {{ new Date().getFullYear() }} EcoTrack • shill
      </div>
    </div>
  </footer>
</template>