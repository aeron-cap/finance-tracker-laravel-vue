<template>
    <div class="h-fit bg-gray-50 dark:bg-gray-900 pb-20">
          <div class="h-full px-4 py-6 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Investments/Goals</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Manage your Investments/Goals
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
                <!-- <div v-if="accounts_data.length === 0" class="place-items-center pt-6 pb-6">
                    <div>
                        <span class="px-6 py-4 text-center text-gray-500"> No accounts found </span>
                    </div>
                </div>
                <div class="grid pt-6 pb-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                  <div v-for="(account, index) in accounts_data" :key="account.id" class="w-full">
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
                      
                      <div class="px-6 pt-6 pb-4 border-b border-gray-100 dark:border-gray-700">
                        <div class="flex items-start justify-between">
                          <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2 leading-tight">
                            {{ account.name }}
                          </h3>
                          <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                            {{ account.status.name }}
                          </span>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                          {{ account.description }}
                        </p>
                      </div>

                      <div class="px-6 py-4">
                        <div class="grid grid-cols-2 gap-4">
                          <div class="text-center">
                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">
                              Expected
                            </div>
                            <div class="text-lg font-bold text-yellow-600 dark:text-yellow-400">
                              P{{ account.expected_balance }}
                            </div>
                          </div>
                          
                          <div class="text-center">
                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">
                              Actual
                            </div>
                            <div class="relative">
                              <input 
                                type="text" 
                                :value="account.actual_balance ? parseFloat(account.actual_balance).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) : ''"
                                @input="account.actual_balance = parseFloat($event.target.value.replace(/,/g, '')) || 0"
                                @blur="$event.target.value = parseFloat($event.target.value.replace(/,/g, '') || 0).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})"
                                class="w-full text-center text-lg font-bold border-0 bg-transparent text-green-600 dark:text-green-400 focus:ring-2 focus:ring-blue-500 focus:bg-white dark:focus:bg-gray-700 rounded-md py-1 transition-all"
                                placeholder="0.00"
                              />
                            </div>
                          </div>
                        </div>
                        
                        <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
                          <div class="flex items-center justify-center" v-if="account.expected_balance && account.actual_balance">
                            <span 
                              :class="{
                                'text-green-600 dark:text-green-400': parseFloat(account.actual_balance) >= parseFloat(account.expected_balance),
                                'text-red-600 dark:text-red-400': parseFloat(account.actual_balance) < parseFloat(account.expected_balance)
                              }"
                              class="text-sm font-medium flex items-center"
                            >
                              <svg v-if="parseFloat(account.actual_balance) >= parseFloat(account.expected_balance)" class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                              </svg>
                              <svg v-else class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                              </svg>
                              {{ parseFloat(account.actual_balance) >= parseFloat(account.expected_balance) ? 'On Track' : 'Below Target' }}
                              <span class="ml-1">
                                (${{ Math.abs(parseFloat(account.actual_balance || 0) - parseFloat(account.expected_balance || 0)).toFixed(2) }})
                              </span>
                            </span>
                          </div>
                        </div>
                      </div>

                      <div class="px-6 py-4">
                        <div class="flex space-x-3">
                          <button
                            @click="edit_account(account.id)"
                            class="flex-1 inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:text-white dark:border-gray-500 dark:hover:bg-gray-700 dark:focus:ring-gray-700 transition-colors"
                            type="button"
                          >
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                          </button>
                          <button
                            @click="edit_actual_balance(account.id, account.actual_balance)"
                            class="flex-1 inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 transition-colors"
                            type="button"
                          >
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Save
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> -->
            </div>
        </div>

    </div>
</template>

<script setup>

</script>

<style lang="scss" scoped>

</style>