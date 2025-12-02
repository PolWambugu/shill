<template>
  <div class="bg-white p-8 rounded-xl shadow-lg max-w-3xl mx-auto">
    <h2 class="text-3xl font-bold mb-6 text-emerald-700">Waste Tracking</h2>

    <form @submit.prevent="submitWaste">

      <!-- FORM GRID -->
      <div class="grid md:grid-cols-3 gap-6">

        <!-- PLASTIC -->
        <div>
          <label class="block text-gray-700 font-medium mb-2">
            Plastic Waste (kg)
          </label>
          <input
            v-model.number="plastic"
            type="number"
            class="w-full p-3 border rounded-lg"
            placeholder="Enter kg"
            required
          />
        </div>

        <!-- PAPER -->
        <div>
          <label class="block text-gray-700 font-medium mb-2">
            Paper Waste (kg)
          </label>
          <input
            v-model.number="paper"
            type="number"
            class="w-full p-3 border rounded-lg"
            placeholder="Enter kg"
            required
          />
        </div>

        <!-- ORGANIC -->
        <div>
          <label class="block text-gray-700 font-medium mb-2">
            Organic Waste (kg)
          </label>
          <input
            v-model.number="organic"
            type="number"
            class="w-full p-3 border rounded-lg"
            placeholder="Enter kg"
            required
          />
        </div>

      </div>

      <!-- SUBMIT BUTTON -->
      <button 
        type="submit" 
        class="mt-8 bg-emerald-600 text-white px-10 py-4 rounded-lg hover:bg-emerald-700 text-xl"
      >
        Save Waste Data
      </button>
    </form>

    <!-- SHOW TOTAL AFTER SUBMIT -->
    <div v-if="total" class="mt-8 p-6 bg-emerald-50 rounded-xl">
      <p class="text-2xl font-bold text-emerald-700">
        Total Waste Recorded: {{ total }} kg
      </p>
    </div>

  </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";

const plastic = ref(0);
const paper = ref(0);
const organic = ref(0);
const total = ref(null);

const submitWaste = async () => {
  total.value = plastic.value + paper.value + organic.value;

  await axios.post("/waste", {
    plastic_kg: plastic.value,
    paper_kg: paper.value,
    organic_kg: organic.value,
    total_kg: total.value,
  });

  alert("Waste data saved!");
};
</script>

<style scoped></style>
