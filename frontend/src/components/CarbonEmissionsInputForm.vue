<template>
  <div class="bg-white p-8 rounded-xl shadow-lg grid md:grid-cols-3 gap-10">

    <!-- LEFT: FORM -->
    <div class="md:col-span-2">
      <h2 class="text-3xl font-bold mb-6 text-emerald-700">Carbon Emissions Calculator</h2>

      <form @submit.prevent="submit">
        <div class="grid md:grid-cols-2 gap-6">
          <div>
            <label class="block text-gray-700 font-medium mb-2">Electricity (kWh/month)</label>
            <input v-model.number="electricity" type="number" class="w-full p-3 border rounded-lg" required />
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-2">Mileage (km/week)</label>
            <input v-model.number="mileage" type="number" class="w-full p-3 border rounded-lg" required />
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-2">Flights (per year)</label>
            <input v-model.number="flights" type="number" class="w-full p-3 border rounded-lg" required />
          </div>
        </div>

        <button type="submit" class="mt-8 bg-emerald-600 text-white px-10 py-4 rounded-lg hover:bg-emerald-700 text-xl">
          Save Emissions
        </button>
      </form>

      <!-- LIVE TOTAL -->
      <div v-if="total" class="mt-8 p-6 bg-emerald-50 rounded-xl text-center">
        <p class="text-3xl font-bold text-emerald-700 animate-pulse">
          Your Yearly CO₂: {{ total.toFixed(2) }} tons
        </p>
      </div>

      <!-- CHARTS -->
      <div class="mt-6">
        <canvas ref="barChart" height="200"></canvas>
      </div>

      <div class="mt-6">
        <canvas ref="pieChart" height="200"></canvas>
      </div>
    </div>

    <!-- RIGHT: EXPLANATION -->
    <div class="bg-gray-50 p-6 rounded-xl border">
      <h3 class="text-2xl font-bold mb-4 text-gray-800">How We Calculate CO₂</h3>
      <ul class="space-y-4 text-gray-700">
        <li>🟩 Electricity: 0.0004 tons/kWh → yearly_kWh × 0.0004</li>
        <li>🟦 Mileage: 0.0002 tons/km → km/week × 52 × 0.0002</li>
        <li>🟪 Flights: 0.5 tons/flight → flights/year × 0.5</li>
      </ul>
      <hr class="my-4">
      <p class="text-lg font-semibold text-emerald-600">Full Formula:</p>
      <code class="block bg-white p-3 rounded text-sm leading-loose">
        Total CO₂ = (electricity × 12 × 0.0004) + (mileage × 52 × 0.0002) + (flights × 0.5)
      </code>
    </div>

  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import Chart from 'chart.js/auto'
import axios from 'axios'

const electricity = ref(0)
const mileage = ref(0)
const flights = ref(0)
const total = ref(0)

const barChart = ref(null)
const pieChart = ref(null)
let barInstance, pieInstance

const computeTotal = () => {
  total.value = electricity.value * 12 * 0.0004 +
                mileage.value * 52 * 0.0002 +
                flights.value * 0.5
}

watch([electricity, mileage, flights], () => {
  computeTotal()
  updateCharts()
})

const updateCharts = () => {
  const data = [
    electricity.value * 12 * 0.0004,
    mileage.value * 52 * 0.0002,
    flights.value * 0.5
  ]
  if (barInstance) barInstance.destroy()
  if (pieInstance) pieInstance.destroy()

  barInstance = new Chart(barChart.value, {
    type: 'bar',
    data: { labels: ['Electricity','Mileage','Flights'], datasets:[{ label:'CO₂ (tons)', data, backgroundColor:['#10B981','#3B82F6','#8B5CF6'] }] },
    options: { responsive:true, plugins:{ legend:{ display:false } } }
  })

  pieInstance = new Chart(pieChart.value, {
    type: 'pie',
    data: { labels:['Electricity','Mileage','Flights'], datasets:[{ data, backgroundColor:['#10B981','#3B82F6','#8B5CF6'] }] },
    options:{ responsive:true }
  })
}

const submit = async () => {
  await axios.post('/emissions', {
    electricity_kwh: electricity.value,
    mileage_km: mileage.value,
    flights: flights.value,
    total_co2: total.value
  })
  alert('Emissions saved!')
}

onMounted(() => updateCharts())
</script>

<style scoped>
.animate-pulse { transition: all 0.3s ease; }
</style>
