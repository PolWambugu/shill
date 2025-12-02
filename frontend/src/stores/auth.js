import { defineStore } from 'pinia'
import axios from 'axios'

axios.defaults.baseURL = 'http://127.0.0.1:8000/api'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token') || null,
    error: null
  }),
  actions: {
    async login(credentials) {
      try {
        const res = await axios.post('/login', credentials)
        this.token = res.data.access_token
        this.user = res.data.user
        localStorage.setItem('token', this.token)
        axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
        this.error = null
      } catch (err) {
        this.error = err.response?.data?.message || 'Login failed'
        throw err
      }
    },
    async register(data) {
  try {
    const res = await axios.post('/register', data)
    this.token = res.data.access_token
    this.user = res.data.user
    localStorage.setItem('token', this.token)
    axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
    this.error = null
  } catch (err) {
    const backend = err.response?.data || {}

    // Laravel validation errors
    if (backend.errors) {
      const firstError = Object.values(backend.errors)[0][0]
      this.error = firstError
    }

    // Normal Laravel error message
    else if (backend.message) {
      this.error = backend.message
    }

    else {
      this.error = "Registration failed. Try again."
    }

    throw err
  }


    },
    logout() {
      this.user = null
      this.token = null
      this.error = null
      localStorage.removeItem('token')
      delete axios.defaults.headers.common['Authorization']
    }
  }
})