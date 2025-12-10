<template>
  <div class="bg-white p-8 rounded-xl shadow-lg">
    <h2 class="text-3xl font-bold mb-6 text-emerald-700">Carbon Emissions Calculator</h2>

    <form @submit.prevent="submit" class="space-y-6">
      <div class="grid md:grid-cols-2 gap-6">
        <div>
          <label class="block text-gray-700 font-medium mb-2">Electricity (kWh/month)</label>
          <input v-model.number="form.electricity" type="number" required
                 class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" />
        </div>
        <div>
          <label class="block text-gray-700 font-medium mb-2">Mileage (km/week)</label>
          <input v-model.number="form.mileage" type="number" required
                 class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" />
        </div>
        <div>
          <label class="block text-gray-700 font-medium mb-2">Flights (per year)</label>
          <input v-model.number="form.flights" type="number" required
                 class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" />
        </div>
      </div>

      <!-- Live Result — ONLY ONE (CLEAN & BEAUTIFUL) -->
      <div v-if="total"
           class="mt-8 p-8 rounded-2xl text-center border-4 shadow-xl transition-all duration-500"
           :class="total > 2000 ? 'bg-red-100 border-red-500' : 'bg-emerald-50 border-emerald-500'">
        <p class="text-5xl font-extrabold animate-pulse"
           :class="total > 2000 ? 'text-red-600' : 'text-emerald-700'">
          {{ total.toFixed(2) }} tons CO₂/year
        </p>
        <p v-if="total > 2000" class="text-xl text-red-600 font-bold mt-4">
          High emissions! Try reducing your usage.
        </p>
        <p v-else class="text-xl text-emerald-600 font-bold mt-4">
          Great job! You're on the right track.
        </p>
      </div>

      <button type="submit" :disabled="isSubmitting || total > 2000"
              class="mt-8 w-full bg-emerald-600 hover:bg-emerald-700 disabled:bg-gray-400 text-white py-5 rounded-xl font-bold text-2xl transition shadow-2xl transform hover:scale-105">
        {{ isSubmitting ? 'Saving...' : 'Save Emissions' }}
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref, reactive, computed, watch } from 'vue'
import axios from 'axios'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()

const form = reactive({
  electricity: 0,
  mileage: 0,
  flights: 0
})

const isSubmitting = ref(false)

const total = computed(() => {
  return (
    form.electricity * 12 * 0.0004 +
    form.mileage * 52 * 0.0002 +
    form.flights * 0.5
  )
})

watch(total, () => {
  window.dispatchEvent(new Event('emissions-updated'))
})

const submit = async () => {
  if (total.value > 2000) {
    alert('Emissions too high! Please reduce your usage.')
    return
  }

  isSubmitting.value = true

  try {
    await axios.post('/emissions', {
      electricity_kwh: form.electricity,
      mileage_km: form.mileage,
      flights: form.flights,
      total_co2: total.value
    })

    alert('Emissions saved successfully!')

    // Reset form
    Object.assign(form, { electricity: 0, mileage: 0, flights: 0 })

    // Update dashboard
    window.dispatchEvent(new Event('emissions-updated'))

  } catch (err) {
    alert('Error: ' + (err.response?.data?.message || 'Try again'))
  } finally {
    isSubmitting.value = false
  }
}
</script>