<template>
    <div class="min-h-screen pb-20">
        <div class="h-full px-4 py-6 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="mb-8">
                    <h1 class="text-4xl sm:text-5xl font-bold text-white">Incomes</h1>
                    <p class="mt-2 text-lg text-gray-400">
                        Manage your Income flow
                    </p>
                </div>

                <div v-if="loading" class="flex justify-center items-center py-8">
                    <div role="status">
                        <svg aria-hidden="true" class="w-12 h-12 text-gray-600 animate-spin fill-blue-500" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>

                <div v-else-if="error" class="p-6 rounded-2xl bg-red-500/10 border border-red-500/50 backdrop-blur-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-300">Error</h3>
                            <p class="mt-1 text-sm text-red-200">{{ error }}</p>
                        </div>
                    </div>
                </div>

                <div v-else class="relative">
                    <div v-if="incomes_data.length === 0" class="text-center py-16">
                        <div class="mx-auto h-24 w-24 text-gray-600 mb-4">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">No income records found</h3>
                        <p class="text-gray-400 mb-6">Start by adding your first income</p>
                    </div>

                    <div v-else class="mt-6 mb-6">
                        <div class="hidden md:block relative overflow-x-auto rounded-xl border border-gray-700/50">
                            <table class="w-full text-sm text-left text-gray-400">
                                <thead class="text-xs uppercase bg-slate-700/50 text-gray-300">
                                    <tr>
                                        <th scope="col" class="px-6 py-4">Date</th>
                                        <th scope="col" class="px-6 py-4">Type</th>
                                        <th scope="col" class="px-6 py-4">Account</th>
                                        <th scope="col" class="px-6 py-4">Description</th>
                                        <th scope="col" class="px-6 py-4">Amount</th>
                                        <th scope="col" class="px-6 py-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(income, index) in incomes_data.slice(from, to)" :key="index" class="bg-slate-800/30 border-b border-gray-700/50 hover:bg-slate-700/30 transition-colors">
                                        <td class="px-6 py-4 font-medium text-white">
                                            {{ income.income_date }}
                                        </td>
                                        <td class="px-6 py-4 font-medium text-white">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-300 border border-green-500/30">
                                                {{ income.budget_type_name }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-300">
                                            {{ income.account_name }}
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-300">
                                            {{ income.description }}
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-green-400 text-lg">
                                            {{ income.amount }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <button @click="edit_record(income.id)" class="font-medium text-blue-400 hover:text-blue-300 transition-colors">
                                                Edit
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <nav class="flex items-center flex-wrap justify-between p-4 bg-slate-700/30" aria-label="Table navigation">
                                <span class="text-sm font-normal text-gray-400 mb-4 md:mb-0">
                                    Showing 
                                    <span class="font-semibold text-white">{{ from + 1 }}-{{ Math.min(to, incomes_data.length) }}</span> 
                                    of 
                                    <span class="font-semibold text-white">{{ total_data }}</span>
                                </span>
                                <ul class="inline-flex -space-x-px text-sm h-8">
                                    <li v-for="i in totalInstances" :key="i" @click="move_page(i)">
                                        <button 
                                            :class="{
                                                'bg-blue-500 text-white border-blue-500': current_page === i,
                                                'text-gray-400 bg-slate-700/50 border-gray-600 hover:bg-slate-700 hover:text-white': current_page !== i
                                            }"
                                            class="flex items-center justify-center px-3 h-8 leading-tight border transition-colors"
                                        >
                                            {{ i }}
                                        </button>
                                    </li>
                                </ul>
                                <button @click="get_more_incomes" class="font-semibold text-blue-400 hover:text-blue-300 transition-colors">
                                    Load More
                                </button>
                            </nav>
                        </div>

                        <div class="block md:hidden space-y-4" ref="scrollContainer">
                            <div 
                                v-for="(income, index) in incomes_data" 
                                :key="index"
                                class="p-6 rounded-2xl bg-slate-800/50 border border-gray-700/50 backdrop-blur-sm hover:border-green-500/50 transition-all duration-300"
                            >
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h3 class="text-xl font-bold text-white mb-1">
                                            {{ income.budget_type_name }}
                                        </h3>
                                        <p class="text-sm text-gray-400">{{ income.income_date }}</p>
                                    </div>
                                    <span class="text-xl font-bold text-green-400">
                                        {{ income.amount }}
                                    </span>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-sm text-gray-300">
                                        <span class="text-gray-500">Account:</span> {{ income.account_name }}
                                    </p>
                                    <p class="text-sm text-gray-300">
                                        <span class="text-gray-500">Description:</span> {{ income.description }}
                                    </p>
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-700/50">
                                    <button 
                                        @click="edit_record(income.id)" 
                                        class="text-sm font-medium text-blue-400 hover:text-blue-300 transition-colors"
                                    >
                                        Edit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <IncomeModal :show="showModal" :id=income_id @close="handle_decline" @accept="handle_accept" @decline="handle_decline" />
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { useInfiniteScroll } from '@vueuse/core';
import axios from '../lib/axios';
import IncomeModal from '../components/IncomeModal.vue';

const scrollContainer = ref(null)
const hasMoreData = ref(true)

const loading = ref(false);
const error = ref(null);
const incomes_data = ref([]);
const showModal = ref(false);
const income_id = ref(false);
const current_page = ref(0);

const page_limits = 30;
const from = ref(0);
const to = ref(page_limits);
let skip = 0;
let total_data = 0;

onMounted(() => {
  get_all_incomes();
});

const totalInstances = computed(() => {
  return Math.ceil(incomes_data.value.length / page_limits);
});

async function get_all_incomes() {
  loading.value = true;

  try {
    const response = await axios.get('api/incomes', {skip: skip});
    incomes_data.value.push(...response.data.income || []);
    total_data = response.data.income.length;

  } catch (error) {
    error.value = 'Failed to load incomes'  
  } finally {
    loading.value = false;

    if (total_data == page_limits) {
      get_more_incomes();
      move_page(1);
    }
  }
}

function move_page(index) {
  let page = index - 1;
  const totalPages = Math.ceil(incomes_data.value.length / page_limits);
  
  if (page < 0) page = 0;
  if (page >= totalPages) page = totalPages - 1;
  
  from.value = page_limits * page;
  to.value = Math.min(page_limits * (page + 1), incomes_data.value.length);
  
  current_page.value = index;
}

const { reset } = useInfiniteScroll(scrollContainer, () => {
    if (total_data >= page_limits) {
      get_more_incomes();
    }
  },
  {
    canLoadMore: () => {
      return hasMoreData.value;
    },
  }
)

async function get_more_incomes() {
  if (total_data > 0) {
    if (loading.value) return false;
    
    skip += page_limits;
    try {
      const response = await axios.get('api/incomes', {skip: skip});
      if (response.data.income.length > 0) {
        incomes_data.value.push(...response.data.income || []);
        total_data += response.data.income.length;
        
        if (response.data.income.length < page_limits) {
          hasMoreData.value = false;
        }
        
        return true;
      } else {
        hasMoreData.value = false;
        return false;
      }
    } catch (error) {
      error.value = error.response?.data?.message || error.message || 'Failed to load incomes'
      return false;
    } finally {
      loading.value = false;
    }
  }
}

function edit_record(id) {
  income_id.value = id;
  showModal.value = true;
}

function close_modal() {
  showModal.value = false;
  this.$router.go();
}

function handle_decline() {
  close_modal();
}

function handle_accept() {
  close_modal();
}
</script>

<style scoped>

</style>