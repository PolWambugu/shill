<template>
  <div class="bg-white p-8 rounded-xl shadow-lg">
    <h2 class="text-3xl font-bold mb-6 text-emerald-700">Resource Usage Summary</h2>

    <div v-for="(r, idx) in resources" :key="idx" class="border-b py-4">
      <p><strong>Date:</strong> {{ r.recorded_at || r.date }}</p>
      <p>Water: {{ r.water_liters || r.water }} L | Fuel: {{ r.fuel_liters || r.fuel || 0 }} L</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

// CHECK IF CURRENT USER IS MOCK
const currentUser = JSON.parse(localStorage.getItem('user')) || {}
const isMockUser = ['mary@greenfuel.com','john@ecopaper.com','fatma@bluewater.com','brian@solartech.com'].includes(currentUser.email)

const resources = ref([])

onMounted(async () => {
  if (isMockUser) {
    // MOCK DATA
    resources.value = [
      { date: '2025-12-01', water: 120, fuel: 60 },
      { date: '2025-12-02', water: 140, fuel: 50 },
      { date: '2025-12-03', water: 130, fuel: 70 },
      { date: '2025-12-04', water: 150, fuel: 65 },
      { date: '2025-12-05', water: 160, fuel: 80 }
    ]
  } else {
    // REAL DATA FROM DATABASE
    try {
      const res = await axios.get('/resources')
      resources.value = res.data
    } catch (err) {
      console.error('Failed to fetch resources', err)
    }
  }
})
</script>
