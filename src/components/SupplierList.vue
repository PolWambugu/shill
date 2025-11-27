<script setup>
import { ref, onMounted } from 'vue'

// Supplier data (replace with API call later)
const suppliers = ref([])


onMounted(() => {
    suppliers.value = [
        { id: 1, name: "Green Earth Ltd", location: "Kenya", rating: 87 },
        { id: 2, name: "EcoSourcing Co", location: "Uganda", rating: 74 },
        { id: 3, name: "Sustainably Yours", location: "Tanzania", rating: 92 },
        { id: 4, name: "Renewable Corp", location: "Rwanda", rating: 65 }
    ]
})

// Search functionality
const search = ref("")
</script>

<template>
    <v-container class="mt-6">
        
        <!-- Header -->
        <v-row>
            <v-col>
                <h1 class="text-h4 font-weight-bold">Supplier List</h1>
                <p class="text-subtitle-1">All suppliers in the system</p>
            </v-col>

            <v-col cols="12" md="4" class="d-flex justify-end align-end">
                <v-btn color="deep-purple" to="/add-supplier">Add New Supplier</v-btn>
            </v-col>
        </v-row>

        <!-- Search Bar -->
        <v-row class="mt-4">
            <v-col cols="12" md="4">
                <v-text-field
                    v-model="search"
                    label="Search suppliers..."
                    prepend-inner-icon="mdi-magnify"
                />
            </v-col>
        </v-row>

        <!-- Supplier Table -->
        <v-row>
            <v-col cols="12">
                <v-card>
                    <v-table>
                        <thead>
                            <tr>
                                <th class="text-left">Name</th>
                                <th class="text-left">Location</th>
                                <th class="text-left">Sustainability Score</th>
                                <th class="text-left">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="supplier in suppliers.filter(s => 
                                    s.name.toLowerCase().includes(search.toLowerCase())
                                )"
                                :key="supplier.id"
                            >
                                <td>{{ supplier.name }}</td>
                                <td>{{ supplier.location }}</td>
                                <td>
                                    <v-chip :color="supplier.rating >= 80 ? 'green' : 'orange'" text-color="white">
                                        {{ supplier.rating }}%
                                    </v-chip>
                                </td>
                                <td>
                                    <v-btn icon :to="`/supplier/${supplier.id}`">
                                        <v-icon>mdi-eye</v-icon>
                                    </v-btn>
                                    
                                    <v-btn icon :to="`/supplier/${supplier.id}/edit`">
                                        <v-icon>mdi-pencil</v-icon>
                                    </v-btn>
                                    
                                    <v-btn icon color="red">
                                        <v-icon>mdi-delete</v-icon>
                                    </v-btn>
                                </td>
                            </tr>
                        </tbody>
                    </v-table>
                </v-card>
            </v-col>
        </v-row>

    </v-container>
</template>
