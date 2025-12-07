<template>
  <Line :data="chartData" :options="chartOptions" />
</template>

<script setup>
import { defineProps } from 'vue'
import { Line } from 'vue-chartjs'
import {
  Chart as ChartJS,
  LineElement,
  PointElement,
  CategoryScale,
  LinearScale,
  Tooltip,
  Legend
} from 'chart.js'

// Register the chart.js components
ChartJS.register(LineElement, PointElement, CategoryScale, LinearScale, Tooltip, Legend)

const props = defineProps({
  chartData: { type: Object, required: true },
  chartOptions: { type: Object, required: true }
})
</script>
