<template>
    <div class="min-h-screen pb-20">
        <div class="h-full px-4 py-6 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="mb-8">
                    <h1 class="text-4xl sm:text-5xl font-bold text-white">Accounts</h1>
                    <p class="mt-2 text-lg text-gray-400">
                        Manage your Accounts
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
                    <div v-if="accounts_data.length === 0" class="text-center py-16">
                        <div class="mx-auto h-24 w-24 text-gray-600 mb-4">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">No accounts found</h3>
                        <p class="text-gray-400 mb-6">Start by adding your first account</p>
                    </div>

                    <div v-else>
                        <div class="grid pt-6 pb-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div v-for="(account, index) in accounts_data" :key="account.id" class="w-full">
                                <div class="rounded-2xl bg-slate-800/50 border border-gray-700/50 backdrop-blur-sm hover:border-purple-500/50 transition-all duration-300 overflow-hidden">
                                    
                                    <div class="px-6 pt-6 pb-4 border-b border-gray-700/50">
                                        <div class="flex items-start justify-between">
                                            <h3 class="text-xl font-bold text-white mb-2 leading-tight">
                                                {{ account.name }}
                                            </h3>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-300 border border-yellow-500/30">
                                                {{ account.status.name }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-400 line-clamp-2">
                                            {{ account.description }}
                                        </p>
                                    </div>

                                    <div class="px-6 py-4">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="text-center">
                                                <div class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">
                                                    Expected
                                                </div>
                                                <div class="text-lg font-bold text-yellow-400">
                                                    P{{ account.expected_balance }}
                                                </div>
                                            </div>
                                            
                                            <div class="text-center">
                                                <div class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">
                                                    Actual
                                                </div>
                                                <div class="relative">
                                                    <input 
                                                        type="text" 
                                                        :value="account.actual_balance ? parseFloat(account.actual_balance).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) : ''"
                                                        @input="account.actual_balance = parseFloat($event.target.value.replace(/,/g, '')) || 0"
                                                        @blur="$event.target.value = parseFloat($event.target.value.replace(/,/g, '') || 0).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})"
                                                        class="w-full text-center text-lg font-bold border-0 bg-transparent text-green-400 focus:ring-2 focus:ring-blue-500 focus:bg-slate-700/50 rounded-md py-1 transition-all"
                                                        placeholder="0.00"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-3 pt-3 border-t border-gray-700/50">
                                            <div class="flex items-center justify-center" v-if="account.expected_balance && account.actual_balance">
                                                <span 
                                                    :class="{
                                                        'text-green-400': parseFloat(account.actual_balance) >= parseFloat(account.expected_balance),
                                                        'text-red-400': parseFloat(account.actual_balance) < parseFloat(account.expected_balance)
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
                                                class="flex-1 inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-gray-300 bg-slate-700/50 border border-gray-600 rounded-lg hover:bg-slate-700 transition-all"
                                                type="button"
                                            >
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Edit
                                            </button>
                                            <button
                                                @click="edit_actual_balance(account.id, account.actual_balance)"
                                                class="flex-1 inline-flex justify-center items-center px-3 py-2 text-sm font-medium text-white bg-gradient-to-r from-green-500 to-green-600 rounded-lg hover:from-green-600 hover:to-green-700 transition-all hover:scale-105 hover:shadow-lg hover:shadow-green-500/50"
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
                        </div>

                        <div class="mt-8 p-6 rounded-2xl bg-slate-800/50 border border-gray-700/50 backdrop-blur-sm">
                            <div class="max-w-md mb-6">
                                <label for="account_id" class="block text-sm font-medium text-gray-300 mb-3">
                                    Select an account to view details
                                </label>
                                <select  
                                    id="account_id"
                                    @change="show_breakdown($event.target.value)" 
                                    class="w-full bg-slate-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-3 transition-all [&>option]:bg-slate-800 [&>option]:text-white">
                                    <option value="" selected class="bg-slate-800">Choose account to see breakdown</option>
                                    <option 
                                        v-for="account in accounts_data" 
                                        :key="account.id" 
                                        :value="account.id"
                                        class="bg-slate-800">
                                        {{ account.name }}
                                    </option>
                                </select>
                            </div>

                            <div class="relative overflow-x-auto rounded-xl border border-gray-700/50">
                                <table class="w-full text-sm text-left text-gray-400">
                                    <thead class="text-xs uppercase bg-slate-700/50 text-gray-300">
                                        <tr>
                                            <th scope="col" class="px-6 py-4">Type</th>
                                            <th scope="col" class="px-6 py-4">Current Balance</th>
                                            <th scope="col" class="px-6 py-4">As of</th>
                                        </tr>
                                    </thead>

                                    <tbody v-if="id_to_breakdown > 0 && breakdown_summary[id_to_breakdown]">
                                        <tr 
                                            v-for="(type, index) in breakdown_summary[id_to_breakdown]" 
                                            :key="index" 
                                            class="bg-slate-800/30 border-b border-gray-700/50 hover:bg-slate-700/30 transition-colors"
                                        >
                                            <th scope="row" class="px-6 py-4 font-medium text-white">
                                                {{ index }}
                                            </th>
                                            <td class="px-6 py-4 font-semibold text-purple-400">
                                                P{{ Math.abs(parseFloat(type.total || 0)).toFixed(2) }}
                                            </td>
                                            <td class="px-6 py-4 text-gray-300">
                                                {{ type.as_of || '-' }}
                                            </td>
                                        </tr>
                                    </tbody>

                                    <tbody v-else>
                                        <tr>
                                            <td colspan="3" class="text-center py-8 text-gray-500">
                                                {{ id_to_breakdown > 0 ? 'No Breakdown Available' : 'Select an account to view breakdown' }}
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

    <AccountModal :show="showModal" :id="account_id" @close="close_modal" @accept="handle_accept" @decline="handle_decline" />
</template>

<script setup>
import { onMounted, ref } from 'vue';
import axios from '../lib/axios';
import AccountModal from '../components/AccountModal.vue';

const accounts_data = ref([]);
const loading = ref(false);
const error = ref(null);
const showModal = ref(false);
const account_id = ref(false);
const breakdown_summary = ref({});
const id_to_breakdown = ref(0);

onMounted(() => {
    get_all_accounts();
});

async function get_all_accounts() {
    loading.value = true;
    error.value = null;

    try {
        const response = await axios.get('api/accounts');
        accounts_data.value = response.data.accounts || [];
    } catch (err) {
        error.value = 'Failed to load accounts';
    } finally {
        loading.value = false;
    }
}

function create_account() {
    account_id.value = null;
    showModal.value = true;
}

function close_modal() {
    showModal.value = false;
    get_all_accounts();
}

function handle_decline() {
    close_modal();
}

function handle_accept() {
    showModal.value = false;
    get_all_accounts();
}

function edit_account(id) {
    account_id.value = id;
    showModal.value = true;
}

async function edit_actual_balance(id, balance) {
    console.log(id, balance);

    try {
        const response = await axios.post(`api/update-balance/${id}`, {
            actual_balance: balance,
        });
        get_all_accounts();
    } catch (error) {
    }
}

async function show_breakdown(id) {
    if (id !== "") {
      id_to_breakdown.value = id;
      
      if (!breakdown_summary.value[id]) {
        breakdown_summary.value[id] = [];
      }
      
      try {
        const response = await axios.post(`api/show-account-breakdown/${id}`);
        breakdown_summary.value[id] = response.data.breakdown_summary || [];
      } catch (error) {
        breakdown_summary.value[id] = [];
        id_to_breakdown.value = 0;
      }
    } else {
      id_to_breakdown.value = 0;
      breakdown_summary.value[0] = [];
    }
}
</script>

<style scoped>
</style>