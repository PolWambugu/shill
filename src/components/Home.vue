<script setup>
const isLoggedIn = JSON.parse(localStorage.getItem("isLoggedIn"))
</script>

<template>
  <v-container fluid class="mt-12">

    <!-- Welcome Section -->
    <v-row justify="center">
      <v-col cols="12" md="8" class="text-center">
        <h1 class="display-1 font-weight-bold">
          Welcome to EcoChain
        </h1>
        <p class="headline mt-4">
          Track, manage, and optimize your supply chain sustainably.
        </p>

        <v-btn
          color="green darken-2"
          class="mt-6"
          large
          to="/Dashboard"
          v-if="isLoggedIn"
        >
          Go to Dashboard
        </v-btn>

        <v-btn
          color="green darken-2"
          class="mt-6"
          large
          to="/login"
          v-else
        >
          Login to Start
        </v-btn>
      </v-col>
    </v-row>

    <!-- Features Section -->
    <v-row class="mt-12" justify="center" align="stretch" dense>
      <v-col cols="12" md="3" class="text-center">
        <v-card outlined>
          <v-card-title class="font-weight-bold">
            Suppliers
          </v-card-title>
          <v-card-text>
            Manage and monitor all suppliers in your supply chain.
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" md="3" class="text-center">
        <v-card outlined>
          <v-card-title class="font-weight-bold">
            Sustainability
          </v-card-title>
          <v-card-text>
            Track carbon footprint, waste, and resource usage efficiently.
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" md="3" class="text-center">
        <v-card outlined>
          <v-card-title class="font-weight-bold">
            Analytics
          </v-card-title>
          <v-card-text>
            Get reports, insights, and trends for better decision-making.
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- Call-to-Action Section -->
    <v-row justify="center" class="mt-12">
      <v-col cols="12" md="8" class="text-center">
        <v-card color="green lighten-4" class="pa-6">
          <h2 class="font-weight-bold">Start building a sustainable supply chain today</h2>
          <v-btn color="green darken-2" large class="mt-4" to="/login" v-if="!isLoggedIn">
            Get Started
          </v-btn>
        </v-card>
      </v-col>
    </v-row>

  </v-container>
</template>

<style scoped>
h1 {
  color: #2e7d32; /* green-darken-3 */
}

h2 {
  color: #1b5e20; /* darker green */
}

p {
  color: #424242;
}

.v-card-title {
  font-size: 18px;
}

.v-card-text {
  font-size: 14px;
}
</style>
