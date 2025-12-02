<template>
  <!-- Main container, enforcing a minimum screen height and using flex-col to stack children vertically -->
  <div id="app" class="flex flex-col min-h-screen antialiased text-gray-800">
    
    <!-- 1. Navigation Bar (Stays fixed at the top) -->
    <NavBar /> 
    
    <!-- 2. Main Content Area (Expands to fill available vertical space) -->
    <main class="flex-grow">
      <!-- The router-view component loads the component corresponding to the current URL (e.g., Home.vue, Dashboard.vue) -->
      <router-view />
    </main>
    
    <!-- 3. Footer (Always pushed to the bottom) -->
    <AppFooter /> 
  </div>
</template>

<script setup>
// Importing necessary global components
import NavBar from './components/NavBar.vue'; 
import AppFooter from './components/Footer.vue'; // Using AppFooter to avoid name conflict if App.vue had its own footer logic
</script>