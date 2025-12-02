<template>
  <div class="p-6 space-y-10">
    
    <!-- ===== FILTER BUTTONS ===== -->
    <div class="flex gap-4">
      <button 
        v-for="f in filters" 
        :key="f.value"
        @click="setFilter(f.value)"
        :class="[
          'px-4 py-2 rounded-lg font-semibold',
          filter === f.value 
            ? 'bg-emerald-500 text-white' 
            : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
        ]"
      >
        {{ f.label }}
      </button>
    </div>

    <!-- ===== SUMMARY CARDS ===== -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
      
      <div class="bg-white rounded-xl shadow p-6 text-center">
        <h2 class="text-lg font-semibold text-gray-700">Total CO₂</h2>
        <p class="text-5xl font-bold text-emerald-500 mt-2">
          {{ totalCO2 }} <span class="text-2xl">tons</span>
        </p>
      </div>

      <div class="bg-white rounded-xl shadow p-6 text-center">
        <h2 class="text-lg font-semibold text-gray-700">Waste Tracked</h2>
        <p class="text-5xl font-bold text-blue-400 mt-2">
          {{ totalWaste }} <span class="text-2xl">kg</span>
        </p>
      </div>

      <div class="bg-white rounded-xl shadow p-6 text-center">
        <h2 class="text-lg font-semibold text-gray-700">Water Used</h2>
        <p class="text-5xl font-bold text-cyan-400 mt-2">
          {{ totalWater }} <span class="text-2xl">L</span>
        </p>
      </div>

      <div class="bg-white rounded-xl shadow p-6 text-center">
        <h2 class="text-lg font-semibold text-gray-700">Suppliers</h2>
        <p class="text-5xl font-bold text-purple-400 mt-2">
          {{ totalSuppliers }}
        </p>
      </div>

    </div>

    <!-- ===== CHART ===== -->
    <div class="bg-white rounded-xl shadow p-6">
      <h2 class="text-xl font-semibold mb-4 text-gray-700">CO₂ Emissions Chart</h2>
      <canvas id="co2Chart"></canvas>
    </div>

  </div>
</template>

<script setup>
import { ref, watch, onMounted } from "vue";
import Chart from "chart.js/auto";

// State
const totalCO2 = ref(0);
const totalWaste = ref(0);
const totalWater = ref(0);
const totalSuppliers = ref(0);
const filter = ref("monthly");

const filters = [
  { label: "Daily", value: "daily" },
  { label: "Weekly", value: "weekly" },
  { label: "Monthly", value: "monthly" },
  { label: "Yearly", value: "yearly" },
];

let chartInstance = null;

// Fetch reports from backend
const fetchReports = async () => {
  try {
    const res = await fetch(`http://localhost:8000/api/dashboard/mock?filter=${filter.value}`, {
      headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
    });

    const data = await res.json();

    // Assign totals
    totalCO2.value = data.co2;
    totalWaste.value = data.waste;
    totalWater.value = data.water;
    totalSuppliers.value = data.suppliers;

    // Render chart
    renderChart(data.chart);
  } catch (err) {
    console.error("Dashboard error:", err);
  }
};

const renderChart = (chartData) => {
  const ctx = document.getElementById("co2Chart");

  if (chartInstance) {
    chartInstance.destroy();
  }

  chartInstance = new Chart(ctx, {
    type: "line",
    data: {
      labels: chartData.map(i => i.label),
      datasets: [
        {
          label: "CO₂ Emissions",
          data: chartData.map(i => i.value),
          borderColor: "rgba(16, 185, 129, 0.9)",
          backgroundColor: "rgba(16, 185, 129, 0.2)",
          borderWidth: 3,
          tension: 0.4,
        },
      ],
    },
    options: {
      responsive: true,
      scales: {
        y: {
          title: {
            display: true,
            text: "Tons of CO₂",
          },
          beginAtZero: true,
        },
        x: {
          title: {
            display: true,
            text: `${filter.value.toUpperCase()} INTERVAL`,
          },
        },
      },
    },
  });
};

const setFilter = (value) => (filter.value = value);

watch(filter, fetchReports);
onMounted(fetchReports);
</script>

<style scoped></style>
