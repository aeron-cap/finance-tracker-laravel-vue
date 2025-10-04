<template>
  <div class="min-h-screen bg-slate-900">
    <nav 
      class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
      :class="scrolled ? 'mt-4' : 'mt-0'"
    >
      <div 
        class="max-w-6xl mx-4 lg:mx-auto rounded-2xl border border-white/10 backdrop-blur-md transition-all duration-300"
        :class="scrolled ? 'bg-slate-900/80 shadow-2xl shadow-blue-500/10' : 'bg-slate-900/50'"
      >
        <div class="px-6 lg:px-8">
          <div class="flex justify-between items-center h-16 sm:h-20">
            <div class="flex items-center">
              <h1 class="text-2xl sm:text-3xl font-extrabold text-white">
                Finance++
              </h1>
            </div>
            
            <div class="hidden md:flex items-center space-x-8">
              <a href="#features" class="text-gray-300 hover:text-white transition-colors">
                Features
              </a>
              <button class="px-6 py-2.5 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 hover:shadow-lg hover:scale-105 transition-all duration-300">
                Get Started
              </button>
            </div>

            <button 
              class="md:hidden text-white"
              @click="mobileMenuOpen = !mobileMenuOpen"
            >
              <svg v-if="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
              <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
            </button>
          </div>
        </div>

        <div v-if="mobileMenuOpen" class="md:hidden mt-2 rounded-2xl border border-white/10 bg-slate-900/90 backdrop-blur-md mx-4">
          <div class="px-6 py-4 space-y-3">
            <a href="#features" class="block text-gray-300 hover:text-white py-2">
              Features
            </a>
            <button class="w-full px-6 py-2.5 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700">
              Get Started
            </button>
          </div>
        </div>
      </div>
    </nav>

    <section class="relative overflow-hidden pt-32 sm:pt-40">
      <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500/30 rounded-full blur-3xl"></div>
      <div class="absolute top-40 right-1/4 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl"></div>
      <div class="absolute top-20 left-1/2 w-72 h-72 bg-pink-500/20 rounded-full blur-3xl"></div>
      <div class="absolute inset-0 bg-gradient-to-b from-transparent via-slate-900/50"></div>
      
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-32 relative z-10">
        <div class="text-center space-y-8">
          <h2 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold text-white leading-tight">
            Manage your finances
            <br />
            <span class="bg-gradient-to-r from-blue-500 to-purple-500 bg-clip-text text-transparent">
              smarter & simpler
            </span>
          </h2>
          
          <p class="text-lg sm:text-xl lg:text-2xl text-gray-400 max-w-3xl mx-auto">
            Take control of your money with intelligent budgeting, expense tracking, and personalized financial insights.
          </p>
        </div>

        <div class="mt-16 sm:mt-24 relative">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent z-10"></div>
          <div class="relative rounded-2xl overflow-hidden border border-gray-700 shadow-2xl bg-slate-800 p-8">
            <div class="flex items-center gap-2 mb-6">
              <div class="w-3 h-3 rounded-full bg-red-500"></div>
              <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
              <div class="w-3 h-3 rounded-full bg-green-500"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <div class="bg-blue-500/20 p-6 rounded-xl border border-blue-500/30">
                <svg class="w-8 h-8 text-blue-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <div class="text-3xl font-bold text-white mb-1">$12,450</div>
                <div class="text-sm text-gray-400">Total Balance</div>
              </div>
              <div class="bg-orange-500/20 p-6 rounded-xl border border-orange-500/30">
                <svg class="w-8 h-8 text-orange-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                <div class="text-3xl font-bold text-white mb-1">+23.5%</div>
                <div class="text-sm text-gray-400">This Month</div>
              </div>
              <div class="bg-green-500/20 p-6 rounded-xl border border-green-500/30">
                <svg class="w-8 h-8 text-green-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                </svg>
                <div class="text-3xl font-bold text-white mb-1">8</div>
                <div class="text-sm text-gray-400">Active Budgets</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="absolute bottom-0 left-0 right-0 z-10">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full">
          <path d="M0 0L60 10C120 20 240 40 360 46.7C480 53 600 47 720 43.3C840 40 960 40 1080 46.7C1200 53 1320 67 1380 73.3L1440 80V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0V0Z" fill="rgba(0,0,0,0.2)"/>
        </svg>
      </div>
    </section>

    <section id="features" class="py-20 sm:py-32 bg-gradient-to-b from-transparent via-black/20 to-transparent relative">
      <div class="absolute top-1/4 left-0 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl animate-float-slow"></div>
      <div class="absolute bottom-1/4 right-0 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-float-delay-slow"></div>
      <div class="absolute top-1/2 left-1/3 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl animate-pulse-slower"></div>
      
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
          <h3 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4">
            Everything you need to succeed
          </h3>
          <p class="text-lg sm:text-xl text-gray-400 max-w-2xl mx-auto">
            Powerful features designed to help you take control of your financial future
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div 
            v-for="(feature, index) in features" 
            :key="index"
            class="group p-8 rounded-2xl bg-slate-800/50 border border-gray-700 hover:border-gray-600 transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-blue-500/10"
          >
            <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-blue-600 to-purple-600 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
              <div class="text-white" v-html="feature.icon"></div>
            </div>
            <h4 class="text-2xl font-bold text-white mb-3">{{ feature.title }}</h4>
            <p class="text-gray-400 text-lg">{{ feature.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <footer class="border-t border-gray-700/50 bg-black/20 py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
          <div class="text-2xl font-extrabold bg-gradient-to-r from-blue-500 to-purple-500 bg-clip-text text-transparent">
            Finance++
          </div>
        </div>
        <div class="mt-8 text-center text-sm text-gray-500">
          © 2025 Made by yours truly.
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
  import { ref, onMounted, onUnmounted } from 'vue';

  const mobileMenuOpen = ref(false);
  const scrolled = ref(false);

  const handleScroll = () => {
    scrolled.value = window.scrollY > 50;
  };

  onMounted(() => {
    window.addEventListener('scroll', handleScroll);
  });

  onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
  });

  const features = [
    {
      icon: '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" /></svg>',
      title: "Budget Planning",
      description: "Create custom budgets and monitor your progress with intuitive visualizations"
    },
    {
      icon: '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>',
      title: "Real-Time Sync",
      description: "Automatic transaction syncing across all your accounts and devices"
    }
  ];
</script>

<style scoped>

</style>