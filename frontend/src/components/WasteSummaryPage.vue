<template>
  <div class="bg-white p-8 rounded-xl shadow-lg">
    <h2 class="text-3xl font-bold mb-6 text-emerald-700">Waste Summary</h2>
    <div v-for="w in waste" :key="w.id" class="border-b py-4">
      <p><strong>Date:</strong> {{ w.recorded_at }}</p>
      <p>Total Waste: {{ (w.plastic_kg + w.paper_kg + w.organic_kg).toFixed(1) }} kg</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const waste = ref([])
onMounted(async () => {
  const res = await axios.get('/waste')
  waste.value = res.data
})
</script>