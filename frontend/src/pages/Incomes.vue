<template>
    <div class="h-fit bg-gray-50 dark:bg-gray-900 pb-20">
        <div class="h-full px-4 py-6 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Incomes</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Manage your Income flow {{ isScrolling }}
                </p>
            </div>

            <div v-if="loading" class="flex justify-center items-center py-8">
                <div role="status">
                    <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C0 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <div v-else-if="error" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mx-4 my-4">
                <strong>Error:</strong> {{ error }}
            </div>

            <div v-else class="relative overflow-x-auto overflow-y-auto">
                <div v-if="incomes_data.length === 0" class="place-items-center pt-6 pb-6">
                    <div>
                        <span class="px-6 py-4 text-center text-gray-500"> No income records found </span>
                    </div>
                </div>
                <div v-else class="mt-6 mb-6">
                  <!-- table for big screens -->
                  <div class="hidden md:block relative overflow-x-auto sm:rounded-lg">
                      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                              <th scope="col" class="px-6 py-3">
                                  Date
                              </th>
                              <th scope="col" class="px-6 py-3">
                                  Type
                              </th>
                              <th scope="col" class="px-6 py-3">
                                  Account
                              </th>
                              <th scope="col" class="px-6 py-3">
                                  Description
                              </th>
                              <th scope="col" class="px-6 py-3">
                                  Amount
                              </th>
                              <th scope="col" class="px-6 py-3">
                                  Action
                              </th>
                            </tr>
                          </thead>
                          <tbody v-for="(income, index) in incomes_data.slice(from, to)">
                            <tr class="cursor-pointer bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ income.income_date }}
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ income.budget_type_name }}
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ income.account_name }}
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ income.description }}
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ income.amount }}
                                </td>
                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                  <span @click="edit_record(income.id)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    Edit
                                  </span>
                                </td>
                            </tr>
                          </tbody>
                      </table>
                      <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4" aria-label="Table navigation">
                          <span class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">Showing 
                            <span class="font-semibold text-gray-900 dark:text-white">
                            {{ from + 1 }}-{{ Math.min(to, incomes_data.length) }}
                            </span> of
                            <span class="font-semibold text-gray-900 dark:text-white">
                              {{ total_data }}
                            </span>
                          </span>
                          <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
                          <div v-for="i in totalInstances" :key="i">
                            <li @click="move_page(i)">
                              <button 
                                :class="{
                                  '!bg-blue-500 !text-white !border-blue-500': current_page === i
                                }"
                                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                              >
                                {{ i }}
                              </button>
                            </li>
                          </div>
                          </ul>
                          <span @click="get_more_incomes" class="font-semibold text-gray-900 dark:text-white hover:underline">
                            Load More
                          </span>
                      </nav>
                  </div>

                  <!-- cards for small -->
                  <div class="block md:hidden sm:ml-6">
                    <div ref="scrollContainer">
                      <div 
                        v-for="(income, index) in incomes_data" 
                        class="grid pt-2 pb-2 grid-cols-1 gap-2 justify-items-center"
                      >
                        <div class="w-full max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                          <a>
                            <p class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                              {{ income.budget_type_name }} <a class="text-sm text-gray-700 dark:text-gray-400">- {{ income.income_date }}</a>
                            </p>
                          </a>
                          <p class="font-normal mb-2 text-gray-700 dark:text-gray-400">
                            {{income.account_name}} - {{ income.amount }}
                          </p>
                          <div class="flex justify-between items-center">
                            <span class="font-normal text-gray-700 dark:text-gray-400">
                              {{ income.description }}
                            </span>
                            <span 
                              @click="edit_record(income.id)" 
                              class="font-medium text-blue-600 dark:text-blue-500 hover:underline cursor-pointer"
                            >
                              Edit
                            </span>
                          </div>
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
import { computed, onMounted, ref, useTemplateRef } from 'vue';
import { useInfiniteScroll } from '@vueuse/core';
import axios from '../lib/axios';
import IncomeModal from '../components/IncomeModal.vue';

// :class="{ 'blur-xs mb-8 sticky top-0 z-50': isScrolling }"

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
    error.value = error.response?.data?.message || error.message || 'Failed to load incomes'  
  } finally {
    loading.value = false;
    // get more atleast 2 more times
    for (let i = 0; i < 2; i++) {
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
    get_more_incomes();
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
  get_all_incomes();
}

function handle_decline() {
  close_modal();
}

function handle_accept() {
  close_modal();
}


</script>

<style lang="scss" scoped>

</style>