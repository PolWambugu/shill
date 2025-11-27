<script setup>
import { ref, onMounted } from 'vue'

const totalUsers = ref(0)
const totalSuppliers = ref(0)
const totalReports = ref(0)
const systemStatus = ref("Operational")

// Simulated load (replace with your Laravel API later)
onMounted(() => {
    totalUsers.value = 35
    totalSuppliers.value = 12
    totalReports.value = 8
})
</script>

<template>
    <v-container class="mt-6">
        
        <v-row>
            <v-col>
                <h1 class="text-h4 font-weight-bold">Admin Dashboard</h1>
                <p class="text-subtitle-1">System overview & management</p>
            </v-col>
        </v-row>

        <!-- Stats Cards -->
        <v-row class="mt-4">
            <v-col cols="12" md="4">
                <v-card color="deep-purple-lighten-1" class="pa-4" dark>
                    <h3>Total Users</h3>
                    <p class="text-h4 mt-3">{{ totalUsers }}</p>
                </v-card>
            </v-col>

            <v-col cols="12" md="4">
                <v-card color="indigo-lighten-1" class="pa-4" dark>
                    <h3>Total Suppliers</h3>
                    <p class="text-h4 mt-3">{{ totalSuppliers }}</p>
                </v-card>
            </v-col>

            <v-col cols="12" md="4">
                <v-card color="purple-lighten-2" class="pa-4" dark>
                    <h3>Reports Generated</h3>
                    <p class="text-h4 mt-3">{{ totalReports }}</p>
                </v-card>
            </v-col>
        </v-row>

        <!-- System Status -->
        <v-row class="mt-4">
            <v-col cols="12" md="12">
                <v-card class="pa-6" color="grey-darken-3" dark>
                    <h3>System Health Status</h3>
                    <p class="mt-2 text-h6">Current Status: <strong>{{ systemStatus }}</strong></p>
                </v-card>
            </v-col>
        </v-row>

        <!-- Management Buttons -->
        <v-row class="mt-6">
            <v-col cols="12" md="4">
                <v-btn block color="deep-purple" size="large"> Manage Users </v-btn>
            </v-col>

            <v-col cols="12" md="4">
                <v-btn block color="indigo" size="large"> Manage Suppliers </v-btn>
            </v-col>

            <v-col cols="12" md="4">
                <v-btn block color="purple" size="large"> View All Reports </v-btn>
            </v-col>
        </v-row>

    </v-container>
</template>
