<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto bg-black bg-opacity-50">
        <div class="relative p-4 w-full max-w-4xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Create Income Record
                    </h3>
                    <button 
                        type="button" 
                        @click="decline_action"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5 space-y-6">
                    <form @submit.prevent="accept_action" class="space-y-6">
                        <!-- Income Information Section -->
                        <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Income Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="Income-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Income Date</label>
                                    <input 
                                      type="date" 
                                      id="income-date" 
                                      v-model="income_data.income_date"
                                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                      required>
                                </div>
                                
                                <div>
                                    <label for="status-select" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                      Budget Type
                                    </label>
                                    <select 
                                      :id="`budget-type`"
                                      v-model="income_data.budget_type_id"
                                      @change="update_budget_type()"
                                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                      required>
                                      <option value=null></option>
                                      <option 
                                          v-for="type in income_budget_types" 
                                          :key="type.id" 
                                          :value="type.id">
                                          {{ type.name }}
                                      </option>
                                    </select>
                                </div>

                                <div>
                                  <label for="amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total Budget Amount</label>
                                  <input 
                                      type="number" 
                                      id="amount" 
                                      v-model="income_data.amount"
                                      step="0.01"
                                      min="0"
                                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                      placeholder="Enter total amount"
                                      required>
                                </div>

                                <div>
                                    <label for="account-select" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Account</label>
                                    <select 
                                        id="account-select" 
                                        v-model="income_data.account_id"
                                        @change="update_account()"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required>
                                        <option value=null></option>
                                        <option 
                                            v-for="account in accounts" 
                                            :key="account.id" 
                                            :value="account.id">
                                            {{ account.name }}
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label for="budget-select" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Budget</label>
                                    <select 
                                        id="budget-select" 
                                        v-model="income_data.budget_id"
                                        @change="update_budget_name()"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        >
                                        <option value=null></option>
                                        <option 
                                            v-for="budget in budgets" 
                                            :key="budget.id" 
                                            :value="budget.id">
                                            {{ budget.budget_name }}
                                        </option>
                                    </select>
                                </div>

                                <div>
                                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                  <textarea 
                                      id="description"
                                      v-model="income_data.description"
                                      rows="2" 
                                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                      placeholder="Describe this income record..."></textarea>
                                </div>

                            </div>


                        </div>


                    </form>
                </div>
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button 
                        @click="accept_action" 
                        type="button" 
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Create Income Record
                    </button>
                    <button 
                        @click="decline_action" 
                        type="button" 
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Cancel
                    </button>
                    <button 
                        v-if="props.id !== null"
                        @click="delete_record" 
                        type="button" 
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-red-900 focus:outline-none bg-white rounded-lg border border-red-200 hover:bg-gray-100 hover:text-red-700 focus:z-10 focus:ring-4 focus:ring-red-100 dark:focus:ring-red-700 dark:bg-red-800 dark:text-red-400 dark:border-red-600 dark:hover:text-white dark:hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue';
import axios from '../lib/axios';

onMounted(() => {
  get_accounts();
  get_budget_types();
  get_budgets();
});

const accounts = ref([]);
const income_budget_types = ref([]);
const budgets = ref([]);

const props = defineProps({
  show: {
    type: Boolean,
    default: false
  },
  id: {
    type: Number,
    default: null
  }
});

const emit = defineEmits(['close', 'accept', 'decline']);

const income_data = ref({
  income_date: '',
  budget_type_id: null,
  budget_type_name: '',
  account_id: null,
  account_name: '',
  amount: null,
  description: '',
  status_id: 1,
  status_name: 'New',
  budget_id: null,
})

watch(() => props.show, (newValue) => {
  if (!newValue || props.id == null) {
    income_data.value.income_date = new Date().toISOString().slice(0, 10);
    income_data.value.budget_type_id = null,
    income_data.value.budget_type_name = '',
    income_data.value.account_id = null,
    income_data.value.account_name = '',
    income_data.value.amount = null,
    income_data.value.description = '',
    income_data.value.status_id = 1,
    income_data.value.status_name = 'New',
    income_data.value.budget_id = ''
  }
})

async function get_accounts() {
  try {
    const response = await axios.post('api/accounts');
    const raw = response.data.accounts || {};
    accounts.value = Array.isArray(raw) ? raw : Object.values(raw);
  }catch (error) {}
}

function get_budget_types() {
  try {
    axios.post('api/budget_types', {type: 'Income'}).then((response) => {
      const raw = response.data.budget_types || {};
      income_budget_types.value = Array.isArray(raw) ? raw : Object.values(raw);
    })
  }catch (error) {}
}

async function get_budgets() {
  try {
    await axios.post('api/budgets').then((response) => {
      budgets.value = response.data.budgets || [];
    })
  }catch (error) {}
}

function update_budget_type() {
  const selected_budget_type = income_budget_types.value.find(
    j => j.id === income_data.value.budget_type_id
  );

  if (selected_budget_type) {
    income_data.value.budget_type_name = selected_budget_type.name;
  } else {
    income_data.value.budget_type_name = '';
  }
}

function update_account() {
  const selected_account = accounts.value.find(
    j => j.id === income_data.value.account_id
  );

  if (selected_account) {
    income_data.value.account_name = selected_account.name;
  } else {
    income_data.value.account_name = '';
  }
}

function update_budget_name() {
  const selected_budget = budgets.value.find(
    j => j.id === income_data.value.budget_id
  );

  if (selected_budget) {
    income_data.value.budget_name = selected_budget.name;
  } else {
    income_data.value.budget_name = '';
  }
}

function decline_action() {
  emit('decline');
}

function close_modal() {
  emit('close');
}

// ToDo: save function and table view for incomes, and also edit
function accept_action() {
  if (
    !income_data.value.income_date || 
    !income_data.value.budget_type_id || 
    !income_data.value.budget_type_name || 
    !income_data.value.account_id || 
    !income_data.value.account_name ||
    !income_data.value.amount ||
    !income_data.value.description ||
    !income_data.value.status_id ||
    !income_data.value.status_name ||
    !income_data.value.budget_id
  ) {
    alert('Please fill in all required budget fields');
    return;
  }

  if(props.id > 0) {
    try {
      axios.post(`/api/income/${props.id}`, income_data.value).then((response) => {
        console.log(response);
      });
    } catch (err) {}
  } else {
    try {
      axios.post('/api/income', income_data.value).then((response) => {
        console.log(response);
      });
    } catch (err) {}
  }

  emit('accept', {
    ...income_data.value
  });
}
</script>

<style lang="scss" scoped>

</style>