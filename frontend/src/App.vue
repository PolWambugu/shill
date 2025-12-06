<template>
  <div id="app" class="flex flex-col min-h-screen antialiased text-gray-800">
    <NavBar v-if="!isLayoutHidden" />
    <main class="flex-grow">
      <router-view />
    </main>
    <AppFooter v-if="!isLayoutHidden" />
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import NavBar from './components/NavBar.vue';
import AppFooter from './components/Footer.vue';

const route = useRoute();
const isLayoutHidden = ref(route.meta.hideLayout || false);

watch(
  () => route.fullPath,
  () => {
    isLayoutHidden.value = route.meta.hideLayout || false;
  },
  { immediate: true }
);
</script>
