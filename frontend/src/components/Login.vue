<template>
  <div
    class="relative min-h-screen bg-cover bg-center flex items-center justify-center px-6"
    style="background-image: url('/login-bg.jpg');"
  >
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>

    <div
      class="relative bg-black bg-opacity-40 backdrop-blur-lg p-10 rounded-xl shadow-2xl w-full max-w-md border border-gray-700"
    >
      <h2 class="text-3xl font-bold text-center text-white mb-8">Login Form</h2>

      <p v-if="errorMessage" class="text-red-400 text-center mb-4 font-semibold">
        {{ errorMessage }}
      </p>

      <form @submit.prevent="login" class="space-y-6">
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

        <div>
          <a href="#" class="text-gray-300 text-sm hover:text-white">Forgot Password?</a>
        </div>

        <button
          type="submit"
          class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3 rounded-md text-lg flex justify-center items-center gap-2"
          :disabled="loading"
        >
          <span v-if="loading" class="loader-border w-5 h-5 border-2 rounded-full border-white border-t-transparent animate-spin"></span>
          LOGIN
        </button>
      </form>

      <p class="text-center text-gray-200 mt-6">
        Don't have account?
        <router-link to="/register" class="text-blue-400 hover:text-blue-300 font-bold">
          Signup Now
        </router-link>
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref, nextTick } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const email = ref('')
const password = ref('')
const errorMessage = ref('')
const loading = ref(false)

const router = useRouter()
const auth = useAuthStore()

const login = async () => {
  errorMessage.value = ''
  loading.value = true

  try {
    await auth.login({ email: email.value, password: password.value })

    // ✅ Wait a tick to ensure reactivity updates
    await nextTick()

    // Redirect immediately based on role
    if (auth.user?.role === 'admin') router.replace('/admin')
    else router.replace('/dashboard')
  } catch (err) {
    console.error(err)
    errorMessage.value = auth.error || 'Login failed. Try again.'
  } finally {
    loading.value = false
  }
}
</script>
