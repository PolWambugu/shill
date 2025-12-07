<template>
  <div class="p-6 space-y-10">

    <!-- HEADER -->
    <div>
      <h1 class="text-3xl font-bold text-gray-800">Admin Control Panel</h1>
      <p class="text-gray-600 mt-1">System-wide sustainability oversight</p>
    </div>

    <!-- SUMMARY CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-6 gap-6 mt-6">
      <div class="bg-purple-100 rounded-xl p-6 text-center">
        <h2 class="font-semibold text-gray-700">Total Users</h2>
        <p class="text-3xl font-bold mt-2">{{ totalUsers }}</p>
      </div>
      <div class="bg-indigo-100 rounded-xl p-6 text-center">
        <h2 class="font-semibold text-gray-700">Total Suppliers</h2>
        <p class="text-3xl font-bold mt-2">{{ totalSuppliers }}</p>
      </div>
      <div class="bg-gray-100 rounded-xl p-6 text-center">
        <h2 class="font-semibold text-gray-700">Total Reports</h2>
        <p class="text-3xl font-bold mt-2">{{ totalReports }}</p>
      </div>
      <div class="bg-green-100 rounded-xl p-6 text-center">
        <h2 class="font-semibold text-gray-700">Total CO₂</h2>
        <p class="text-3xl font-bold mt-2">{{ totalCO2 }} tons</p>
      </div>
      <div class="bg-blue-100 rounded-xl p-6 text-center">
        <h2 class="font-semibold text-gray-700">Total Waste</h2>
        <p class="text-3xl font-bold mt-2">{{ totalWaste }} kg</p>
      </div>
      <div class="bg-cyan-100 rounded-xl p-6 text-center">
        <h2 class="font-semibold text-gray-700">Total Water</h2>
        <p class="text-3xl font-bold mt-2">{{ totalWater }} L</p>
      </div>
    </div>

    <!-- TREND CHARTS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
      <div class="bg-white rounded-xl shadow p-6 h-64">
        <h2 class="font-semibold text-gray-700 mb-2">CO₂ Emissions Trend</h2>
        <canvas id="co2Chart"></canvas>
      </div>
      <div class="bg-white rounded-xl shadow p-6 h-64">
        <h2 class="font-semibold text-gray-700 mb-2">Waste Trend</h2>
        <canvas id="wasteChart"></canvas>
      </div>
      <div class="bg-white rounded-xl shadow p-6 h-64">
        <h2 class="font-semibold text-gray-700 mb-2">Water Usage Trend</h2>
        <canvas id="waterChart"></canvas>
      </div>
    </div>

    <!-- USER MANAGEMENT TABLE -->
    <div class="bg-white rounded-xl shadow p-6 mt-6">
      <h2 class="text-xl font-semibold text-gray-700 mb-4">User Management</h2>
      <table class="min-w-full border border-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-2 text-left">Name</th>
            <th class="px-4 py-2 text-left">Email</th>
            <th class="px-4 py-2 text-left">Role</th>
            <th class="px-4 py-2 text-left">Last Report</th>
            <th class="px-4 py-2 text-left">Status</th>
            <th class="px-4 py-2 text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id" class="border-t">
            <td class="px-4 py-2">{{ user.name }}</td>
            <td class="px-4 py-2">{{ user.email }}</td>
            <td class="px-4 py-2">{{ user.role }}</td>
            <td class="px-4 py-2">{{ user.last_report }}</td>
            <td class="px-4 py-2">{{ user.status }}</td>
            <td class="px-4 py-2">
              <button
                class="bg-red-600 text-white px-3 py-1 rounded disabled:opacity-50"
                :disabled="user.status === 'inactive'"
                @click="deactivateUser(user.id)"
              >
                Deactivate
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- SUPPLIERS TABLE -->
    <div class="bg-white rounded-xl shadow p-6 mt-6">
      <h2 class="text-xl font-semibold text-gray-700 mb-4">Supplier Management</h2>
      <table class="min-w-full border border-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-2 text-left">Supplier Name</th>
            <th class="px-4 py-2 text-left">Contact</th>
            <th class="px-4 py-2 text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="supplier in suppliers" :key="supplier.id" class="border-t">
            <td class="px-4 py-2">{{ supplier.name }}</td>
            <td class="px-4 py-2">{{ supplier.contact }}</td>
            <td class="px-4 py-2">
              <button class="bg-red-600 text-white px-3 py-1 rounded" @click="deleteSupplier(supplier.id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- REPORTS TABLE -->
    <div class="bg-white rounded-xl shadow p-6 mt-6">
      <h2 class="text-xl font-semibold text-gray-700 mb-4">Submitted Reports</h2>
      <table class="min-w-full border border-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-2">User</th>
            <th class="px-4 py-2">Type</th>
            <th class="px-4 py-2">CO₂</th>
            <th class="px-4 py-2">Waste</th>
            <th class="px-4 py-2">Water</th>
            <th class="px-4 py-2">Submitted At</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="report in reports" :key="report.id" class="border-t">
            <td class="px-4 py-2">{{ report.user_name }}</td>
            <td class="px-4 py-2">{{ report.type }}</td>
            <td class="px-4 py-2">{{ report.co2 }}</td>
            <td class="px-4 py-2">{{ report.waste }}</td>
            <td class="px-4 py-2">{{ report.water }}</td>
            <td class="px-4 py-2">{{ report.created_at }}</td>
            <td class="px-4 py-2">{{ report.status }}</td>
            <td class="px-4 py-2 space-x-2">
              <button class="bg-green-600 text-white px-2 py-1 rounded" @click="approveReport(report.id)" :disabled="report.status==='approved'">Approve</button>
              <button class="bg-red-600 text-white px-2 py-1 rounded" @click="rejectReport(report.id)" :disabled="report.status==='rejected'">Reject</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import Chart from 'chart.js/auto'

const totalUsers = ref(4)
const totalSuppliers = ref(4)
const totalReports = ref(12)
const totalCO2 = ref(455)
const totalWaste = ref(1700)
const totalWater = ref(6500)

const users = ref([
  { id:1, name:"Mary Wachira", email:"mary@greenfuel.com", role:"user", last_report:"2025-12-05", status:"active" },
  { id:2, name:"John Mwangi", email:"john@ecopaper.com", role:"user", last_report:"2025-12-04", status:"active" },
  { id:3, name:"Fatma Ali", email:"fatma@bluewater.com", role:"user", last_report:"2025-12-03", status:"active" },
  { id:4, name:"Brian Otieno", email:"brian@solartech.com", role:"user", last_report:"2025-12-02", status:"active" },
])

const suppliers = ref([
  { id:1, name:"GreenFuel Logistics", contact:"mary@greenfuel.com | 0712345678" },
  { id:2, name:"EcoPaper Ltd", contact:"john@ecopaper.com | 0722334455" },
  { id:3, name:"BlueWater Corp", contact:"fatma@bluewater.com | 0744556677" },
  { id:4, name:"SolarTech Africa", contact:"brian@solartech.com | 0799887766" },
])

const reports = ref([
  { id:1, user_name:"Mary Wachira", type:"Emission", co2:120, waste:350, water:1500, created_at:"2025-12-05", status:"pending" },
  { id:2, user_name:"Mary Wachira", type:"Waste", co2:0, waste:50, water:0, created_at:"2025-12-05", status:"approved" },
  { id:3, user_name:"Mary Wachira", type:"Water", co2:0, waste:0, water:500, created_at:"2025-12-05", status:"pending" },

  { id:4, user_name:"John Mwangi", type:"Emission", co2:95, waste:400, water:1200, created_at:"2025-12-04", status:"approved" },
  { id:5, user_name:"John Mwangi", type:"Waste", co2:0, waste:70, water:0, created_at:"2025-12-04", status:"pending" },
  { id:6, user_name:"John Mwangi", type:"Water", co2:0, waste:0, water:400, created_at:"2025-12-04", status:"pending" },

  { id:7, user_name:"Fatma Ali", type:"Emission", co2:130, waste:500, water:2000, created_at:"2025-12-03", status:"approved" },
  { id:8, user_name:"Fatma Ali", type:"Waste", co2:0, waste:80, water:0, created_at:"2025-12-03", status:"approved" },
  { id:9, user_name:"Fatma Ali", type:"Water", co2:0, waste:0, water:600, created_at:"2025-12-03", status:"pending" },

  { id:10, user_name:"Brian Otieno", type:"Emission", co2:110, waste:450, water:1800, created_at:"2025-12-02", status:"pending" },
  { id:11, user_name:"Brian Otieno", type:"Waste", co2:0, waste:90, water:0, created_at:"2025-12-02", status:"pending" },
  { id:12, user_name:"Brian Otieno", type:"Water", co2:0, waste:0, water:500, created_at:"2025-12-02", status:"approved" },
])

let co2Chart=null
let wasteChart=null
let waterChart=null

const colors = ['#4CAF50','#2196F3','#FF9800','#9C27B0']

const renderCharts = () => {
  const co2Ctx=document.getElementById('co2Chart')
  const wasteCtx=document.getElementById('wasteChart')
  const waterCtx=document.getElementById('waterChart')

  if(co2Chart) co2Chart.destroy()
  if(wasteChart) wasteChart.destroy()
  if(waterChart) waterChart.destroy()

  // CO2 per user
  co2Chart = new Chart(co2Ctx, {
    type:'line',
    data:{
      labels: reports.value.map(r=>r.created_at).filter((v,i,a)=>a.indexOf(v)===i),
      datasets: users.value.map((u,i)=>({
        label:u.name,
        data: reports.value.filter(r=>r.user_name===u.name).map(r=>r.co2),
        borderColor: colors[i],
        tension:0.4,
      }))
    },
    options:{responsive:true, maintainAspectRatio:false}
  })

  // Waste per user
  wasteChart = new Chart(wasteCtx, {
    type:'line',
    data:{
      labels: reports.value.map(r=>r.created_at).filter((v,i,a)=>a.indexOf(v)===i),
      datasets: users.value.map((u,i)=>({
        label:u.name,
        data: reports.value.filter(r=>r.user_name===u.name).map(r=>r.waste),
        borderColor: colors[i],
        tension:0.4,
      }))
    },
    options:{responsive:true, maintainAspectRatio:false}
  })

  // Water per user
  waterChart = new Chart(waterCtx, {
    type:'line',
    data:{
      labels: reports.value.map(r=>r.created_at).filter((v,i,a)=>a.indexOf(v)===i),
      datasets: users.value.map((u,i)=>({
        label:u.name,
        data: reports.value.filter(r=>r.user_name===u.name).map(r=>r.water),
        borderColor: colors[i],
        tension:0.4,
      }))
    },
    options:{responsive:true, maintainAspectRatio:false}
  })
}

onMounted(()=>{
  renderCharts()
})

const deactivateUser=(id)=>{ users.value = users.value.map(u=>u.id===id?{...u,status:'inactive'}:u) }
const deleteSupplier=(id)=>{ suppliers.value = suppliers.value.filter(s=>s.id!==id) }
const approveReport=(id)=>{ reports.value = reports.value.map(r=>r.id===id?{...r,status:'approved'}:r) }
const rejectReport=(id)=>{ reports.value = reports.value.map(r=>r.id===id?{...r,status:'rejected'}:r) }
</script>

<style scoped>
table { border-collapse: collapse; }
th, td { border: 1px solid #e2e8f0; }
canvas { height: 150px !important; } /* Smaller charts */
</style>
