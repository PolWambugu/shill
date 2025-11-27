<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRouter } from "vue-router";
import axios from 'axios';

const router = useRouter()


const emissions = ref([])
const waste = ref([])
const resources = ref([])
const loading = ref(true)


const totalEmissions = computed(() => emissions.value.reduce((sum, e) => sum + (e.emissionKg || 0), 0))
const totalWaste = computed(() => waste.value.reduce((sum, w) => sum + (w.weightKg || 0), 0))
const totalResources = computed(() => resources.value.reduce((sum, r) => sum + (r.amount || 0), 0))


async function loadData() {
    loading.value = true
    try {
        const [eRes, wRes, rRes] = await Promise.all([
            axios.get('/emissions').catch(() => ({ data: [] })),
            axios.get('/waste').catch(() => ({ data: [] })),
            axios.get('/resources').catch(() => ({ data: [] }))
        ])
        emissions.value = eRes.data
        waste.value = wRes.data
        resources.value = rRes.data
    } catch (err) {
        console.error(err)
    } finally {
        loading.value = false
    }
}


function goTo(page) {
    router.push(page)
}


onMounted(() => {
    loadData()
})
</script>

<template>
    <v-container>
        <v-row>
            <v-col cols="12">
                <v-card class="pa-4">
                    <h2>Dashboard</h2>
                </v-card>
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="12" md="4">
                <v-card class="pa-4" color="deep-purple lighten-4">
                    <h4>Carbon Emissions</h4>
                    <p class="text-h5">{{ totalEmissions.toFixed(2) }} kg CO₂e</p>
                </v-card>
            </v-col>
            <v-col cols="12" md="4">
                <v-card class="pa-4" color="green lighten-4">
                    <h4>Waste</h4>
                    <p class="text-h5">{{ totalWaste.toFixed(2) }} kg</p>
                </v-card>
            </v-col>
            <v-col cols="12" md="4">
                <v-card class="pa-4" color="blue lighten-4">
                    <h4>Resources</h4>
                    <p class="text-h5">{{ totalResources.toFixed(2) }}</p>
                </v-card>
            </v-col>
        </v-row>

        <v-row class="mt-4">
            <v-col cols="12" md="3">
                <v-btn color="purple" class="white--text" block @click="goTo('/suppliers')">Manage Suppliers</v-btn>
            </v-col>
            <v-col cols="12" md="3">
                <v-btn color="green" class="white--text" block @click="goTo('/tracking/carbon/input')">Record Emission</v-btn>
            </v-col>
            <v-col cols="12" md="3">
                <v-btn color="blue" class="white--text" block @click="goTo('/tracking/waste/input')">Record Waste</v-btn>
            </v-col>
            <v-col cols="12" md="3">
                <v-btn color="indigo" class="white--text" block @click="goTo('/reports')">Reports & Insights</v-btn>
            </v-col>
        </v-row>

        <v-row v-if="loading" class="mt-4">
            <v-col cols="12">
                <v-progress-linear indeterminate color="purple"></v-progress-linear>
            </v-col>
        </v-row>
    </v-container>
</template>
