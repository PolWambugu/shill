import { defineStore } from 'pinia'
import axios from 'axios'

axios.defaults.baseURL = 'http://127.0.0.1:8000/api'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: JSON.parse(localStorage.getItem('user')) || null,
    token: localStorage.getItem('token') || null,
    error: null
  }),

  actions: {
    async login(credentials) {
      // MOCK USERS (for presentation)
      const mockUsers = [
        { id: 1, name: 'Admin User', email: 'admin@system.com', role: 'admin' },
        { id: 2, name: 'Mary Wachira', email: 'mary@greenfuel.com', role: 'user' },
        { id: 3, name: 'John Mwangi', email: 'john@ecopaper.com', role: 'user' },
        { id: 4, name: 'Fatma Ali', email: 'fatma@bluewater.com', role: 'user' },
        { id: 5, name: 'Brian Otieno', email: 'brian@solartech.com', role: 'user' }
      ];

      const user = mockUsers.find(u => u.email === credentials.email);

      // If mock user found and password matches (use 'password' for presentation)
      if (user && credentials.password === 'password') {
        const mockToken = `mock-token-${user.id}`;

        this.user = user;
        this.token = mockToken;

        localStorage.setItem('user', JSON.stringify(user));
        localStorage.setItem('token', mockToken);

        axios.defaults.headers.common['Authorization'] = `Bearer ${mockToken}`;
        this.error = null;
        return;
      }

      // Otherwise, try real backend login
      try {
        const res = await axios.post('/login', credentials);

        this.token = res.data.token;
        this.user = res.data.user;

        localStorage.setItem('token', this.token);
        localStorage.setItem('user', JSON.stringify(this.user));

        axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
        this.error = null;
      } catch (err) {
        this.error = err.response?.data?.message || 'Login failed';
        throw err;
      }
    },

    async register(data) {
      try {
        const res = await axios.post('/register', data);

        this.token = res.data.token;
        this.user = res.data.user;

        localStorage.setItem('token', this.token);
        localStorage.setItem('user', JSON.stringify(this.user));

        axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
        this.error = null;
      } catch (err) {
        const backend = err.response?.data || {};

        if (backend.errors) {
          const firstError = Object.values(backend.errors)[0][0];
          this.error = firstError;
        } else if (backend.message) {
          this.error = backend.message;
        } else {
          this.error = "Registration failed. Try again.";
        }

        throw err;
      }
    },

    logout() {
      this.user = null;
      this.token = null;
      this.error = null;

      localStorage.removeItem('token');
      localStorage.removeItem('user');

      delete axios.defaults.headers.common['Authorization'];
    }
  }
});
