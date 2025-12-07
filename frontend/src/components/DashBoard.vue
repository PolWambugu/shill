<template>
  <div class="p-6 space-y-10">

    <!-- FILTER BUTTONS -->
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

    <!-- SUMMARY CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white rounded-xl shadow p-6 text-center">
        <h2 class="text-lg font-semibold text-gray-700">My CO₂</h2>
        <p class="text-5xl font-bold text-emerald-500 mt-2">
          {{ totalCO2 }} <span class="text-2xl">tons</span>
        </p>
      </div>

      <div class="bg-white rounded-xl shadow p-6 text-center">
        <h2 class="text-lg font-semibold text-gray-700">My Waste</h2>
        <p class="text-5xl font-bold text-blue-400 mt-2">
          {{ totalWaste }} <span class="text-2xl">kg</span>
        </p>
      </div>

      <div class="bg-white rounded-xl shadow p-6 text-center">
        <h2 class="text-lg font-semibold text-gray-700">My Water</h2>
        <p class="text-5xl font-bold text-cyan-400 mt-2">
          {{ totalWater }} <span class="text-2xl">L</span>
        </p>
      </div>
    </div>

    <!-- USER CHARTS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">My CO₂ Emissions Chart</h2>
        <div class="h-48">
          <canvas id="co2Chart"></canvas>
        </div>
      </div>
      <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">My Waste Chart</h2>
        <div class="h-48">
          <canvas id="wasteChart"></canvas>
        </div>
      </div>
      <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">My Water Usage Chart</h2>
        <div class="h-48">
          <canvas id="waterChart"></canvas>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
import { ref, watch, onMounted } from "vue";
import Chart from "chart.js/auto";

// STATE
const totalCO2 = ref(0);
const totalWaste = ref(0);
const totalWater = ref(0);
const filter = ref("monthly");

const filters = [
  { label: "Daily", value: "daily" },
  { label: "Weekly", value: "weekly" },
  { label: "Monthly", value: "monthly" },
  { label: "Yearly", value: "yearly" },
];

let co2Chart = null;
let wasteChart = null;
let waterChart = null;


// MOCK DATA FOR PRESENTATION USERS (with filters)
const mockUsers = [
  {
    email: "mary@greenfuel.com",
    data: {
      daily: { co2: 1, waste: 3, water: 8, chartData: [{label:'Mon',value:1},{label:'Tue',value:2},{label:'Wed',value:1},{label:'Thu',value:3},{label:'Fri',value:2}] },
      weekly: { co2: 5, waste: 15, water: 40, chartData: [{label:'Week 1',value:5},{label:'Week 2',value:7},{label:'Week 3',value:4},{label:'Week 4',value:6}] },
      monthly: { co2: 15, waste: 50, water: 120, chartData: [{label:'Jan',value:2},{label:'Feb',value:3},{label:'Mar',value:1},{label:'Apr',value:4}] },
      yearly: { co2: 180, waste: 600, water: 1440, chartData: [{label:'2022',value:30},{label:'2023',value:40},{label:'2024',value:50},{label:'2025',value:60}] },
    }
  },
  {
    email: "john@ecopaper.com",
    data: {
      daily: { co2: 2, waste: 4, water: 10, chartData: [{label:'Mon',value:2},{label:'Tue',value:1},{label:'Wed',value:3},{label:'Thu',value:2},{label:'Fri',value:1}] },
      weekly: { co2: 10, waste: 28, water: 60, chartData: [{label:'Week 1',value:6},{label:'Week 2',value:4},{label:'Week 3',value:8},{label:'Week 4',value:10}] },
      monthly: { co2: 25, waste: 70, water: 180, chartData: [{label:'Jan',value:5},{label:'Feb',value:3},{label:'Mar',value:6},{label:'Apr',value:11}] },
      yearly: { co2: 300, waste: 840, water: 2160, chartData: [{label:'2022',value:60},{label:'2023',value:70},{label:'2024',value:80},{label:'2025',value:90}] },
    }
  }
];

// FETCH USER DASHBOARD DATA
const fetchUserDashboard = async () => {
  const token = localStorage.getItem("token");
  const user = JSON.parse(localStorage.getItem("user"));
  if (!token || !user) return;

  // CHECK IF MOCK USER
  const mockUser = mockUsers.find(u => u.email === user.email);
  if (mockUser) {
    const filteredData = mockUser.data[filter.value]; // <- respond to selected filter
    totalCO2.value = filteredData.co2;
    totalWaste.value = filteredData.waste;
    totalWater.value = filteredData.water;
    renderChart(filteredData.chartData);
  } else {
    // REAL USER - fetch from API
    try {
      const res = await fetch(`http://localhost:8000/api/dashboard/user?filter=${filter.value}`, {
        headers: { Authorization: `Bearer ${token}` }
      });
      const data = await res.json();
      totalCO2.value = data.co2;
      totalWaste.value = data.waste;
      totalWater.value = data.water;
      renderChart(data.chartData);
    } catch (err) {
      console.error("Failed to fetch user dashboard data", err);
    }
  }
};

// RENDER CHART
const renderChart = (chartData) => {
  const co2Ctx = document.getElementById("co2Chart");
  const wasteCtx = document.getElementById("wasteChart");
  const waterCtx = document.getElementById("waterChart");

  if (co2Chart) co2Chart.destroy();
  if (wasteChart) wasteChart.destroy();
  if (waterChart) waterChart.destroy();

  co2Chart = new Chart(co2Ctx, {
    type: "line",
    data: {
      labels: chartData.map(i => i.label),
      datasets: [{
        label: "CO₂ Emissions",
        data: chartData.map(i => i.value),
        borderColor: "rgba(16, 185, 129, 0.9)",
        backgroundColor: "rgba(16, 185, 129, 0.2)",
        borderWidth: 3,
        tension: 0.4,
      }],
    },
    options: { responsive: true, maintainAspectRatio: false }
  });

  // reuse same data for waste and water charts as mock (scaled)
  wasteChart = new Chart(wasteCtx, {
    type: "line",
    data: {
      labels: chartData.map(i => i.label),
      datasets: [{
        label: "Waste",
        data: chartData.map(i => i.value * 3),
        borderColor: "rgba(59, 130, 246, 0.9)",
        backgroundColor: "rgba(59, 130, 246, 0.2)",
        borderWidth: 3,
        tension: 0.4,
      }]
    },
    options: { responsive: true, maintainAspectRatio: false }
  });

  waterChart = new Chart(waterCtx, {
    type: "line",
    data: {
      labels: chartData.map(i => i.label),
      datasets: [{
        label: "Water Usage",
        data: chartData.map(i => i.value * 10),
        borderColor: "rgba(0, 188, 212, 0.9)",
        backgroundColor: "rgba(0, 188, 212, 0.2)",
        borderWidth: 3,
        tension: 0.4,
      }]
    },
    options: { responsive: true, maintainAspectRatio: false }
  });
};

// SET FILTER
const setFilter = (value) => filter.value = value;

// WATCH FILTER CHANGES
watch(filter, fetchUserDashboard);

// ON MOUNT
onMounted(fetchUserDashboard);
</script>

<style scoped>
canvas {
  width: 100% !important;
  height: 100% !important;
}
</style>
