<template>
  <div class="bg-white p-8 rounded-xl shadow-lg">
    <h2 class="text-3xl font-bold mb-6 text-emerald-700">Suppliers</h2>
    <button @click="showForm = true" class="mb-6 bg-emerald-600 text-white px-6 py-3 rounded">Add Supplier</button>
    <SupplierForm v-if="showForm" @close="showForm = false" @saved="loadSuppliers" />
    <div v-for="s in suppliers" :key="s.id" class="border-b py-4 flex justify-between">
      <div>
        <p class="font-bold">{{ s.name }}</p>
        <p class="text-gray-600">{{ s.email }} | {{ s.phone }}</p>
      </div>
      <button @click="viewSupplier(s)" class="text-emerald-600">View</button>

    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import SupplierForm from './SupplierForm.vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const viewSupplier = (supplier) => {
  // navigate to /supplier/:id
  router.push({ path: `/supplier/${supplier.id}`, state: { supplier } })
}


const suppliers = ref([])
const showForm = ref(false)

const loadSuppliers = async () => {
  const res = await axios.get('/suppliers')
  suppliers.value = res.data
}

onMounted(loadSuppliers)
</script>