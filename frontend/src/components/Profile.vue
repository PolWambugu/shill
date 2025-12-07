<template>
  <div class="min-h-screen bg-gradient-to-br from-emerald-50 to-teal-50 py-20">
    <div class="max-w-4xl mx-auto px-8">
      <h1 class="text-6xl font-extrabold text-center text-emerald-800 mb-16">My Profile</h1>

      <div class="bg-white rounded-3xl shadow-2xl p-12 border border-emerald-100">
        <div class="flex items-center space-x-8 mb-12">
          <div class="w-32 h-32 bg-emerald-600 rounded-full flex items-center justify-center text-white text-6xl font-bold">
            {{ auth.user?.name.charAt(0) }}
          </div>
          <div>
            <h2 class="text-4xl font-bold text-gray-900">{{ auth.user?.name }}</h2>
            <p class="text-xl text-gray-600">{{ auth.user?.email }}</p>
            <p class="text-lg text-emerald-600 mt-2">
              <!-- {{ auth.user?.email_verified_at ? '✅ Email Verified' : '❌ Email Not Verified' }} -->
            </p>
          </div>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
          <div class="bg-emerald-50 p-8 rounded-2xl">
            <h3 class="text-2xl font-bold text-emerald-800 mb-4">Account Stats</h3>
            <p class="text-lg">Total Emissions Entries: {{ emissionsCount }}</p>
            <p class="text-lg">Waste Entries: {{ wasteCount }}</p>
            <p class="text-lg">Member Since: {{ formatDate(auth.user?.created_at) }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'
import axios from 'axios'

const auth = useAuthStore()
const emissionsCount = ref(0)
const wasteCount = ref(0)

const formatDate = (date) => new Date(date).toLocaleDateString()

onMounted(async () => {
  const [em, wa] = await Promise.all([
    axios.get('/emissions'),
    axios.get('/waste')
  ])
  emissionsCount.value = em.data.length
  wasteCount.value = wa.data.length
})

const logout = () => {
  auth.logout()
}
</script>