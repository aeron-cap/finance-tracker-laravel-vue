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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div
            v-for="account in accounts"
            :key="account.id"
            class="p-6 rounded-2xl bg-slate-800/50 border border-gray-700/50 backdrop-blur-sm hover:border-gray-600/50 transition-all"
          >
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-semibold text-white">{{ account.name }}</h3>
              <span
                class="px-3 py-1 rounded-full text-xs font-medium"
                :class="account.status_id === 1 ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400'"
              >
                {{ account.description }}
              </span>
            </div>
            <div class="space-y-2">
              <div class="text-3xl font-bold text-white">
                P {{ $formatToDecimal(account.actual_balance) }}
              </div>
            </div>
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
          
          <div v-if="loading" class="space-y-4">
            <div
              v-for="i in 5"
              :key="i"
              class="flex items-center justify-between p-4 rounded-xl bg-slate-700/30 animate-pulse"
            >
              <div class="flex items-center gap-4">
                <div class="space-y-2">
                  <div class="h-4 w-32 bg-slate-600/50 rounded"></div>
                  <div class="h-3 w-24 bg-slate-600/50 rounded"></div>
                </div>
              </div>
              <div class="h-4 w-24 bg-slate-600/50 rounded"></div>
            </div>
          </div>

          <div v-else class="space-y-4">
            <div 
              v-for="transaction in transactions" 
              :key="transaction.id"
              class="flex items-center justify-between p-4 rounded-xl bg-slate-700/30 hover:bg-slate-700/50 transition-colors"
            >
              <div class="flex items-center gap-4">
                <div>
                  <div class="text-white font-medium">{{ transaction.description }}</div>
                  <div class="text-sm text-gray-400">{{ transaction.date }}</div>
                </div>
              </div>
              <div 
                class="font-semibold"
                :class="transaction.type === 'income' ? 'text-green-400' : 'text-red-400'"
              >
                {{ transaction.account }}
              {{ transaction.type === 'income' ? '+' : '-' }} P {{ $formatToDecimal(transaction.amount) }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import axios from '../lib/axios';

const loading = ref(false);
const transactions = ref([]);
const accounts = ref([]);

onMounted(() => {
  get_recent_transactions();
  get_accounts();
})

async function get_recent_transactions() {
  try {
    const response = await axios.post("api/recent_transactions");
    if (response.data.length > 0) {
      transactions.value = response.data;
    }
  } catch (error) { 
  }
}

async function get_accounts() {
  try {
    const response = await axios.post("api/show-accounts-for-dashboard");
    console.log("Response", response.data.accounts);
    if (response.data.accounts.length > 0) {
      accounts.value = response.data.accounts;
    }
  } catch (error) {
  }
}

</script>

<style scoped>

</style>