<template>
  <div class="bg-white p-8 rounded-xl shadow-lg max-w-3xl mx-auto">
    <h2 class="text-3xl font-bold mb-6 text-emerald-700">Waste Tracking</h2>

    <form @submit.prevent="submitWaste" class="grid md:grid-cols-3 gap-6">
      <div>
        <label class="block text-gray-700 font-medium mb-2">Plastic Waste (kg)</label>
        <input v-model.number="plastic" type="number" class="w-full p-3 border rounded-lg" placeholder="Enter kg" required />
      </div>
      <div>
        <label class="block text-gray-700 font-medium mb-2">Paper Waste (kg)</label>
        <input v-model.number="paper" type="number" class="w-full p-3 border rounded-lg" placeholder="Enter kg" required />
      </div>
      <div>
        <label class="block text-gray-700 font-medium mb-2">Organic Waste (kg)</label>
        <input v-model.number="organic" type="number" class="w-full p-3 border rounded-lg" placeholder="Enter kg" required />
      </div>

      <button type="submit" class="mt-8 bg-emerald-600 text-white px-10 py-4 rounded-lg hover:bg-emerald-700 text-xl col-span-full">
        Save Waste Data
      </button>
    </form>

    <div v-if="total" class="mt-8 p-6 bg-emerald-50 rounded-xl text-center">
      <p class="text-2xl font-bold text-emerald-700 animate-pulse">Total Waste: {{ total }} kg</p>
    </div>

    <!-- Pie Chart -->
    <div class="mt-6">
      <canvas ref="pieChart" height="150"></canvas>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import Chart from 'chart.js/auto'
import axios from 'axios'

// Detect mock users
const currentUser = JSON.parse(localStorage.getItem('user')) || {}
const isMockUser = ['mary@greenfuel.com','john@ecopaper.com','fatma@bluewater.com','brian@solartech.com'].includes(currentUser.email)

const plastic = ref(0)
const paper = ref(0)
const organic = ref(0)
const total = ref(0)

const pieChart = ref(null)
let pieInstance

// For mock users, preload some values
if (isMockUser) {
  plastic.value = 5
  paper.value = 3
  organic.value = 7
  total.value = plastic.value + paper.value + organic.value
}

watch([plastic, paper, organic], () => {
  total.value = plastic.value + paper.value + organic.value
  updateChart()
})

const updateChart = () => {
  const data = [plastic.value, paper.value, organic.value]
  if (pieInstance) pieInstance.destroy()
  pieInstance = new Chart(pieChart.value, {
    type: 'pie',
    data: { labels:['Plastic','Paper','Organic'], datasets:[{ data, backgroundColor:['#F97316','#3B82F6','#10B981'] }] },
    options:{ responsive:true }
  })
}

const submitWaste = async () => {
  if (isMockUser) {
    alert('Mock data saved!')
    return
  }
  try {
    await axios.post('/waste', { plastic, paper, organic, total: total.value })
    alert('Waste data saved!')
  } catch (err) {
    console.error('Failed to save waste data', err)
  }
}

onMounted(() => updateChart())
</script>

<style scoped>
.animate-pulse { transition: all 0.3s ease; }
</style>
