<template>
  <div class="bg-white p-8 rounded-xl shadow-lg mt-10">
    <h2 class="text-3xl font-bold mb-6 text-emerald-700">Your CO₂ Trend</h2>
    <canvas ref="chart"></canvas>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import Chart from 'chart.js/auto'
import axios from 'axios'

const chart = ref(null)

onMounted(async () => {
  const res = await axios.get('/emissions')
  const labels = res.data.map(e => new Date(e.created_at).toLocaleDateString())
  const data = res.data.map(e => e.total_co2)

  new Chart(chart.value, {
    type: 'line',
    data: {
      labels,
      datasets: [{
        label: 'CO₂ Emissions (tons)',
        data,
        borderColor: '#10b981',
        backgroundColor: 'rgba(16, 185, 129, 0.1)',
        tension: 0.4
      }]
    }
  })
})
</script>