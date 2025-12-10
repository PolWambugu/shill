<template>
  <div class="bg-white p-8 rounded-xl shadow-lg">
    <h2 class="text-3xl font-bold mb-6 text-emerald-700">Waste Summary</h2>

    <div v-for="(w, idx) in waste" :key="idx" class="border-b py-4">
      <p><strong>Date:</strong> {{ w.recorded_at || w.date }}</p>
      <p>Total Waste: {{ ((w.plastic_t || w.plastic) + (w.paper_t || w.paper) + (w.organic_t || w.organic)).toFixed(1) }} t</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

// Get current user
const currentUser = JSON.parse(localStorage.getItem('user')) || {}
const isMockUser = ['mary@greenfuel.com','john@ecopaper.com','fatma@bluewater.com','brian@solartech.com'].includes(currentUser.email)

const waste = ref([])

onMounted(async () => {
  if (isMockUser) {
    // MOCK DATA
    waste.value = [
      { date: '2025-12-01', plastic: 5.2, paper: 3.5, organic: 8.0 },
      { date: '2025-12-02', plastic: 4.8, paper: 3.0, organic: 7.5 },
      { date: '2025-12-03', plastic: 6.0, paper: 2.5, organic: 6.8 },
      { date: '2025-12-04', plastic: 5.5, paper: 3.8, organic: 7.2 },
      { date: '2025-12-05', plastic: 5.9, paper: 3.6, organic: 8.1 }
    ]
  } else {
    // REAL DATA
    try {
      const res = await axios.get('/waste')
      waste.value = res.data
    } catch (err) {
      console.error('Failed to fetch waste data', err)
    }
  }
})
</script>
