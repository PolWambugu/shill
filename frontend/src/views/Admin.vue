<template>
  <div class="p-6 space-y-10">

    <!-- HEADER -->
    <div>
      <h1 class="text-3xl font-bold text-gray-800">Admin Control Panel</h1>
      <p class="text-gray-600 mt-1">System-wide sustainability oversight</p>
    </div>

    <!-- SUMMARY CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
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
    </div>

    <!-- CHARTS -->
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

    <!-- USERS TABLE -->
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
            <td class="px-4 py-2">{{ user.last_report || '-' }}</td>
            <td class="px-4 py-2">{{ user.status || 'active' }}</td>
            <td class="px-4 py-2">
              <div class="flex gap-2">
                <button class="bg-red-600 text-white px-3 py-1 rounded"
                        :disabled="user.status === 'inactive'"
                        @click="deactivateUser(user.id)">
                  Deactivate
                </button>
                <button class="bg-green-600 text-white px-3 py-1 rounded"
                        :disabled="user.status === 'active'"
                        @click="activateUser(user.id)">
                  Activate
                </button>
              </div>
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
            <td class="px-4 py-2">{{ supplier.phone || supplier.contact_person || '-' }}</td>
            <td class="px-4 py-2">
              <button class="bg-red-600 text-white px-3 py-1 rounded"
                      @click="deleteSupplier(supplier.id)">
                Delete
              </button>
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
              <button class="bg-green-600 text-white px-2 py-1 rounded"
                      @click="approveReport(report.id)"
                      :disabled="report.status === 'approved'">Approve</button>
              <button class="bg-red-600 text-white px-2 py-1 rounded"
                      @click="rejectReport(report.id)"
                      :disabled="report.status === 'rejected'">Reject</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import Chart from 'chart.js/auto'
import { useAuthStore } from '@/stores/auth'

axios.defaults.baseURL = 'http://127.0.0.1:8000/api'

const auth = useAuthStore()

// Totals
const totalUsers = ref(0)
const totalSuppliers = ref(0)
const totalReports = ref(0)
const totalCO2 = ref(0)
const totalWaste = ref(0)
const totalWater = ref(0)

// Data
const users = ref([])
const suppliers = ref([])
const reports = ref([])

// Charts
let co2Chart = null
let wasteChart = null
let waterChart = null
const colors = ['#4CAF50', '#FF9800', '#2196F3', '#9C27B0', '#FF5722']

// Render charts
const renderCharts = () => {
  const co2Ctx = document.getElementById('co2Chart')
  const wasteCtx = document.getElementById('wasteChart')
  const waterCtx = document.getElementById('waterChart')
  if (!co2Ctx || !wasteCtx || !waterCtx) return

  if (co2Chart) co2Chart.destroy()
  if (wasteChart) wasteChart.destroy()
  if (waterChart) waterChart.destroy()

  const uniqueDates = [...new Set(reports.value.map(r => r.created_at?.split('T')[0]))].sort()

  const datasetFromUsers = key => users.value.map((u, i) => {
    const data = uniqueDates.map(date =>
      reports.value
        .filter(r => r.user_name === u.name && r.created_at?.startsWith(date))
        .reduce((sum, r) => sum + (r[key] || 0), 0)
    )
    return {
      label: u.name,
      data,
      borderColor: colors[i % colors.length],
      backgroundColor: colors[i % colors.length] + '33',
      tension: 0.4,
      fill: true,
      pointRadius: 4
    }
  })

  co2Chart = new Chart(co2Ctx, {
    type: 'line',
    data: { labels: uniqueDates, datasets: datasetFromUsers('co2') },
    options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
  })
  wasteChart = new Chart(wasteCtx, {
    type: 'line',
    data: { labels: uniqueDates, datasets: datasetFromUsers('waste') },
    options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
  })
  waterChart = new Chart(waterCtx, {
    type: 'line',
    data: { labels: uniqueDates, datasets: datasetFromUsers('water') },
    options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
  })
}

// Load data
const loadData = async () => {
  try {
    const headers = { Authorization: `Bearer ${auth.token}` }
    const [uRes, sRes, rRes] = await Promise.all([
      axios.get('/users', { headers }),
      axios.get('/suppliers', { headers }),
      axios.get('/reports', { headers })
    ])

    // users with last report
    users.value = (uRes.data.data || uRes.data || []).map(u => {
      const userReports = rRes.data.reports.filter(r => r.user_id === u.id)
      return { ...u, last_report: userReports.length ? userReports[userReports.length-1].created_at : null }
    })

    suppliers.value = sRes.data.data || sRes.data || []
    reports.value = rRes.data.reports || []

    totalUsers.value = users.value.length
    totalSuppliers.value = suppliers.value.length
    totalReports.value = reports.value.length
    totalCO2.value = reports.value.reduce((a, r) => a + (r.co2 || 0), 0)
    totalWaste.value = reports.value.reduce((a, r) => a + (r.waste || 0), 0)
    totalWater.value = reports.value.reduce((a, r) => a + (r.water || 0), 0)

    renderCharts()
  } catch (err) {
    console.error(err)
  }
}

onMounted(() => loadData())

// Actions
const deactivateUser = async id => {
  try {
    const headers = { Authorization: `Bearer ${auth.token}` }
    const res = await axios.patch(`/users/${id}/deactivate`, {}, { headers })
    users.value = users.value.map(u => u.id === id ? { ...u, status: res.data.status } : u)
  } catch (err) { console.error(err) }
}

const activateUser = async id => {
  try {
    const headers = { Authorization: `Bearer ${auth.token}` }
    const res = await axios.patch(`/users/${id}/activate`, {}, { headers })
    users.value = users.value.map(u => u.id === id ? { ...u, status: res.data.status } : u)
  } catch (err) { console.error(err) }
}

const deleteSupplier = async id => {
  try {
    const headers = { Authorization: `Bearer ${auth.token}` }
    await axios.delete(`/suppliers/${id}`, { headers })
    suppliers.value = suppliers.value.filter(s => s.id !== id)
  } catch (err) { console.error(err) }
}

const approveReport = id => { reports.value = reports.value.map(r => r.id === id ? { ...r, status: 'approved' } : r) }
const rejectReport = id => { reports.value = reports.value.map(r => r.id === id ? { ...r, status: 'rejected' } : r) }
</script>

<style scoped>
table { border-collapse: collapse; }
th, td { border: 1px solid #e2e8f0; }
canvas { height: 150px !important; }
</style>
