<template>
  <div class="p-6 space-y-10">

    <!-- FILTER BUTTONS -->
    <div class="flex gap-4">
      <button 
        v-for="f in filters" 
        :key="f.value"
        @click="setFilter(f.value)"
        :class="[ 
          'px-4 py-2 rounded-lg font-semibold',
          filter === f.value 
            ? 'bg-emerald-500 text-white'
            : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
        ]"
      >
        {{ f.label }}
      </button>
    </div>

    <!-- SUMMARY CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white rounded-xl shadow p-6 text-center">
        <h2 class="text-lg font-semibold text-gray-700">My CO₂</h2>
        <p class="text-5xl font-bold text-emerald-500 mt-2">
          {{ totalCO2 }} <span class="text-2xl">tons</span>
        </p>
      </div>

      <div class="bg-white rounded-xl shadow p-6 text-center">
        <h2 class="text-lg font-semibold text-gray-700">My Waste</h2>
        <p class="text-5xl font-bold text-blue-400 mt-2">
          {{ totalWaste }} <span class="text-2xl">t</span>
        </p>
      </div>

      <div class="bg-white rounded-xl shadow p-6 text-center">
        <h2 class="text-lg font-semibold text-gray-700">My resources</h2>
        <p class="text-5xl font-bold text-cyan-400 mt-2">
          {{ totalWater }} <span class="text-2xl">L</span>
        </p>
      </div>
    </div>

    <!-- USER CHARTS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">My CO₂ Emissions Chart</h2>
        <div class="h-48">
          <canvas id="co2Chart"></canvas>
        </div>
      </div>
      <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">My Waste Chart</h2>
        <div class="h-48">
          <canvas id="wasteChart"></canvas>
        </div>
      </div>
      <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">My Resource Chart</h2>
        <div class="h-48">
          <canvas id="waterChart"></canvas>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue'
import axios from 'axios'
import Chart from 'chart.js/auto'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()

// --- CO₂ ---
const totalCO2 = ref(0)
const emissionsList = ref([])
let co2Chart = null

const fetchEmissions = async () => {
  if (!auth.token) return
  try {
    const res = await axios.get('http://127.0.0.1:8000/api/emissions', {
      headers: { Authorization: `Bearer ${auth.token}` }
    })
    emissionsList.value = res.data
    totalCO2.value = emissionsList.value.reduce((sum, e) => sum + parseFloat(e.total_co2 || 0), 0).toFixed(2)
    await nextTick()
    renderCo2Chart()
  } catch (err) {
    totalCO2.value = '0.00'
    emissionsList.value = []
    await nextTick()
    renderCo2Chart()
  }
}

const renderCo2Chart = () => {
  const ctx = document.getElementById('co2Chart')
  if (!ctx) return
  if (co2Chart) co2Chart.destroy()

  const labels = emissionsList.value.length
    ? emissionsList.value.map(e => new Date(e.created_at).toLocaleDateString())
    : ['No data']
  const data = emissionsList.value.length
    ? emissionsList.value.map(e => parseFloat(e.total_co2))
    : [0]

  co2Chart = new Chart(ctx, {
    type: 'line',
    data: { labels, datasets: [{ label: 'CO₂ (tons)', data, borderColor: '#10B981', backgroundColor: 'rgba(16,185,129,0.1)', tension: 0.4, fill: true, pointBackgroundColor: '#10B981', pointRadius: 5 }] },
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
  })
}

// --- WASTE ---
const totalWaste = ref(0)
let wasteChart = null

const fetchWaste = async () => {
  if (!auth.token) return
  try {
    const res = await axios.get('http://127.0.0.1:8000/api/wastes', { headers: { Authorization: `Bearer ${auth.token}` } })
    const wastes = res.data
    totalWaste.value = wastes.reduce((sum, w) => sum + parseFloat(w.plastic_kg || 0) + parseFloat(w.paper_kg || 0) + parseFloat(w.organic_kg || 0), 0).toFixed(2)
    renderWasteChart(wastes)
  } catch (err) {
    totalWaste.value = '0.00'
  }
}

const renderWasteChart = (wastes) => {
  const ctx = document.getElementById('wasteChart')
  if (!ctx) return
  if (wasteChart) wasteChart.destroy()
  const labels = wastes.map(w => new Date(w.created_at).toLocaleDateString())
  const data = wastes.map(w => parseFloat(w.plastic_kg) + parseFloat(w.paper_kg) + parseFloat(w.organic_kg))
  wasteChart = new Chart(ctx, {
    type: 'bar',
    data: { labels: labels.length ? labels : ['No data'], datasets: [{ label: 'Total Waste (t)', data: data.length ? data : [0], backgroundColor: '#3B82F6' }] },
    options: { responsive: true, maintainAspectRatio: false }
  })
}

// --- RESOURCES MULTI-LINE CHART ---
const totalWater = ref(0)
const totalFuel = ref(0)
const totalUsage = ref(0)
const resourcesList = ref([])
let resourcesChart = null

const fetchResources = async () => {
  if (!auth.token) return
  try {
    const res = await axios.get('http://127.0.0.1:8000/api/resources', { 
      headers: { Authorization: `Bearer ${auth.token}` } 
    })

    resourcesList.value = res.data

    // Calculate totals
    totalWater.value = resourcesList.value.reduce((sum, r) => sum + parseFloat(r.water_liters || 0), 0).toFixed(2)
    totalFuel.value = resourcesList.value.reduce((sum, r) => sum + parseFloat(r.fuel_liters || 0), 0).toFixed(2)
    totalUsage.value = resourcesList.value.reduce((sum, r) => sum + parseFloat(r.total_usage || 0), 0).toFixed(2)

    await nextTick()
    renderResourcesChart()

  } catch (err) {
    console.error('Failed to fetch resources:', err)
    totalWater.value = '0.00'
    totalFuel.value = '0.00'
    totalUsage.value = '0.00'
    resourcesList.value = []
    await nextTick()
    renderResourcesChart()
  }
}

const renderResourcesChart = () => {
  const ctx = document.getElementById('waterChart') // match template ID
  if (!ctx) return
  if (resourcesChart) resourcesChart.destroy()

  const labels = resourcesList.value.length
    ? resourcesList.value.map(r => new Date(r.recorded_at).toLocaleDateString())
    : ['No data']

  const waterData = resourcesList.value.length
    ? resourcesList.value.map(r => parseFloat(r.water_liters || 0))
    : [0]

  const fuelData = resourcesList.value.length
    ? resourcesList.value.map(r => parseFloat(r.fuel_liters || 0))
    : [0]

  const totalData = resourcesList.value.length
    ? resourcesList.value.map(r => parseFloat(r.total_usage || 0))
    : [0]

  resourcesChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels,
      datasets: [
        {
          label: 'Water (L)',
          data: waterData,
          borderColor: '#3B82F6',
          backgroundColor: 'rgba(59,130,246,0.1)',
          tension: 0.4,
          fill: true,
          pointRadius: 4
        },
        {
          label: 'Fuel (L)',
          data: fuelData,
          borderColor: '#F97316',
          backgroundColor: 'rgba(249,115,22,0.1)',
          tension: 0.4,
          fill: true,
          pointRadius: 4
        },
        {
          label: 'Total Usage',
          data: totalData,
          borderColor: '#10B981',
          backgroundColor: 'rgba(16,185,129,0.1)',
          tension: 0.4,
          fill: true,
          pointRadius: 4
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: true } },
      scales: { y: { beginAtZero: true } }
    }
  })
}



// --- ON MOUNT ---
onMounted(() => {
  fetchEmissions()
  fetchWaste()
  fetchResources()

  window.addEventListener('emissions-updated', fetchEmissions)
  window.addEventListener('waste-updated', fetchWaste)
  window.addEventListener('resources-updated', fetchResources)
})
</script>

<style scoped>
canvas {
  width: 100% !important;
  height: 100% !important;
}
</style>
