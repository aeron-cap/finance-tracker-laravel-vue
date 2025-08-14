<template>
    <div class="h-fit bg-gray-50 dark:bg-gray-900 pb-20">
        <div class="h-full px-4 py-6 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Budgets</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Manage and track your budgets
                </p>
            </div>

            <!-- Loading State -->
            <div v-if="loading" class="flex justify-center items-center h-64">
                <div role="status">
                    <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C0 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <!-- Error State -->
            <div v-else-if="error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Error</h3>
                        <p class="mt-1 text-sm text-red-700">{{ error }}</p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div v-else class="h-full">
                <!-- Empty State -->
                <div v-if="budgets_data.length === 0" class="text-center py-16">
                    <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">No budgets found</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">Get started by creating your first budget</p>
                </div>

                <!-- Budget Selection and Grid -->
                <div v-else class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4 mt-8">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Budgets</p>
                                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ budgets_data.length }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Add more stats cards as needed -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Budgets</p>
                                    <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ budgets_data.length }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Budget Selector -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div class="max-w-md">
                            <label for="budget_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                Select a budget to view details
                            </label>
                            <select 
                                id="budget_id"
                                @change="show_budget($event.target.value)" 
                                class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-3 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                          <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                              <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                  <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                                      {{ selected_budget.budget_name }}
                                      <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">{{ selected_budget.amount_to_budget }} - {{ selected_budget.cutoff.name }}</p>
                                  </caption>
                                  <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                      <tr>
                                          <th scope="col" class="px-6 py-3 text-center">
                                              Type
                                          </th>
                                          <th scope="col" class="px-6 py-3 text-center">
                                              Amount
                                          </th>
                                          <th scope="col" class="px-6 py-3 text-center">
                                              Description
                                          </th>
                                          <th scope="col" class="px-6 py-3 text-center">
                                              Is Used
                                          </th>
                                          <th scope="col" class="px-6 py-3 text-center">
                                              Action
                                          </th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <tr v-for=" (budget, i) in selected_budget.budget_details"class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                          <th scope="row" class=" text-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                              {{ budget.budget_type_name }}
                                          </th>
                                          <td class="text-center px-6 py-4">
                                              {{ budget.amount }}
                                          </td>
                                          <td class="text-center px-6 py-4">
                                              {{ budget.description }}
                                          </td>
                                          <td class="text-center px-6 py-4">
                                            <input 
                                              type="checkbox" 
                                              v-model="budget.is_used" 
                                              :true-value="1" 
                                              :false-value="0" 
                                              class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded 
                                                    focus:ring-blue-500 dark:focus:ring-blue-600 
                                                    dark:ring-offset-gray-800 focus:ring-2 
                                                    dark:bg-gray-700 dark:border-gray-600"
                                            />
                                          </td>
                                          <td class="px-6 py-4 text-center">
                                              <a @click="edit_budget(selected_budget.id)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
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
    const response = await axios.post('api/budgets');
    budgets_data.value = response.data.budgets || [];
  } catch (err) {
    error.value = err.response?.data?.message || err.message || 'Failed to load budgets';
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

<style lang="scss" scoped>
</style>