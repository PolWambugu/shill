<template>
  <div class="bg-white p-8 rounded-xl shadow-lg max-w-3xl mx-auto">
    <h2 class="text-3xl font-bold mb-6 text-emerald-700">Resource Usage</h2>

    <form @submit.prevent="submitResource" class="grid md:grid-cols-2 gap-6">
      <div>
        <label class="block text-gray-700 font-medium mb-2">Water Used (Liters)</label>
        <input v-model.number="water" type="number" class="w-full p-3 border rounded-lg" placeholder="Enter liters" required />
      </div>
      <div>
        <label class="block text-gray-700 font-medium mb-2">Fuel Used (Liters)</label>
        <input v-model.number="fuel" type="number" class="w-full p-3 border rounded-lg" placeholder="Enter liters" required />
      </div>

      <button type="submit" class="mt-8 bg-emerald-600 text-white px-10 py-4 rounded-lg hover:bg-emerald-700 text-xl col-span-full">
        Save Resource Data
      </button>
    </form>

    <div v-if="total" class="mt-8 p-6 bg-emerald-50 rounded-xl text-center">
      <p class="text-2xl font-bold text-emerald-700 animate-pulse">Total Resources: {{ total }} units</p>
    </div>

    <!-- Pie Chart -->
    <div class="mt-6">
      <canvas ref="pieChart" height="150"></canvas>
    </div>

    <!-- Trend Line Chart -->
    <div class="mt-6">
      <canvas ref="lineChart" height="150"></canvas>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import Chart from 'chart.js/auto'
import axios from 'axios'

// USER MOCK DATA SETUP
const currentUser = JSON.parse(localStorage.getItem('user')) || {}
const isMockUser = ['mary@greenfuel.com','john@ecopaper.com','fatma@bluewater.com','brian@solartech.com'].includes(currentUser.email)

// STATE
const water = ref(0)
const fuel = ref(0)
const total = ref(0)

const pieChart = ref(null)
const lineChart = ref(null)
let pieInstance, lineInstance

const trendData = ref([])

// LOAD MOCK DATA IF USER IS MOCK
const loadMockData = () => {
  if (!isMockUser) return
  const mockEntries = [
    { water: 120, fuel: 60 },
    { water: 140, fuel: 50 },
    { water: 130, fuel: 70 },
    { water: 150, fuel: 65 },
    { water: 160, fuel: 80 }
  ]
  const entry = mockEntries[Math.floor(Math.random() * mockEntries.length)]
  water.value = entry.water
  fuel.value = entry.fuel
  total.value = water.value + fuel.value
  trendData.value = mockEntries.map(e => e.water + e.fuel)
}

watch([water, fuel], () => {
  total.value = water.value + fuel.value
  updateCharts()
})

const updateCharts = () => {
  // Pie Chart
  const pieData = [water.value, fuel.value]
  if (pieInstance) pieInstance.destroy()
  pieInstance = new Chart(pieChart.value, {
    type:'pie',
    data:{ labels:['Water','Fuel'], datasets:[{ data: pieData, backgroundColor:['#3B82F6','#F59E0B'] }] },
    options:{ responsive:true, maintainAspectRatio:false }
  })

  // Trend line
  if(!isMockUser) trendData.value.push(total.value)
  if(trendData.value.length>10) trendData.value.shift()
  if(lineInstance) lineInstance.destroy()
  lineInstance = new Chart(lineChart.value, {
    type:'line',
    data:{ labels:trendData.value.map((_,i)=>`Entry ${i+1}`), datasets:[{ label:'Total Usage', data:trendData.value, borderColor:'#10B981', backgroundColor:'rgba(16,185,129,0.2)'}] },
    options:{ responsive:true, maintainAspectRatio:false }
  })
}

const submitResource = async () => {
  if (isMockUser) {
    alert('This is mock data. No database update.')
    return
  }
  await axios.post('/resources', { water, fuel, total: total.value })
  alert('Resource usage saved!')
}

onMounted(() => {
  if (isMockUser) loadMockData()
  updateCharts()
})
</script>

<style scoped>
.animate-pulse { transition: all 0.3s ease; }
</style>
