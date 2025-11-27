<script setup>
const isLoggedIn = JSON.parse(localStorage.getItem("isLoggedIn"))
const isAdmin = JSON.parse(localStorage.getItem("isAdmin")) || false
</script>

<template>
  <v-app-bar color="green-darken-3" dark>
    <v-app-bar-title>EcoChain</v-app-bar-title>

    <!-- Core Structure -->
    <v-btn to="/">Landing</v-btn>
    <v-btn to="/dashboard" v-if="isLoggedIn">Dashboard</v-btn>
    <v-btn to="/settings" v-if="isLoggedIn">Settings</v-btn>

    <!-- Suppliers -->
    <v-btn to="/suppliers" v-if="isLoggedIn">Suppliers</v-btn>
    <v-btn to="/supplier/add" v-if="isLoggedIn">Add Supplier</v-btn>

    <!-- Sustainability Tracking -->
    <v-btn to="/carbon/input" v-if="isLoggedIn">Carbon Input</v-btn>
    <v-btn to="/carbon/summary" v-if="isLoggedIn">Carbon Summary</v-btn>

    <v-btn to="/waste/input" v-if="isLoggedIn">Waste Input</v-btn>
    <v-btn to="/waste/summary" v-if="isLoggedIn">Waste Summary</v-btn>

    <v-btn to="/resources/input" v-if="isLoggedIn">Resource Input</v-btn>
    <v-btn to="/resources/summary" v-if="isLoggedIn">Resource Summary</v-btn>

    <!-- Reports & Analytics -->
    <v-btn to="/reports" v-if="isLoggedIn">Reports</v-btn>
    <v-btn to="/trends" v-if="isLoggedIn">Trends</v-btn>
    <v-btn to="/insights" v-if="isLoggedIn">Insights</v-btn>

    <!-- Admin -->
    <v-btn to="/admin" v-if="isLoggedIn && isAdmin">Admin</v-btn>

    <v-spacer></v-spacer>

    <!-- User Avatar -->
    <v-avatar v-if="isLoggedIn" to="/profile" class="ml-3" color="green-lighten-2">
      <span class="text-h5 text-white">U</span>
    </v-avatar>

    <!-- Login Button -->
    <v-btn to="/login" v-else>Login</v-btn>
  </v-app-bar>
</template>

<style>
.v-app-bar {
  padding-left: 20px;
  padding-right: 20px;
}

.v-btn {
  margin-left: 10px;
  text-transform: none;
  font-weight: 500;
}

.v-avatar {
  cursor: pointer;
}
</style>
