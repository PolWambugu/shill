<template>
  <div class="bg-white p-8 rounded-xl shadow-lg max-w-4xl mx-auto">
    <h2 class="text-4xl font-bold mb-8 text-center text-cyan-700">Resource Usage</h2>

    <form @submit.prevent="saveResources" class="grid md:grid-cols-2 gap-8">
      <div>
        <label class="block text-lg font-medium mb-2">Water Used (Liters)</label>
        <input v-model.number="form.water_liters" type="number" step="0.01" required
               class="w-full p-4 p-4 border-2 rounded-xl focus:border-cyan-500" placeholder="e.g. 1500" />
      </div>
      <div>
        <label class="block text-lg font-medium mb-2">Fuel Used (Liters)</label>
        <input v-model.number="form.fuel_liters" type="number" step="0.01" required
               class="w-full p-4 border-2 rounded-xl focus:border-orange-500" placeholder="e.g. 80" />
      </div>

      <div class="col-span-2 p-6 bg-gradient-to-r from-cyan-50 to-orange-50 rounded-xl text-center">
        <p class="text-5xl font-bold">Total: {{ total.toFixed(2) }} L</p>
      </div>

      <button type="submit" :disabled="isSubmitting"
              class="col-span-2 bg-gradient-to-r from-cyan-600 to-orange-600 hover:from-cyan-700 hover:to-orange-700 text-white py-5 rounded-xl text-2xl font-bold shadow-xl">
        {{ isSubmitting ? 'Saving...' : 'Save Resource Data' }}
      </button>
    </form>

    <canvas ref="chartRef" class="mt-10 mx-auto h-96"></canvas>
  </div>
</template>

<script setup>
import { reactive, computed, ref, watch, onMounted, nextTick } from 'vue'
import axios from 'axios'
import Chart from 'chart.js/auto'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const isSubmitting = ref(false)

const form = reactive({
  water_liters: 0,
  fuel_liters: 0
})

const total = computed(() => form.water_liters + form.fuel_liters)

let chart = null
const chartRef = ref(null)

const saveResources = async () => {
  if (total.value === 0) return alert('Enter values first')

  isSubmitting.value = true

  try {
    await axios.post('http://127.0.0.1:8000/api/resources', form, {
      headers: {
        'Authorization': `Bearer ${auth.token}`,
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      }
    })

    alert('Resources saved successfully!')
    form.water_liters = form.fuel_liters = 0
    window.dispatchEvent(new Event('resources-updated'))

  } catch (err) {
    console.error('Save error:', err.response || err)
    alert('Save failed — open browser console (F12) and tell me the exact error')
  } finally {
    isSubmitting.value = false
  }
}

const renderChart = async () => {
  await nextTick()
  if (!chartRef.value) return

  if (chart) chart.destroy()

  chart = new Chart(chartRef.value, {
    type: 'doughnut',
    data: {
      labels: ['Water', 'Fuel'],
      datasets: [{
        data: [form.water_liters || 1, form.fuel_liters || 1],
        backgroundColor: ['#06B6D4', '#F97316'],
        borderWidth: 4,
        borderColor: '#fff'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false
    }
  })
}

watch(() => [form.water_liters, form.fuel_liters], renderChart)
onMounted(renderChart)
</script>