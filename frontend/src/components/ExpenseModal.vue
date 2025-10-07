<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto bg-black/70 backdrop-blur-sm">
        <div class="relative p-4 w-full max-w-4xl max-h-full">
            <div class="relative bg-slate-800/60 backdrop-blur-md rounded-2xl shadow-2xl border border-gray-700/50 max-h-[90vh] flex flex-col">
                
                <div class="flex items-center justify-between p-6 border-b border-gray-700/50 flex-shrink-0">
                    <h3 class="text-2xl font-bold text-white">
                        {{ props.id ? 'Edit Expense Record' : 'Create Expense Record' }}
                    </h3>
                    <button 
                        type="button" 
                        @click="close_modal"
                        class="text-gray-400 hover:bg-slate-700/50 hover:text-white rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center transition-colors">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <div :class="{ 'disabled-div': loading }" class="p-6 space-y-6 overflow-y-auto flex-grow">
                    <form @submit.prevent="accept_action" class="space-y-6">
                        <div class="bg-slate-700/30 p-6 rounded-xl border border-gray-700/50">
                            <h4 class="text-lg font-semibold text-white mb-4">Expense Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="expense-date" class="block mb-2 text-sm font-medium text-gray-300">Expense Date</label>
                                    <input 
                                        type="date" 
                                        id="expense-date" 
                                        v-model="expense_data.expense_date"
                                        class="bg-slate-700/50 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all" 
                                        required>
                                </div>
                                
                                <div>
                                    <label for="budget-type" class="block mb-2 text-sm font-medium text-gray-300">Budget Type</label>
                                    <select 
                                        id="budget-type"
                                        v-model="expense_data.budget_type_id"
                                        @change="update_budget_type()"
                                        class="bg-slate-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all [&>option]:bg-slate-800 [&>option]:text-white"
                                        required>
                                        <option :value="null" class="bg-slate-800">Choose budget type</option>
                                        <option 
                                            v-for="type in expense_budget_types" 
                                            :key="type.id" 
                                            :value="type.id"
                                            class="bg-slate-800">
                                            {{ type.name }}
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label for="amount" class="block mb-2 text-sm font-medium text-gray-300">Amount</label>
                                    <input 
                                        type="number" 
                                        id="amount" 
                                        v-model="expense_data.amount"
                                        step="0.01"
                                        min="0"
                                        class="bg-slate-700/50 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 placeholder-gray-500 transition-all" 
                                        placeholder="Enter total amount"
                                        required>
                                </div>

                                <div>
                                    <label for="account-select" class="block mb-2 text-sm font-medium text-gray-300">Select Account</label>
                                    <select 
                                        id="account-select" 
                                        v-model="expense_data.account_id"
                                        @change="update_account()"
                                        class="bg-slate-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all [&>option]:bg-slate-800 [&>option]:text-white"
                                        required>
                                        <option :value="null" class="bg-slate-800">Choose account</option>
                                        <option 
                                            v-for="account in accounts" 
                                            :key="account.id" 
                                            :value="account.id"
                                            class="bg-slate-800">
                                            {{ account.name }}
                                        </option>
                                    </select>
                                </div>

                                <div>
                                    <label for="budget-select" class="block mb-2 text-sm font-medium text-gray-300">Select Budget</label>
                                    <select 
                                        id="budget-select" 
                                        v-model="expense_data.budget_id"
                                        @change="update_budget_name()"
                                        class="bg-slate-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all [&>option]:bg-slate-800 [&>option]:text-white">
                                        <option :value="null" class="bg-slate-800">Choose budget</option>
                                        <option 
                                            v-for="budget in budgets" 
                                            :key="budget.id" 
                                            :value="budget.id"
                                            class="bg-slate-800">
                                            {{ budget.budget_name }}
                                        </option>
                                    </select>
                                </div>

                                <div class="md:col-span-2">
                                    <label for="description" class="block mb-2 text-sm font-medium text-gray-300">Description</label>
                                    <textarea 
                                        id="description"
                                        v-model="expense_data.description"
                                        rows="3" 
                                        class="bg-slate-700/50 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 placeholder-gray-500 transition-all" 
                                        placeholder="Describe this expense record..."></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div :class="{ 'disabled-div': loading }" class="flex items-center gap-3 p-6 border-t border-gray-700/50 **sticky bottom-0 bg-slate-800/60 backdrop-blur-md rounded-b-2xl flex-shrink-0**">
                    <button
                        @click="accept_action" 
                        type="button" 
                        class="px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-lg transition-all hover:scale-105 hover:shadow-lg hover:shadow-blue-500/50">
                        {{ props.id ? 'Update Expense Record' : 'Create Expense Record' }}
                    </button>
                    <button 
                        @click="decline_action" 
                        type="button" 
                        class="px-6 py-3 text-sm font-medium text-gray-300 bg-slate-700/50 hover:bg-slate-700 rounded-lg border border-gray-600 transition-all">
                        Cancel
                    </button>
                    <button 
                        v-if="props.id !== null"
                        @click="delete_record" 
                        type="button" 
                        class="px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 rounded-lg transition-all hover:scale-105 hover:shadow-lg hover:shadow-red-500/50 ml-auto">
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

const accounts = ref([]);
const expense_budget_types = ref([]);
const budgets = ref([]);
const loading = ref(false);

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

const expense_data = ref({
  expense_date: '',
  budget_type_id: null,
  budget_type_name: '',
  account_id: null,
  account_name: '',
  amount: null,
  description: '',
  status_id: 1,
  status_name: 'New',
  budget_id: null,
  budget_name: '',
})

watch(() => props.show, (newValue) => {
  get_accounts();
  get_budget_types();
  get_budgets();

  if (!newValue || props.id == null) {
    expense_data.value.expense_date = new Date().toISOString().slice(0, 10);
    expense_data.value.budget_type_id = null,
    expense_data.value.budget_type_name = '',
    expense_data.value.account_id = null,
    expense_data.value.account_name = '',
    expense_data.value.amount = null,
    expense_data.value.description = '',
    expense_data.value.status_id = 1,
    expense_data.value.status_name = 'New',
    expense_data.value.budget_id = null,
    expense_data.value.budget_name = ''
  }

    if (props.id > 0) {
      get_expense_data(props.id);
  }
})

async function get_expense_data(id) {
  loading.value = true;
  try {
    const response = await axios.get(`api/expense/${id}`);
    let expense_from_db = response.data.expense || [];

    if (Object.keys(expense_from_db).length > 0) {
      set_expense_data(expense_from_db);
    }

  } catch (err) {}
  loading.value = false;
}

function set_expense_data (data) {
  expense_data.value.expense_date = data.expense_date;
  expense_data.value.budget_type_id = data.budget_type_id;
  expense_data.value.budget_type_name = data.budget_type_name;
  expense_data.value.account_id = data.account_id;
  expense_data.value.account_name = data.account_name;
  expense_data.value.amount = data.amount;
  expense_data.value.description = data.description;
  expense_data.value.status_id = data.status_id;
  expense_data.value.status_name = data.status_name;
  expense_data.value.budget_id = data.budget_id;
  expense_data.value.budget_name = data.budget_name;
}

async function get_accounts() {
  try {
    const response = await axios.get('api/accounts');
    const raw = response.data.accounts || {};
    accounts.value = Array.isArray(raw) ? raw : Object.values(raw);
  }catch (error) {}
}

async function get_budget_types() {
  try {
    axios.post('api/specific_budget_type', {type: 'Expense'}).then((response) => {
      const raw = response.data.budget_types || {};
      expense_budget_types.value = Array.isArray(raw) ? raw : Object.values(raw);
    })
  }catch (error) {}
}

async function get_budgets() {
  try {
    await axios.get('api/budgets').then((response) => {
      const raw = response.data.budgets || {};
      budgets.value = Array.isArray(raw) ? raw : Object.values(raw);
    })
  }catch (error) {}
}

function update_budget_type() {
  const selected_budget_type = expense_budget_types.value.find(
    j => j.id === expense_data.value.budget_type_id
  );

  if (selected_budget_type) {
    expense_data.value.budget_type_name = selected_budget_type.name;
  } else {
    expense_data.value.budget_type_name = '';
  }
}

function update_account() {
  const selected_account = accounts.value.find(
    j => j.id === expense_data.value.account_id
  );

  if (selected_account) {
    expense_data.value.account_name = selected_account.name;
  } else {
    expense_data.value.account_name = '';
  }
}

function update_budget_name() {
  const selected_budget = budgets.value.find(
    j => j.id === expense_data.value.budget_id
  );

  if (selected_budget) {
    expense_data.value.budget_name = selected_budget.budget_name;
  } else {
    expense_data.value.budget_name = '';
  }
}

function decline_action() {
  emit('decline');
}

function close_modal() {
  emit('close');
}

function delete_record() {
    if(props.id > 0) {
      try {
          axios.post(`/api/expense-delete/${props.id}`, expense_data.value).then((response) => {
              close_modal();
          });
      } catch (err) {}
  }
}

function accept_action() {
  if (
    !expense_data.value.expense_date || 
    !expense_data.value.budget_type_id || 
    !expense_data.value.budget_type_name || 
    !expense_data.value.account_id || 
    !expense_data.value.account_name ||
    !expense_data.value.amount ||
    !expense_data.value.description ||
    !expense_data.value.status_id ||
    !expense_data.value.status_name
  ) {
    alert('Please fill in all required budget fields');
    return;
  }

  if(props.id > 0) {
    try {
      axios.post(`/api/expense/${props.id}`, expense_data.value).then((response) => {
        console.log(response);

        emit('accept', {
          ...expense_data.value
        });
      });
    } catch (err) {}
  } else {
    try {
      axios.post('/api/expense', expense_data.value).then((response) => {
        console.log(response);

        emit('accept', {
          ...expense_data.value
        });
      });
    } catch (err) {}
  }
}
</script>

<style scoped>
  .disabled-div {
    opacity: 0.5;
    pointer-events: none;
  }
</style>