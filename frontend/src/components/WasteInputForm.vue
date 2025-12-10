<template>
  <div class="bg-white p-8 rounded-xl shadow-lg max-w-3xl mx-auto">
    <h2 class="text-3xl font-bold mb-6 text-blue-700">Waste Tracking</h2>

    <form @submit.prevent="submitWaste" class="grid md:grid-cols-3 gap-6">
      <div>
        <label class="block text-gray-700 font-medium mb-2">Plastic Waste (tons)</label>
        <input 
          v-model.number="form.plastic_kg" 
          type="number" 
          step="0.01"
          class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" 
          placeholder="e.g. 1.5" 
          required 
        />
      </div>
      <div>
        <label class="block text-gray-700 font-medium mb-2">Paper Waste (tons)</label>
        <input 
          v-model.number="form.paper_kg" 
          type="number" 
          step="0.01"
          class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" 
          placeholder="e.g. 0.8" 
          required 
        />
      </div>
      <div>
        <label class="block text-gray-700 font-medium mb-2">Organic Waste (tons)</label>
        <input 
          v-model.number="form.organic_kg" 
          type="number" 
          step="0.01"
          class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" 
          placeholder="e.g. 2.3" 
          required 
        />
      </div>

      <!-- Live Total -->
      <div class="col-span-full p-6 bg-blue-50 rounded-xl text-center border-2 border-blue-200">
        <p class="text-4xl font-bold text-blue-700">
          Total Waste: {{ total.toFixed(2) }} tons
        </p>
      </div>

      <button 
        type="submit" 
        :disabled="isSubmitting"
        class="col-span-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white py-5 rounded-xl font-bold text-2xl transition shadow-xl"
      >
        {{ isSubmitting ? 'Saving...' : 'Save Waste Data' }}
      </button>
    </form>

    <!-- Beautiful Pie Chart
    <div class="mt-10 bg-gray-50 p-6 rounded-xl">
      <h3 class="text-xl font-semibold mb-4 text-center text-gray-700">Waste Breakdown</h3>
      <canvas ref="pieChart" class="mx-auto h-80"></canvas>
    </div> -->
  </div>
</template>

<script setup>
import { reactive, computed } from 'vue'
import axios from 'axios'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()

const form = reactive({
  plastic_kg: 0,
  paper_kg: 0,
  organic_kg: 0
})

const total = computed(() => 
  form.plastic_kg + form.paper_kg + form.organic_kg
)

const submitWaste = async () => {
  try {
    await axios.post('http://127.0.0.1:8000/api/wastes', form, {
      headers: {
        'Authorization': `Bearer ${auth.token}`,
        'Accept': 'application/json'
      }
    })

    alert('Waste saved successfully!')
    form.plastic_kg = form.paper_kg = form.organic_kg = 0
    window.dispatchEvent(new Event('waste-updated'))

  } catch (err) {
    console.error(err)
    alert('Error: ' + (err.response?.data?.message || 'Try again'))
  }
}
</script>

<style scoped>
input:focus { outline: none; }
</style>