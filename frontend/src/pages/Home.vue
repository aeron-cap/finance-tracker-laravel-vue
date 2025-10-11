<template>
  <div class="min-h-screen pb-20 relative">
    <div class="px-4 py-8 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl sm:text-5xl font-bold text-white mb-2">
          Dashboard
        </h1>
        <p class="text-lg text-gray-400">
          Take a bird's eye view of your finances
        </p>
      </div>
    </div>

    <div class="px-4 sm:px-6 lg:px-8 mb-8">
      <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="stat-card group p-6 rounded-2xl bg-slate-800/50 border border-gray-700/50 backdrop-blur-sm hover:border-blue-500/50 transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-blue-500/20">
            <div class="flex items-center justify-between mb-4">
              <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
            </div>
            <div class="text-3xl font-bold text-white mb-1">$12,450</div>
            <div class="text-sm text-gray-400">Total Balance</div>
          </div>
          <div class="stat-card group p-6 rounded-2xl bg-slate-800/50 border border-gray-700/50 backdrop-blur-sm hover:border-green-500/50 transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-green-500/20">
            <div class="flex items-center justify-between mb-4">
              <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
              </div>
            </div>
            <div class="text-3xl font-bold text-white mb-1">$8,320</div>
            <div class="text-sm text-gray-400">Monthly Income</div>
            <div class="mt-2 text-xs text-green-400">+12.5% from last month</div>
          </div>

          <div class="stat-card group p-6 rounded-2xl bg-slate-800/50 border border-gray-700/50 backdrop-blur-sm hover:border-red-500/50 transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-red-500/20">
            <div class="flex items-center justify-between mb-4">
              <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                </svg>
              </div>
            </div>
            <div class="text-3xl font-bold text-white mb-1">$5,670</div>
            <div class="text-sm text-gray-400">Monthly Expenses</div>
            <div class="mt-2 text-xs text-red-400">+5.2% from last month</div>
          </div>

          <div class="stat-card group p-6 rounded-2xl bg-slate-800/50 border border-gray-700/50 backdrop-blur-sm hover:border-purple-500/50 transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-purple-500/20">
            <div class="flex items-center justify-between mb-4">
              <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                </svg>
              </div>
            </div>
            <div class="text-3xl font-bold text-white mb-1">8</div>
            <div class="text-sm text-gray-400">Active Budgets</div>
          </div>
        </div>
      </div>
    </div>

    <div class="px-4 sm:px-6 lg:px-8 mb-8">
      <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <div class="p-6 rounded-2xl bg-slate-800/50 border border-gray-700/50 backdrop-blur-sm">
            <h3 class="text-xl font-bold text-white mb-4">Spending Overview</h3>
            <div class="h-64 flex items-center justify-center text-gray-500">
              <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
            </div>
          </div>

          <div class="p-6 rounded-2xl bg-slate-800/50 border border-gray-700/50 backdrop-blur-sm">
            <h3 class="text-xl font-bold text-white mb-4">Budget Progress</h3>
            <div class="h-64 flex items-center justify-center text-gray-500">
              <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
              </svg>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">
        <div class="p-6 rounded-2xl bg-slate-800/50 border border-gray-700/50 backdrop-blur-sm">
          <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-white">Recent Transactions</h3>
          </div>
          
          <div class="space-y-4">
            <div 
              v-for="transaction in recentTransactions" 
              :key="transaction.id"
              class="flex items-center justify-between p-4 rounded-xl bg-slate-700/30 hover:bg-slate-700/50 transition-colors"
            >
              <div class="flex items-center gap-4">
                <div 
                  class="w-10 h-10 rounded-lg flex items-center justify-center"
                  :class="transaction.type === 'income' ? 'bg-green-500/20' : 'bg-red-500/20'"
                >
                  <svg 
                    class="w-5 h-5" 
                    :class="transaction.type === 'income' ? 'text-green-400' : 'text-red-400'"
                    fill="none" 
                    stroke="currentColor" 
                    viewBox="0 0 24 24"
                  >
                    <path 
                      stroke-linecap="round" 
                      stroke-linejoin="round" 
                      stroke-width="2" 
                      :d="transaction.icon" 
                    />
                  </svg>
                </div>
                <div>
                  <div class="text-white font-medium">{{ transaction.description }}</div>
                  <div class="text-sm text-gray-400">{{ transaction.date }}</div>
                </div>
              </div>
              <div 
                class="font-semibold"
                :class="transaction.type === 'income' ? 'text-green-400' : 'text-red-400'"
              >
                {{ transaction.type === 'income' ? '+' : '-' }}${{ transaction.amount.toFixed(2) }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';

onMounted(() => {
  // get info functions
  // get latest transactions
})

</script>

<style scoped>

</style>