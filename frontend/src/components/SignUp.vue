<template>
  <!-- Dark backdrop -->
  <div class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50" @click="$router.push('/')">
    
    <!-- Floating semi-transparent glass box -->
    <div class="bg-white bg-opacity-10 backdrop-blur-xl border border-white border-opacity-20 rounded-3xl shadow-2xl p-12 w-full max-w-2xl relative" @click.stop>
      
      <!-- Close button -->
      <button @click="$router.push('/')" class="absolute top-6 right-6 text-white text-4xl hover:text-gray-300 transition">×</button>
      
      <!-- Title -->
      <div class="text-center mb-10">
        <h1 class="text-6xl font-extrabold text-white mb-4 drop-shadow-lg">EcoTrack</h1>
        <p class="text-2xl text-emerald-300">Create Your Account</p>
      </div>

      <!-- Error Message -->
      <p v-if="errorMessage" class="text-red-400 text-center mb-4 font-semibold">{{ errorMessage }}</p>

      <!-- Form -->
      <form @submit.prevent="register" class="space-y-6">
        <div class="grid md:grid-cols-2 gap-6">
          <input v-model="name" placeholder="Full Name" required 
            class="w-full px-6 py-5 bg-white bg-opacity-20 text-white placeholder-gray-300 border border-white border-opacity-30 rounded-xl focus:outline-none focus:border-emerald-400 focus:bg-opacity-30 transition text-lg" />

          <input v-model="email" type="email" placeholder="Email Address" required 
            class="w-full px-6 py-5 bg-white bg-opacity-20 text-white placeholder-gray-300 border border-white border-opacity-30 rounded-xl focus:outline-none focus:border-emerald-400 focus:bg-opacity-30 transition text-lg" />

          <input v-model="password" type="password" placeholder="Password" required 
            class="w-full px-6 py-5 bg-white bg-opacity-20 text-white placeholder-gray-300 border border-white border-opacity-30 rounded-xl focus:outline-none focus:border-emerald-400 focus:bg-opacity-30 transition text-lg" />

          <input v-model="password_confirmation" type="password" placeholder="Confirm Password" required 
            class="w-full px-6 py-5 bg-white bg-opacity-20 text-white placeholder-gray-300 border border-white border-opacity-30 rounded-xl focus:outline-none focus:border-emerald-400 focus:bg-opacity-30 transition text-lg" />
        </div>

        <!-- Sign Up Button -->
        <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-400 text-white text-2xl font-bold py-6 rounded-2xl shadow-2xl transform hover:scale-105 transition duration-300">
          Create Account
        </button>
      </form>

      <!-- Login link -->
      <p class="text-center mt-8 text-emerald-300 text-lg">
        Already have an account? 
        <router-link to="/login" class="underline hover:text-white font-bold">Login here</router-link>
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

const name = ref('');
const email = ref('');
const password = ref('');
const password_confirmation = ref('');
const errorMessage = ref('');

const router = useRouter();
const auth = useAuthStore();

const register = async () => {
  errorMessage.value = '';

  try {
    await auth.register({
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value
    });

    localStorage.setItem('user_email', email.value);
    localStorage.setItem('user_role', 'user');

    router.replace('/dashboard'); // auto redirect
  } catch (err) {
    errorMessage.value = err.response?.data?.message || 'Registration failed. Try again.';
  }
}
</script>
