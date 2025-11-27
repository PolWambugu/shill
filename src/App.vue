<script setup>
import {RouterView} from 'vue-router'
import NavBar from './components/NavBar.vue'
</script>

<template>
  <v-app>
  <NavBar/>
  <v-main>
  <main>
      <RouterView></RouterView>
  </main>
  </v-main>
</v-app>

</template>

<style scoped></style>