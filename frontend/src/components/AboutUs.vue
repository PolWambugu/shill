<template>
  <div class="min-h-screen bg-gradient-to-br from-emerald-50 to-teal-50 py-20">
    <div class="max-w-7xl mx-auto px-8">
      <!-- Title -->
      <h1 class="text-6xl font-extrabold text-center text-emerald-800 mb-16">
        About EcoTrack
      </h1>

      <!-- SDG Badges -->
      <div class="flex justify-center space-x-12 mb-20">
        <div class="text-center">
          <div class="bg-red-600 text-white w-32 h-32 rounded-full flex items-center justify-center text-5xl font-bold shadow-2xl">
            13
          </div>
          <p class="text-2xl font-bold mt-4 text-gray-800">Climate Action</p>
        </div>
        <div class="text-center">
          <div class="bg-green-600 text-white w-32 h-32 rounded-full flex items-center justify-center text-5xl font-bold shadow-2xl">
            12
          </div>
          <p class="text-2xl font-bold mt-4 text-gray-800">Responsible Consumption</p>
        </div>
        <div class="text-center">
          <div class="bg-blue-600 text-white w-32 h-32 rounded-full flex items-center justify-center text-5xl font-bold shadow-2xl">
            9
          </div>
          <p class="text-2xl font-bold mt-4 text-gray-800">Industry, Innovation & Infrastructure</p>
        </div>
      </div>

      <!-- Main Content -->
      <div class="bg-white rounded-3xl shadow-2xl p-12 border border-emerald-100">
        <h2 class="text-4xl font-bold text-emerald-700 mb-8 text-center">
          Our Mission: Empowering Sustainable Futures
        </h2>
        <p class="text-xl text-gray-700 leading-relaxed mb-8 text-center max-w-4xl mx-auto">
          EcoTrack is a full-stack sustainability platform designed to help individuals and organizations measure, track, and reduce their carbon footprint — directly contributing to the United Nations Sustainable Development Goals.
        </p>

        <!-- SDG 13: Climate Action -->
        <div class="grid md:grid-cols-2 gap-12 mb-16">
          <div class="bg-red-50 p-10 rounded-2xl border-l-8 border-red-600">
            <h3 class="text-3xl font-bold text-red-700 mb-4">SDG 13: Climate Action</h3>
            <p class="text-lg text-gray-700">
              By providing real-time carbon emissions tracking from electricity, travel, and waste, EcoTrack empowers users to take immediate action against climate change. Every ton of CO₂ measured is a step toward global net-zero targets.
            </p>
          </div>

          <!-- SDG 9: Industry, Innovation & Infrastructure -->
          <div class="bg-blue-50 p-10 rounded-2xl border-l-8 border-blue-600">
            <h3 class="text-3xl font-bold text-blue-700 mb-4">SDG 9: Industry, Innovation & Infrastructure</h3>
            <p class="text-lg text-gray-700">
              Built with modern full-stack technology (Laravel + Vue 3 + Tailwind), EcoTrack represents resilient, innovative infrastructure that promotes sustainable industrialization and fosters innovation in environmental monitoring.
            </p>
          </div>
        </div>

        <!-- Team / Project Info — CLEAN & PROFESSIONAL VERSION -->
<div class="text-center py-16 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-3xl">
  <h3 class="text-4xl font-extrabold text-emerald-800 mb-8">
    A Project for Global Impact
  </h3>
  <p class="text-xl text-gray-700 max-w-4xl mx-auto leading-relaxed px-8">
    EcoTrack is a full-stack sustainability platform designed to empower individuals and organizations 
    to measure, monitor, and reduce their environmental footprint in real-time. 
    By providing actionable insights into carbon emissions, waste generation, and resource consumption, 
    this tool directly supports the United Nations Sustainable Development Goals — 
    particularly <strong>SDG 13 (Climate Action)</strong> and <strong>SDG 9 (Industry, Innovation and Infrastructure)</strong>.
  </p>
  <p class="text-lg text-gray-600 mt-8 max-w-3xl mx-auto">
    Built with modern technologies (Laravel, Vue 3, Tailwind CSS), EcoTrack represents a scalable, 
    user-centric solution for driving behavioral change toward a greener, more sustainable future.
  </p>
</div>

        <!-- Final Message -->
        <div class="text-center mt-16">
          <p class="text-3xl font-bold text-emerald-700">
            Together, we can make a difference — one footprint at a time.
          </p>
        </div>
      </div>
    </div>
  </div>
</template>