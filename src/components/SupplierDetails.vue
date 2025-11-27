<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const supplier = ref(null)

onMounted(() => {
    const stored = JSON.parse(localStorage.getItem("suppliers")) || []
    supplier.value = stored.find(s => s.id == route.params.id)
})
</script>

<template>
    <v-container class="mt-6">
        <h1 class="text-h4 font-weight-bold">Supplier Details</h1>

        <v-card class="pa-6 mt-4" v-if="supplier">
            <h2 class="text-h5">{{ supplier.name }}</h2>

            <p class="mt-2"><strong>Location:</strong> {{ supplier.location }}</p>
            <p class="mt-2"><strong>Sustainability Score:</strong> {{ supplier.rating }}%</p>

            <v-btn color="deep-purple" class="mt-4" :to="`/supplier/${supplier.id}/edit`">
                Edit Supplier
            </v-btn>
        </v-card>
    </v-container>
</template>
