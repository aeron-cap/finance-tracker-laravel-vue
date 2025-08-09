<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto bg-stone-950/60">
        <div class="relative p-4 w-full max-w-4xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Create Expense Record
                    </h3>
                    <button 
                        type="button" 
                        @click="close_modal"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div :class="{ 'disabled-div': loading }" class="p-4 md:p-5 space-y-6">
                    <form @submit.prevent="accept_action" class="space-y-6">
                        <!-- Expense Information Section -->
                        <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Expense Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="expense-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">expense Date</label>
                                    <input 
                                      type="date" 
                                      id="expense-date" 
                                      v-model="expense_data.expense_date"
                                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                      required>
                                </div>
                                
                                <div>
                                    <label for="status-select" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                      Budget Type
                                    </label>
                                    <select 
                                      :id="`budget-type`"
                                      v-model="expense_data.budget_type_id"
                                      @change="update_budget_type()"
                                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                      required>
                                      <option value=null></option>
                                      <option 
                                          v-for="type in expense_budget_types" 
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
                                      v-model="expense_data.amount"
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
                                        v-model="expense_data.account_id"
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
                                        v-model="expense_data.budget_id"
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
                                      v-model="expense_data.description"
                                      rows="2" 
                                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                      placeholder="Describe this expense record..."></textarea>
                                </div>

                            </div>


                        </div>


                    </form>
                </div>
                <div :class="{ 'disabled-div': loading }" class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button
                        @click="accept_action" 
                        type="button" 
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <span v-if="props.id !== null"> Update expense Record </span>
                        <span v-if="props.id == null"> Create expense Record </span>
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
    expense_data.value.budget_id = '',
    expense_data.value.budget_name = ''
  }

    if (props.id > 0) {
      get_budget_types();
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
    const response = await axios.post('api/accounts');
    const raw = response.data.accounts || {};
    accounts.value = Array.isArray(raw) ? raw : Object.values(raw);
  }catch (error) {}
}

function get_budget_types() {
  try {
    axios.post('api/budget_types', {type: 'Expense'}).then((response) => {
      const raw = response.data.budget_types || {};
      expense_budget_types.value = Array.isArray(raw) ? raw : Object.values(raw);
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
  console.log(budgets.value, expense_data.value.budget_id);
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
    !expense_data.value.status_name ||
    !expense_data.value.budget_id || 
    !expense_data.value.budget_name
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