<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center overflow-x-hidden overflow-y-auto bg-black/70 backdrop-blur-sm">
        <div class="relative p-4 w-full max-w-4xl max-h-full">
            <div class="relative bg-slate-800/60 backdrop-blur-md rounded-2xl shadow-2xl border border-gray-700/50 max-h-[90vh] flex flex-col">
                
                <div class="flex items-center justify-between p-6 border-b border-gray-700/50 flex-shrink-0">
                    <h3 class="text-2xl font-bold text-white">
                        {{ props.id ? 'Edit Account' : 'Create Account' }}
                    </h3>
                    <button 
                        type="button" 
                        @click="decline_action"
                        class="text-gray-400 hover:bg-slate-700/50 hover:text-white rounded-lg text-sm w-8 h-8 inline-flex justify-center items-centers transition-colors">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <div :class="{ 'disabled-div': loading }" class="p-6 space-y-6 overflow-y-auto flex-grow">
                    <form @submit.prevent="accept_action" class="space-y-6">
                        <div class="bg-slate-700/30 p-6 rounded-xl border border-gray-700/50">
                            <h4 class="text-lg font-semibold text-white mb-4">Account Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="account-name" class="block mb-2 text-sm font-medium text-gray-300">Account Name</label>
                                    <input 
                                        type="text" 
                                        id="account-name" 
                                        v-model="account_data.name"
                                        class="bg-slate-700/50 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 placeholder-gray-500 transition-all" 
                                        placeholder="Enter account name"
                                        required>
                                </div>
                                
                                <div>
                                    <label for="status-select" class="block mb-2 text-sm font-medium text-gray-300">Select Status</label>
                                    <select 
                                        id="status-select" 
                                        v-model="account_data.status_id"
                                        @change="update_status_name"
                                        class="bg-slate-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all [&>option]:bg-slate-800 [&>option]:text-white"
                                        required>
                                        <option value="" disabled class="bg-slate-800">Choose a status</option>
                                        <option 
                                            v-for="status in statuses" 
                                            :key="status.id" 
                                            :value="status.id"
                                            class="bg-slate-800">
                                            {{ status.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="account-description" class="block mb-2 text-sm font-medium text-gray-300">Description</label>
                                <textarea 
                                    id="account-description"
                                    v-model="account_data.description"
                                    rows="3" 
                                    class="bg-slate-700/50 border border-gray-600 text-white text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 placeholder-gray-500 transition-all" 
                                    placeholder="Describe this account detail..."></textarea>
                            </div>

                            <div class="mt-4">
                                <Chips
                                    :items="budget_types"
                                    v-model="selected_breakdowns[account_name]"
                                    label="Select Breakdown"
                                    @change="handle_breakdown_change"
                                />
                            </div>
                        </div>
                    </form>
                </div>

                <div :class="{ 'disabled-div': loading }" class="flex items-center gap-3 p-6 border-t border-gray-700/50 **sticky bottom-0 bg-slate-800/60 backdrop-blur-md rounded-b-2xl flex-shrink-0**">
                    <button 
                        @click="accept_action" 
                        type="button" 
                        class="px-6 py-3 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-lg transition-all hover:scale-105 hover:shadow-lg hover:shadow-blue-500/50">
                        {{ props.id ? 'Update Account' : 'Create Account' }}
                    </button>
                    <button 
                        @click="decline_action" 
                        type="button" 
                        class="px-6 py-3 text-sm font-medium text-gray-300 bg-slate-700/50 hover:bg-slate-700 rounded-lg border border-gray-600 transition-all">
                        Cancel
                    </button>
                    <button 
                        v-if="props.id !== null"
                        @click="delete_account" 
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
import Chips from './Chips.vue';

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
var account_name = null;

watch(() => props.show, (newValue) => {
    get_statuses();
    get_budget_types();
    if (!newValue || props.id == null) {
        account_data.value.name = '';
        account_data.value.description = '';
        account_data.value.status_id = null;
        account_data.value.status_name = '';
        account_data.value.breakdown = '';
    }

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

  account_name = data.name;

  build_breakdown_data(data.breakdown, "view");
}

function handle_breakdown_change(selected_items) {
  breakdown_to_save.value[account_name] = selected_breakdowns.value[account_name];
  console.log("handle", breakdown_to_save.value[account_name].length);
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

  if(breakdown_to_save.value[account_name].length > 0) {
    build_breakdown_data(breakdown_to_save.value[account_name], "save");
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