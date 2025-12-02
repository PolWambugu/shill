<template>
  <div class="bg-white p-8 rounded-xl shadow-lg max-w-3xl mx-auto">
    <h2 class="text-3xl font-bold mb-6 text-emerald-700">Resource Usage</h2>

    <form @submit.prevent="submitResource">

      <!-- FORM GRID -->
      <div class="grid md:grid-cols-2 gap-6">

        <!-- WATER -->
        <div>
          <label class="block text-gray-700 font-medium mb-2">
            Water Used (Liters)
          </label>
          <input
            v-model.number="water"
            type="number"
            class="w-full p-3 border rounded-lg"
            placeholder="Enter liters"
            required
          />
        </div>

        <!-- FUEL -->
        <div>
          <label class="block text-gray-700 font-medium mb-2">
            Fuel Used (Liters)
          </label>
          <input
            v-model.number="fuel"
            type="number"
            class="w-full p-3 border rounded-lg"
            placeholder="Enter liters"
            required
          />
        </div>

      </div>

      <!-- SAVE BUTTON -->
      <button 
        type="submit" 
        class="mt-8 bg-emerald-600 text-white px-10 py-4 rounded-lg hover:bg-emerald-700 text-xl"
      >
        Save Resource Data
      </button>
    </form>

    <!-- SHOW TOTAL -->
    <div v-if="total" class="mt-8 p-6 bg-emerald-50 rounded-xl">
      <p class="text-2xl font-bold text-emerald-700">
        Total Resources Used: {{ total }} units
      </p>
      <p class="text-gray-600">*(Water + Fuel combined)*</p>
    </div>

  </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";

// Inputs
const water = ref(0);
const fuel = ref(0);

// Total
const total = ref(null);

const submitResource = async () => {
  total.value = water.value + fuel.value;

  await axios.post("/resources", {
    water_liters: water.value,
    fuel_liters: fuel.value,
    total_usage: total.value,
  });

  alert("Resource usage saved!");
};
</script>

<style scoped></style>
