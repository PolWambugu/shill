<template>
  <div class="bg-white p-8 rounded-xl shadow-lg grid md:grid-cols-3 gap-10">

    <!-- ====================== LEFT: FORM ====================== -->
    <div class="md:col-span-2">
      <h2 class="text-3xl font-bold mb-6 text-emerald-700">Carbon Emissions Calculator</h2>

      <form @submit.prevent="submit">
        <div class="grid md:grid-cols-2 gap-6">

          <div>
            <label class="block text-gray-700 font-medium mb-2">Electricity (kWh/month)</label>
            <input 
              v-model.number="electricity" 
              type="number" 
              class="w-full p-3 border rounded-lg" 
              required 
            />
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-2">Mileage (km/week)</label>
            <input 
              v-model.number="mileage" 
              type="number" 
              class="w-full p-3 border rounded-lg" 
              required 
            />
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-2">Flights (per year)</label>
            <input 
              v-model.number="flights" 
              type="number" 
              class="w-full p-3 border rounded-lg" 
              required 
            />
          </div>

        </div>

        <button 
          type="submit" 
          class="mt-8 bg-emerald-600 text-white px-10 py-4 rounded-lg hover:bg-emerald-700 text-xl"
        >
          Save Emissions
        </button>
      </form>

      <!-- Result -->
      <div v-if="total" class="mt-8 p-6 bg-emerald-50 rounded-xl">
        <p class="text-3xl font-bold text-emerald-700">
          Your Yearly CO₂: {{ total.toFixed(2) }} tons
        </p>
      </div>
    </div>

    <!-- ====================== RIGHT: EXPLANATION ====================== -->
    <div class="bg-gray-50 p-6 rounded-xl border">
      <h3 class="text-2xl font-bold mb-4 text-gray-800">How We Calculate CO₂</h3>

      <p class="text-gray-700 mb-4">
        Your yearly carbon emissions are estimated using these global emission factors:
      </p>

      <ul class="space-y-4 text-gray-700">

        <li>
          <strong>🟩 Electricity:</strong><br>
          Each <strong>1 kWh</strong> of electricity produces  
          <strong>0.0004 tons of CO₂</strong>.
          <br>
          Formula:<br>
          <code class="text-sm bg-white px-2 py-1 rounded">
            yearly_kWh × 0.0004
          </code>
        </li>

        <li>
          <strong>🟦 Mileage:</strong><br>
          Each <strong>1 km of driving</strong> generates  
          <strong>0.0002 tons of CO₂</strong>.
          <br>
          Formula:<br>
          <code class="text-sm bg-white px-2 py-1 rounded">
            (km_per_week × 52) × 0.0002
          </code>
        </li>

        <li>
          <strong>🟪 Flights:</strong><br>
          Each flight contributes approx  
          <strong>0.5 tons of CO₂</strong>.
          <br>
          Formula:<br>
          <code class="text-sm bg-white px-2 py-1 rounded">
            flights_per_year × 0.5
          </code>
        </li>

      </ul>

      <hr class="my-4">

      <p class="text-lg font-semibold text-emerald-600">
        Full Formula:
      </p>

      <code class="block bg-white p-3 rounded text-sm leading-loose">
        Total CO₂ =  
        (electricity × 12 × 0.0004)  
        + (mileage × 52 × 0.0002)  
        + (flights × 0.5)
      </code>
    </div>

  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const electricity = ref(0)
const mileage = ref(0)
const flights = ref(0)
const total = ref(null)

const submit = async () => {
  const totalCO2 =
    electricity.value * 12 * 0.0004 +
    mileage.value * 52 * 0.0002 +
    flights.value * 0.5

  total.value = totalCO2

  await axios.post('/emissions', {
    electricity_kwh: electricity.value,
    mileage_km: mileage.value,
    flights: flights.value,
    total_co2: totalCO2
  })

  alert('Emissions saved!')
}
</script>

<style scoped>
</style>
