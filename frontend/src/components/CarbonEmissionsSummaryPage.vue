<template>
  <div class="bg-white p-8 rounded-xl shadow-lg">
    <h2 class="text-3xl font-bold mb-6 text-emerald-700">Emissions History</h2>
    <div v-for="e in emissions" :key="e.id" class="border-b py-4">
      <p><strong>Date:</strong> {{ new Date(e.created_at).toLocaleDateString() }}</p>
      <p><strong>CO₂:</strong> {{ e.total_co2.toFixed(2) }} tons</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const emissions = ref([])
onMounted(async () => {
  const res = await axios.get('/emissions')
  emissions.value = res.data
})
</script>