<template>
  <div class="bg-white p-6 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold mb-4 text-emerald-700">Emissions History</h2>

    <!-- SMALL CHART -->
    <div class="mb-6" style="height:250px;">
      <canvas id="emissionsChart"></canvas>
    </div>

    <!-- LIST OF EMISSIONS -->
    <div v-for="e in emissions" :key="e.id" class="border-b py-2">
      <p><strong>Date:</strong> {{ new Date(e.created_at).toLocaleDateString() }}</p>
      <p><strong>CO₂:</strong> {{ e.total_co2.toFixed(2) }} tons</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import Chart from 'chart.js/auto'
import axios from 'axios'

// MOCK DATA FOR PRESENTATION USERS
const mockEmissions = [
  { id: 1, created_at: '2025-12-01', total_co2: 2.5 },
  { id: 2, created_at: '2025-12-02', total_co2: 3.2 },
  { id: 3, created_at: '2025-12-03', total_co2: 1.8 },
  { id: 4, created_at: '2025-12-04', total_co2: 2.0 },
  { id: 5, created_at: '2025-12-05', total_co2: 2.7 },
]

const emissions = ref([])
let chartInstance = null

const loadEmissions = async () => {
  const user = JSON.parse(localStorage.getItem('user'))

  // Use mock data for mock users
  const mockUserEmails = ['mary@greenfuel.com','john@ecopaper.com','fatma@bluewater.com','brian@solartech.com']
  if (user && mockUserEmails.includes(user.email)) {
    emissions.value = mockEmissions
  } else {
    // Real users fetch from API
    try {
      const res = await axios.get('/emissions')
      emissions.value = res.data
    } catch (err) {
      console.error(err)
    }
  }

  renderChart()
}

// RENDER SMALL CHART
const renderChart = () => {
  const ctx = document.getElementById('emissionsChart')
  if(chartInstance) chartInstance.destroy()

  chartInstance = new Chart(ctx, {
    type: 'line',
    data: {
      labels: emissions.value.map(e => new Date(e.created_at).toLocaleDateString()),
      datasets: [{
        label: 'CO₂ (tons)',
        data: emissions.value.map(e => e.total_co2),
        borderColor: '#16a34a',
        backgroundColor: 'rgba(16,163,74,0.2)',
        tension: 0.3,
        fill: true,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        y: { beginAtZero: true },
        x: { ticks: { maxRotation: 0, minRotation: 0 } }
      }
    }
  })
}

onMounted(loadEmissions)
</script>

<style scoped>
</style>
