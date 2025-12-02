<template>
  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-8 rounded-xl w-96">
      <h3 class="text-2xl font-bold mb-6">Add Supplier</h3>
      <form @submit.prevent="save">
        <input v-model="form.name" placeholder="Name" required class="w-full p-3 border rounded mb-4" />
        <input v-model="form.email" type="email" placeholder="Email" class="w-full p-3 border rounded mb-4" />
        <input v-model="form.phone" placeholder="Phone" class="w-full p-3 border rounded mb-4" />
        <input v-model="form.address" placeholder="Address" class="w-full p-3 border rounded mb-4" />
        <div class="flex gap-4">
          <button type="submit" class="bg-emerald-600 text-white px-6 py-3 rounded">Save</button>
          <button type="button" @click="$emit('close')" class="bg-gray-500 text-white px-6 py-3 rounded">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const form = ref({ name: '', email: '', phone: '', address: '' })
const emit = defineEmits(['close', 'saved'])

const save = async () => {
  await axios.post('/suppliers', form.value)
  emit('saved')
  emit('close')
}
</script>