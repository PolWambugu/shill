/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
    "./src/assets/**/*.css"  // include main.css for @apply
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
