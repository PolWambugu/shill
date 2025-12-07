<template>
  <div class="bg-white p-8 rounded-xl shadow-lg">
    <h2 class="text-3xl font-bold mb-6 text-emerald-700">{{ supplier.name }}</h2>
    <p><strong>Email:</strong> {{ supplier.email }}</p>
    <p><strong>Phone:</strong> {{ supplier.phone }}</p>
    <p><strong>Address:</strong> {{ supplier.address }}</p>
    <button @click="$router.back()" class="mt-6 bg-gray-600 text-white px-6 py-3 rounded">Back</button>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const supplier = ref({})

onMounted(async () => {
  try {
    const token = localStorage.getItem('token')
    const res = await axios.get(`/api/suppliers/${route.params.id}`, {
      headers: { Authorization: `Bearer ${token}` }
    })
    supplier.value = res.data
  } catch (e) {
    console.error(e)
  }
})
</script>
