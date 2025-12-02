<template>
  <div class="bg-emerald-50 p-6 rounded-xl">
    <h3 class="text-2xl font-bold text-emerald-700 mb-4">Supplier Sustainability Score</h3>
    <div class="text-6xl font-extrabold text-emerald-600">{{ score }}/100</div>
    <p class="text-lg mt-4" :class="score > 70 ? 'text-green-600' : 'text-yellow-600'">
      {{ score > 70 ? 'Excellent' : score > 50 ? 'Good' : 'Needs Improvement' }}
    </p>
  </div>
</template>

<script setup>
defineProps(['score'])
</script>