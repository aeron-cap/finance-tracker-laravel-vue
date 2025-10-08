<template>
    <div class="min-h-screen pb-20">
        <div class="h-full px-4 py-6 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="mb-8">
                    <h1 class="text-4xl sm:text-5xl font-bold text-white">Budgets</h1>
                    <p class="mt-2 text-lg text-gray-400">
                        Manage and track your budgets
                    </p>
                </div>

                <div v-if="loading" class="flex justify-center items-center h-64">
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

                <div v-else class="h-full">
                    <div v-if="budgets_data.length === 0" class="text-center py-16">
                        <div class="mx-auto h-24 w-24 text-gray-600 mb-4">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">No budgets found</h3>
                        <p class="text-gray-400 mb-6">Get started by creating your first budget</p>
                    </div>

                    <div v-else class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="group p-6 rounded-2xl bg-slate-800/50 border border-gray-700/50 backdrop-blur-sm hover:border-blue-500/50 transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-blue-500/20">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl group-hover:scale-110 transition-transform">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-400">Total Budgets</p>
                                        <p class="text-3xl font-bold text-white">{{ budgets_data.length }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="group p-6 rounded-2xl bg-slate-800/50 border border-gray-700/50 backdrop-blur-sm hover:border-green-500/50 transition-all duration-300 hover:scale-105 hover:shadow-xl hover:shadow-green-500/20">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 p-3 bg-gradient-to-br from-green-400 to-green-600 rounded-xl group-hover:scale-110 transition-transform">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-400">Active Budgets</p>
                                        <p class="text-3xl font-bold text-white">{{ budgets_data.length }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 rounded-2xl bg-slate-800/50 border border-gray-700/50 backdrop-blur-sm">
                            <div class="max-w-md mb-6">
                                <label for="budget_id" class="block text-sm font-medium text-gray-300 mb-3">
                                    Select a budget to view details
                                </label>
                                <select 
                                    id="budget_id"
                                    @change="show_budget($event.target.value)" 
                                    class="w-full bg-slate-700/50 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-3 backdrop-blur-sm transition-all">
                                    <option value="" selected>Choose a budget</option>
                                    <option 
                                        v-for="budget in budgets_data" 
                                        :key="budget.id" 
                                        :value="budget.id">
                                        {{ budget.budget_name }}
                                    </option>
                                </select>
                            </div>

                            <div v-if="showBudget">
                                <div class="relative overflow-x-auto rounded-xl border border-gray-700/50">
                                    <table class="w-full text-sm text-left text-gray-400">
                                        <caption class="p-6 bg-gradient-to-r from-slate-800/80 to-slate-800/60 backdrop-blur-sm border-b border-gray-700/50">
                                            <div class="flex items-center justify-between flex-wrap gap-4">
                                                <div class="flex-1">
                                                    <span class="block text-2xl font-bold text-white">{{ selected_budget.budget_name }}</span>
                                                    <p class="mt-2 text-sm font-medium text-gray-300 flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        {{ $formatToDecimal(selected_budget.amount_to_budget) }} - {{ selected_budget.cutoff.name }}
                                                    </p>
                                                </div>
                                                <div class="flex items-center space-x-4">
                                                    <button 
                                                        @click="edit_budget(selected_budget.id)" 
                                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-all duration-200 hover:scale-105 hover:shadow-lg hover:shadow-blue-500/50"
                                                    >
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                        Edit
                                                    </button>
                                                    <div class="flex items-center space-x-2">
                                                        <label class="text-sm font-medium text-gray-300">Default</label>
                                                        <input 
                                                            type="radio" 
                                                            :checked="selected_budget.is_default === 1"
                                                            :value="1"
                                                            class="w-4 h-4 text-blue-600 bg-slate-700 border-gray-600 rounded focus:ring-blue-500 focus:ring-2 transition-all duration-200"
                                                            @change="make_default(selected_budget.id)"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </caption>
                                        <thead class="text-xs uppercase bg-slate-700/50 text-gray-300">
                                            <tr>
                                                <th scope="col" class="px-6 py-4 text-center font-bold tracking-wide">
                                                    <div class="flex items-center justify-center space-x-2">
                                                        <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span>Type</span>
                                                    </div>
                                                </th>
                                                <th scope="col" class="px-6 py-4 text-center font-bold tracking-wide">
                                                    <div class="flex items-center justify-center space-x-2">
                                                        <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span>Amount</span>
                                                    </div>
                                                </th>
                                                <th scope="col" class="px-6 py-4 text-center font-bold tracking-wide">
                                                    <div class="flex items-center justify-center space-x-2">
                                                        <svg class="w-4 h-4 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span>Description</span>
                                                    </div>
                                                </th>
                                                <th scope="col" class="px-6 py-4 text-center font-bold tracking-wide">
                                                    <div class="flex items-center justify-center space-x-2">
                                                        <svg class="w-4 h-4 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span>Is Used</span>
                                                    </div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(budget, i) in selected_budget.budget_details" :key="i" class="bg-slate-800/30 border-b border-gray-700/50 hover:bg-slate-700/30 transition-colors">
                                                <th scope="row" class="text-center px-6 py-5 font-semibold text-white">
                                                    <div class="flex items-center justify-center">
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-300 border border-blue-500/30">
                                                            {{ budget.budget_type_name }}
                                                        </span>
                                                    </div>
                                                </th>
                                                <td class="text-center px-6 py-5">
                                                    <span class="font-semibold text-green-400 text-lg">
                                                        {{ $formatToDecimal(budget.amount) }}
                                                    </span>
                                                </td>
                                                <td class="text-center px-6 py-5">
                                                    <span class="text-gray-300 font-medium">
                                                        {{ budget.description }}
                                                    </span>
                                                </td>
                                                <td class="text-center px-6 py-5">
                                                    <div class="flex items-center justify-center">
                                                        <label class="relative inline-flex items-center cursor-pointer">
                                                            <input 
                                                                type="checkbox" 
                                                                v-model="budget.is_used" 
                                                                :true-value="1" 
                                                                :false-value="0" 
                                                                class="sr-only peer"
                                                                @change="update_is_used(budget.id, budget)"
                                                            />
                                                            <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-500/50 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <BudgetModal :show="showModal" :id=budget_id @close="handle_decline()" @accept="handle_accept" @decline="handle_decline()" />
</template>

<script setup>
  import { onMounted, ref } from "vue";
  import axios from "../lib/axios";
  import BudgetModal from "../components/BudgetModal.vue";

  const budgets_data = ref([]);
  const loading = ref(false);
  const error = ref(null);
  const showModal = ref(false);
  const budget_id = ref(null);
  const showBudget = ref(false);
  const selected_budget = ref([]);

  onMounted(() => {
      get_all_budgets();
  });

  async function get_all_budgets() {
    loading.value = true;
    error.value = null;
    
    try {
      const response = await axios.get('api/budgets');
      budgets_data.value = response.data.budgets || [];

      for ( let x in budgets_data.value ) {
        let budgets = budgets_data.value[x];

        if (budgets.is_default == 1) {
          show_budget(budgets.id);
        }
      }
    } catch (err) {
      error.value = 'Failed to load budgets';
    } finally {
      loading.value = false;
    }
  }

  function show_budget(id) {
    let budget = budgets_data.value.filter((v) => v.id == parseInt(id))[0];
    if (budget['id'] !== undefined) {
      showBudget.value = true;
      selected_budget.value = budget;
    } else {
      showBudget.value = false;
    }
  }

  function update_is_used(id, budget_detail) {
    try {
      axios.post(`/api/budget_detail-is_used/${id}`, {
        'is_used': budget_detail.is_used
      }).then((response) => {});
    } catch (err) {}
  }

  function make_default(id) {
    try {
      axios.post(`/api/budget_detail-is_default/${id}`).then((response) => {
        get_all_budgets();
      });
    } catch (err) {}
  }

  function close_modal() {
      showModal.value = false;
      get_all_budgets();
  }

  function edit_budget(id) {
      showModal.value = true;
      budget_id.value = id;
  }

  function handle_accept() {
      close_modal();
  }

  function handle_decline() {
      close_modal();
  }
</script>

<style scoped>
</style>