<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto bg-stone-950/60">
        <div class="relative p-4 w-full max-w-4xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Create Account
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
                <div :class="{ 'disabled-div': loading }" class="p-4 md:p-5 space-y-6">
                    <form @submit.prevent="accept_action" class="space-y-6">
                        <!-- Account Information Section -->
                        <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Account Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="account-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Account Name</label>
                                    <input 
                                        type="text" 
                                        id="account-name" 
                                        v-model="account_data.name"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                        placeholder="Enter account name"
                                        required>
                                </div>
                                
                                <div>
                                    <label for="status-select" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Status</label>
                                    <select 
                                        id="status-select" 
                                        v-model="account_data.status_id"
                                        @change="update_status_name"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required>
                                        <option value="" disabled>Choose a status</option>
                                        <option 
                                            v-for="status in statuses" 
                                            :key="status.id" 
                                            :value="status.id">
                                            {{ status.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                <textarea 
                                    id="account-description"
                                    v-model="account_data.description"
                                    rows="2" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                    placeholder="Describe this account detail..."></textarea>
                            </div>

                            <div class="mt-4">
                                <Chips
                                  :items="budget_types"
                                  v-model="selected_breakdowns[account_data.name]"
                                  label="Select Breakdown"
                                  @change="handle_breakdown_change"
                                />
                            </div>
                        </div>
                    </form>
                </div>
                <div :class="{ 'disabled-div': loading }" class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button 
                        @click="accept_action" 
                        type="button" 
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <span v-if="props.id !== null"> Update Account </span>
                        <span v-if="props.id == null"> Create Account </span>
                    </button>
                    <button 
                        @click="decline_action" 
                        type="button" 
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Cancel
                    </button>
                    <button 
                        v-if="props.id !== null"
                        @click="delete_account" 
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
import Chips from './Chips.vue';

onMounted(() => {
    // entities to load
    get_statuses();
    get_budget_types();
});

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    id: {
        type: Number,
        default: null,
    }
});

const emit = defineEmits(['close', 'accept', 'decline']);

const account_data = ref({
    name: '',
    description: '',
    status_id: null,
    status_name: '',
    breakdown: '',
});

const statuses = ref([]);
const budget_types = ref([]);
const loading = ref(false);
const selected_breakdowns = ref([]);
const breakdown_to_save = ref([]);

watch(() => props.show, (newValue) => {
    if (!newValue || props.id == null) {
        account_data.value.name = '';
        account_data.value.description = '';
        account_data.value.status_id = null;
        account_data.value.status_name = '';
        account_data.value.breakdown = '';
    }

    // if props.id, get the data
    if (props.id > 0) {
        get_account_data(props.id);
    }
})

async function get_account_data(id) {
  loading.value = true;
  try {
    const response = await axios.get(`api/account/${id}`);
    let account_from_db = response.data.account || [];

    if (Object.keys(account_from_db).length > 0) {
    // set the data
    set_account_data(account_from_db);
  }
  } catch (error) {
    console.error('Error fetching accounts', error);
  }
  loading.value = false;
};

function set_account_data(data) {
  account_data.value.name = data.name;
  account_data.value.description = data.description;
  account_data.value.status_id = data.status_id;
  account_data.value.status_name = data.status.name;

  build_breakdown_data(data.breakdown, "view");
}

function handle_breakdown_change(selected_items) {
  breakdown_to_save.value[account_data.value.name] = selected_breakdowns.value[account_data.value.name];
}

function decline_action() {
  emit('decline');
}

function delete_account() {
  if(props.id > 0) {
    try {
      axios.post(`/api/account-delete/${props.id}`, account_data.value).then((response) => {
        close_modal();
      });
  } catch (err) {}
  }
}

function build_breakdown_data(types, transaction) {
  if (transaction == "save") {
    let type_names = [];
    for (let i in types) {
      let type = types[i];
      type_names.push(type.name);
    }
    account_data.value.breakdown = JSON.stringify(type_names);
    
  } else if (transaction == "view") {
    let breakdown_json = JSON.parse(types);
    
    selected_breakdowns.value[account_data.value.name] = [];

    for (let j in breakdown_json) {
      let breakdown_type = breakdown_json[j];
      for (let i in budget_types.value) {
        let budget_type = budget_types.value[i];
        if (budget_type.name == breakdown_type) {
          selected_breakdowns.value[account_data.value.name].push(budget_type);
          break;
        }
      }
    }
  }
}

function accept_action() {
  if (!account_data.value.name || !account_data.value.description || !account_data.value.status_id) {
    alert('Please fill all the required fields');
    return;
  }

  if(breakdown_to_save.value[account_data.value.name].length > 0) {
    build_breakdown_data(breakdown_to_save.value[account_data.value.name], "save");
  }

  if (props.id > 0) {
    try {
      axios.post(`api/account/${props.id}`, account_data.value).then((response) => {

        emit('accept', {
          ...account_data.value
        });
      })
    }catch (error) {}
  } else {
    try {
      axios.post("api/account", account_data.value).then((response) => {
    
        emit('accept', {
          ...account_data.value
        });
      })
    } catch (error) {}
  }
}

async function get_statuses() {
  try {
    const response = await axios.get('api/statuses');
    statuses.value = response.data.status || [];
  }catch (error) {}
}

async function get_budget_types() {
  try {
    const response = await axios.get('api/budget_types');
    budget_types.value = response.data.budget_types || [];
  }catch (error) {}
}

function close_modal() {
  emit('close');
}

</script>

<style scoped>
  .disabled-div {
    opacity: 0.5;
    pointer-events: none;
  }
</style>