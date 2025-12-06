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
      <canvas ref="pieChart" height="200"></canvas>
    </div>

    <!-- Trend Line Chart -->
    <div class="mt-6">
      <canvas ref="lineChart" height="200"></canvas>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import Chart from 'chart.js/auto'
import axios from 'axios'

const water = ref(0)
const fuel = ref(0)
const total = ref(0)

const pieChart = ref(null)
const lineChart = ref(null)
let pieInstance, lineInstance

const trendData = ref([])

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
    options:{ responsive:true }
  })

  // Trend line
  trendData.value.push(total.value)
  if(trendData.value.length>10) trendData.value.shift()
  if(lineInstance) lineInstance.destroy()
  lineInstance = new Chart(lineChart.value, {
    type:'line',
    data:{ labels:trendData.value.map((_,i)=>`Entry ${i+1}`), datasets:[{ label:'Total Usage', data:trendData.value, borderColor:'#10B981', backgroundColor:'rgba(16,185,129,0.2)'}] },
    options:{ responsive:true }
  })
}

const submitResource = async () => {
  await axios.post('/resources', { water, fuel, total: total.value })
  alert('Resource usage saved!')
}

onMounted(()=>updateCharts())
</script>

<style scoped>
.animate-pulse { transition: all 0.3s ease; }
</style>
