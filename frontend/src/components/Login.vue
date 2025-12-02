<template>
  <div
    class="relative min-h-screen bg-cover bg-center flex items-center justify-center px-6"
    style="background-image: url('/login-bg.jpg');"
  >
    <!-- Dark overlay -->
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>

    <!-- Login Box -->
    <div
      class="relative bg-black bg-opacity-40 backdrop-blur-lg p-10 rounded-xl shadow-2xl w-full max-w-md border border-gray-700"
    >
      <!-- Title -->
      <h2 class="text-3xl font-bold text-center text-white mb-8">Login Form</h2>

      <!-- Form -->
      <form @submit.prevent="login" class="space-y-6">

        <!-- Email Field -->
        <div class="relative">
          <span class="absolute left-4 top-4 text-gray-400 text-xl">👤</span>
          <input
            v-model="email"
            type="text"
            placeholder="Email or Phone"
            class="w-full pl-12 pr-4 py-3 bg-white text-gray-800 rounded-md outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
        </div>

        <!-- Password Field -->
        <div class="relative">
          <span class="absolute left-4 top-4 text-gray-400 text-xl">🔒</span>
          <input
            v-model="password"
            type="password"
            placeholder="Password"
            class="w-full pl-12 pr-4 py-3 bg-white text-gray-800 rounded-md outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
        </div>

        <!-- Forgot Password -->
        <div>
          <a href="#" class="text-gray-300 text-sm hover:text-white">
            Forgot Password?
          </a>
        </div>

        <!-- Login Button -->
        <button
          type="submit"
          class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 rounded-md text-lg"
        >
          LOGIN
        </button>
      </form>

      <!-- Divider -->
      <div class="text-center my-6 text-gray-300">Or login with</div>

      <!-- Social Buttons -->
      <div class="flex justify-center space-x-4">
        <button
          class="flex items-center gap-2 bg-blue-700 hover:bg-blue-600 text-white px-6 py-2 rounded-md font-semibold"
        >
          <span class="text-xl">f</span> Facebook
        </button>

        <button
          class="flex items-center gap-2 bg-pink-600 hover:bg-pink-500 text-white px-6 py-2 rounded-md font-semibold"
        >
          <span class="text-xl">📷</span> Instagram
        </button>
      </div>

      <!-- Sign Up -->
      <p class="text-center text-gray-200 mt-6">
        Don't have account?
        <router-link
          to="/register"
          class="text-blue-400 hover:text-blue-300 font-bold"
        >
          Signup Now
        </router-link>
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/auth";

const email = ref("");
const password = ref("");
const router = useRouter();
const auth = useAuthStore();

const login = async () => {
  // 1. Attempt login using the auth store (which should handle the API call)
  await auth.login({ email: email.value, password: password.value });

  // 2. Check the user's role from localStorage after successful login
  const userRole = localStorage.getItem('user_role');

  // 3. Redirect based on the role
  if (userRole === 'admin') {
    router.push("/admin");
  } else {
    router.push("/dashboard");
  }
};
</script>

<style scoped>
/* Smooth corners & shadows */
</style>