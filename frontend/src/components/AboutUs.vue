<template>
  <div class="min-h-screen bg-gradient-to-br from-emerald-50 to-teal-50 py-20">
    <div class="max-w-7xl mx-auto px-8">
      
      <!-- Title -->
      <h1 class="text-6xl font-extrabold text-center text-emerald-800 mb-16">
        About EcoTrack
      </h1>

      <!-- Why Choose EcoTrack -->
      <div class="mt-20 bg-white p-12 rounded-3xl shadow-xl border border-emerald-100">
        <h2 class="text-4xl font-extrabold text-emerald-800 text-center mb-10">
          Why Choose EcoTrack?
        </h2>

        <div class="grid md:grid-cols-3 gap-12">
          
          <!-- Feature 1 -->
          <div class="text-center p-8 bg-emerald-50 rounded-2xl shadow-sm hover:shadow-lg transition">
            <div class="text-5xl mb-4">🌍</div>
            <h3 class="text-2xl font-bold text-emerald-700 mb-3">Real-Time Insights</h3>
            <p class="text-gray-700">
              Track carbon emissions, waste, and resource usage with live calculations and intuitive dashboards.
            </p>
          </div>

          <!-- Feature 3 -->
          <div class="text-center p-8 bg-green-50 rounded-2xl shadow-sm hover:shadow-lg transition">
            <div class="text-5xl mb-4">🔒</div>
            <h3 class="text-2xl font-bold text-green-700 mb-3">Secure & Privacy-Focused</h3>
            <p class="text-gray-700">
              Every user’s data is fully protected through industry-standard security and encrypted communication.
            </p>
          </div>

          <!-- Feature 4 -->
          <div class="text-center p-8 bg-lime-50 rounded-2xl shadow-sm hover:shadow-lg transition md:col-span-3">
            <div class="text-5xl mb-4">📊</div>
            <h3 class="text-2xl font-bold text-lime-700 mb-3">Actionable Sustainability Tools</h3>
            <p class="text-gray-700 max-w-2xl mx-auto">
              EcoTrack goes beyond measurements — delivering insights, trends, and improvement suggestions to help users reduce their ecological footprint effectively.
            </p>
          </div>

        </div>
      </div>


      <!-- SDG Badges -->
      <div class="flex justify-center space-x-12 mb-20 mt-24">
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
          <p class="text-2xl font-bold mt-4 text-gray-800">Innovation & Infrastructure</p>
        </div>
      </div>


      <!-- Main Content -->
      <div class="bg-white rounded-3xl shadow-2xl p-12 border border-emerald-100">
        
        <h2 class="text-4xl font-bold text-emerald-700 mb-8 text-center">
          Our Mission: Empowering Sustainable Futures
        </h2>

        <p class="text-xl text-gray-700 leading-relaxed mb-8 text-center max-w-4xl mx-auto">
          EcoTrack is built to help the world transition toward a greener future by measuring, monitoring, 
          and reducing environmental footprints — aligned with global sustainability goals.
        </p>


        <!-- 2050 Net Zero Benchmark -->
        <div class="mt-20 bg-gradient-to-r from-teal-50 to-emerald-50 p-12 rounded-3xl shadow-xl border border-emerald-100">
          <h2 class="text-4xl font-extrabold text-emerald-800 text-center mb-10">
            The 2050 Net-Zero Benchmark
          </h2>

          <p class="text-xl text-gray-700 max-w-4xl mx-auto leading-relaxed text-center mb-10">
            To support global climate goals, organizations must drastically reduce carbon emissions.  
            EcoTrack uses a clear benchmark: <strong>all companies should reduce emissions to 2,000 tons or less by 2050</strong>.
          </p>

          <div class="grid md:grid-cols-3 gap-10 mt-12">

            <!-- Why 2050? -->
            <div class="bg-white p-8 rounded-2xl shadow hover:shadow-lg transition">
              <h3 class="text-2xl font-bold text-emerald-700 mb-4">🌍 Why 2050?</h3>
              <p class="text-gray-700">
                Scientists agree that emissions must reach net zero by 2050 to keep global warming below 1.5°C — 
                making this a worldwide climate standard.
              </p>
            </div>

            <!-- Why 2000 Tons -->
            <div class="bg-white p-8 rounded-2xl shadow hover:shadow-lg transition">
              <h3 class="text-2xl font-bold text-emerald-700 mb-4">📉 Why 2,000 Tons?</h3>
              <p class="text-gray-700">
                2,000 tons represents a realistic but ambitious target for medium-sized companies, aligned with UN net-zero pathways.
              </p>
            </div>

            <!-- How EcoTrack Helps -->
            <div class="bg-white p-8 rounded-2xl shadow hover:shadow-lg transition">
              <h3 class="text-2xl font-bold text-emerald-700 mb-4">🛠️ How EcoTrack Helps</h3>
              <p class="text-gray-700">
                EcoTrack monitors real-time emissions, forecasts trends, and alerts users when targets drift — guiding them toward meeting the 2050 benchmark.
              </p>
            </div>

          </div>
        </div>


        <!-- Team / Project Info -->
        <div class="text-center py-16 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-3xl mt-20">
          <h3 class="text-4xl font-extrabold text-emerald-800 mb-8">
            A Project for Global Impact
          </h3>
          <p class="text-xl text-gray-700 max-w-4xl mx-auto leading-relaxed px-8">
            EcoTrack empowers organizations and individuals to make measurable, meaningful contributions 
            to a more sustainable world — one smart decision at a time.
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
