<template>
  <div class="bg-white p-8 rounded-xl shadow-lg">
    <h2 class="text-3xl font-bold mb-6 text-emerald-700">Resource Usage Summary</h2>
    <div v-for="r in resources" :key="r.id" class="border-b py-4">
      <p><strong>Date:</strong> {{ r.recorded_at }}</p>
      <p>Water: {{ r.water_liters }} L | Fuel: {{ r.fuel_liters || 0 }} L</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const resources = ref([])
onMounted(async () => {
  const res = await axios.get('/resources')
  resources.value = res.data
})
</script>